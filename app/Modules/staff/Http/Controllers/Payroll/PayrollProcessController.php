<?php
namespace Staff\Http\Controllers\Payroll;
use App\Http\Controllers\Controller;
use Staff\Models\Employees\Deduction;
use Staff\Models\Employees\Loan;
use DB;
use Staff\Models\Payrolls\FixedComponent;
use Staff\Models\Payrolls\PayrollComponent;
use Staff\Models\Payrolls\PayrollSheet;
use Staff\Models\Payrolls\TemporaryComponent;
use Staff\Models\Settings\SalaryComponent;
use Carbon;
use DateTime;
use Staff\Models\Employees\Employee;

class PayrollProcessController extends Controller
{
    private $employees;
    private $employee_id;
    private $from_date;
    private $to_date;
    private $get_data_attendance;
    private $fixed; 
    private $temporary; 
    private $salary_components;  
    private $payroll_date;
    private $net;
    private $salary_mode;
    private $salary_bank_name;
    private $bank_account;
    private $value;

    
    public function index()
    {
        if (request()->ajax()) {
            $data = PayrollComponent::with('payrollSheet','admin')->get();

            return datatables($data)
                    ->addIndexColumn()
           
                    ->addColumn('payrollSheet',function($data){
                        return session('lang') == 'ar' ? $data->payrollSheet->ar_sheet_name : $data->payrollSheet->en_sheet_name;
                    })
                    ->addColumn('username',function($data){
                        return $data->admin->username . '<br>' . $data->created_at;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','payrollSheet','username'])
                    ->make(true);
        }
        return view('staff::payrolls.process-payroll.index',
        ['title'=>trans('staff::local.process_payroll')]);  
    }
    public function create()
    {
        $payrollSheets = PayrollSheet::all();
        $title = trans('staff::local.process_payroll');
        return view('staff::payrolls.process-payroll.create',
        compact('payrollSheets','title'));
    }

    public function store()
    {      
        $this->prePayrollProcess();  
        $period = PayrollComponent::where('code',$this->payroll_date.request('payroll_sheet_id'))->first();
        if (!empty($period)) {
            toast(trans('staff::local.payroll_already_done') . '[' . $this->from_date->format('Y-m-d') . '][' . $this->to_date->format('Y-m-d') .']' ,'error');
            return back()->withInput();
        }        

        $net = SalaryComponent::where('calculate','net')->first();
        if (empty($net)) {
            toast(trans('staff::local.no_net_detected'),'error');
            return back()->withInput();
        }else{
            $this->net = $net->id;
        }

        if ($this->getDataAttendance() == 0) {
            toast(trans('staff::local.no_attendance_records'),'error');
            return back()->withInput();
        }

        $this->employees = Employee::with('payrollSheetEmployee')
        ->whereHas('payrollSheetEmployee',function($q){
            $q->where('payroll_sheet_id',request('payroll_sheet_id'));
        })
        ->where('salary_suspend','no')
        ->get();

        if (count($this->employees) == 0) {
            toast(trans('staff::local.no_employees_found'),'error');
            return back()->withInput();
        }

        DB::transaction(function(){
            $where = [
                ['type', 'variable'],
                ['registration', 'payroll'],
            ];
            $salary_components = SalaryComponent::where($where)->get();           

            foreach ($this->employees as $employee) {
                $this->employees = $employee->id;

                $this->getData();

                foreach ($salary_components as $salary_component) {
                    $this->value = $this->getAmountByFormula($salary_component->id,$salary_component->formula);

                    request()->user()->payrollComponent()->firstOrCreate([
                        'value'                 => number_format($this->value, 2, '.', ''),
                        'period'                => $this->payroll_date,
                        'from_date'             => $this->from_date,
                        'to_date'               => $this->to_date,
                        'payroll_sheet_id'      => request('payroll_sheet_id'),
                        'employee_id'           => $this->employee_id,
                        'salary_component_id'   => $salary_component->id,
                        'salary_mode'           => $this->salary_mode,
                        'salary_bank_name'      => $this->salary_bank_name,
                        'bank_account'          => $this->bank_account,
                        'code'                  => $this->payroll_date.request('payroll_sheet_id'),
                    ]);
                }
            }
        });
        
    }
    
    private function prePayrollProcess()
    {
        $this->fixedComponents();
        $this->temporaryComponents();
        $this->salaryComponents();        

        // prepare from date and to date
        $this->preparePeriodDates();
    }

    private function fixedComponents()
    {
        $fixed_values = FixedComponent::all();
        foreach($fixed_values as $row)
        {
            $this->fixed[] =  (array) $row;
        }
    }

    private function temporaryComponents()
    {
        $temp_values = TemporaryComponent::all();
        foreach($temp_values as $row)
        {
            $this->temporary[] =  (array) $row;
        }
    }

    private function salaryComponents()
    {        
        $salary_components = SalaryComponent::where('calculate','earn')->orWhere('calculate','deduction')->get();
        foreach($salary_components as $row)
        {
            $this->salary_components[] =  (array) $row;
        }
    }

    private function preparePeriodDates()
    {        
        $payroll_sheet = PayrollSheet::findOrFail(request('payroll_sheet_id'));
        $from_day    = $payroll_sheet->from_day;
        $to_day      = $payroll_sheet->to_day;
       
        $now        = Carbon\Carbon::now();

        $this_month  = $now->month;
        $this_year   = $now->year;
        
        if ($payroll_sheet->end_period == 'End Month') {
            $last_day_of_month = $now->endOfMonth()->isoFormat('Do');
            $this->from_date = Carbon\Carbon::create( $this_year, $this_month, 1, 0, 0, 0);
            $this->to_date = Carbon\Carbon::create($this_year, $this_month, $last_day_of_month, 0, 0, 0);
            
        }else{
            $last_day_of_month = $now->endOfMonth()->isoFormat('Do');
            if ($now <= $last_day_of_month) {
                $now->subDays(40);
                $this_month  = $now->month;
            }
            
            // get from date
            $this->from_date = Carbon\Carbon::create( $this_year, $this_month, $from_day , 0, 0, 0);
            
           
            $now->addMonth();
            $next_month  = $now->month;
            $year       = $now->year;

            if ($now <= $last_day_of_month) {
                $next_month  = $now->month;
            }

            if ($this_month == 12) {
                $now->addYear();
                $year =  $now->year;
            }
            // get to date
            $this->to_date = Carbon\Carbon::create($year, $next_month, $to_day, 0, 0, 0);

            
        }
        
        $month_name = date("F", strtotime( $this->to_date));
        
        $year_name = date("Y", strtotime( $this->to_date));
        
        $this->payroll_date = $month_name.'-'.$year_name;
    }

    private function getData()
    {
        $this->getDataAttendance(); // i will check this method if not important to call again

        $this->call_methods();

        foreach($this->employees as $employee)
        {
            $arrays[] =  (array) $employee;
        }
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                $this->salary                   = round($arrays[$i]['salary']);
                $this->salary_per_day           = $this->salary/30;                
                $this->salary_mode              = $arrays[$i]['salary_mode'];
                $this->salary_bank_name         = $arrays[$i]['salary_bank_name'];
                $this->bank_account             = $arrays[$i]['bank_account'];
            }

        }
    }

    private function call_methods()
    {
        $this->days_attendance();
        $this->loans();
        $this->deductions();
        $this->num_actual_absences();
        $this->num_calculated_absences();
        $this->num_no_attend();
        $this->num_no_leave();
        $this->num_minutes_late();
        $this->num_leave_early();
    }



    // parameters
    private function loans()
    {
        return Loan::where('employee_id',$this->employee_id)
        ->whereBetween('date_loan',[$this->from_date,$this->to_date])
        ->sum('amount');
    }
    private function deductions()
    {
        return Deduction::where('employee_id',$this->employee_id)
        ->whereBetween('date_deduction',[$this->from_date,$this->to_date])
        ->sum('amount');
    }
    private function getDataAttendance()
    {
        $this->get_data_attendance  = DB::table('last_main_view')
        ->whereBetween('selected_date',[$this->from_date,$this->to_date])->get();
        return count($this->get_data_attendance);
    }
    public function daysAttendance()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['absent_after_holidays'] != 'True') {
                    $data[] = $arrays[$i]['absent_after_holidays'];
                }
            }
        }
        $this->days_attendance = count($data);
    }

    public function num_actual_absences()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['absent_after_holidays'] == 'True') {
                    $data[] = $arrays[$i]['absent_after_holidays'];
                }
            }
        }
        if (empty($data)) {
            $this->num_actual_absences = 0;
        }else{
            $this->num_actual_absences = count($data);
        }
    }
    public function num_calculated_absences()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                $data[] = $arrays[$i]['absentValue'];
            }
        }
        if (empty($data)) {
            $this->num_calculated_absences = 0;
        }else{
            $this->num_calculated_absences = array_sum($data);
        }
    }
    public function num_no_attend()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['no_attend'] == 1 && $arrays[$i]['no_leave'] == 0) {
                    $data[] = $arrays[$i]['no_attend'];
                }
            }
        }
        if (empty($data)) {
            $this->num_no_attend = 0;
        }else{
            $this->num_no_attend = count($data);
        }
    }
    public function num_no_leave()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['no_attend'] == 0 && $arrays[$i]['no_leave'] == 1) {
                    $data[] = $arrays[$i]['no_leave'];
                }
            }
        }
        if (empty($data)) {
            $this->num_no_leave = 0;
        }else{
            $this->num_no_leave = count($data);
        }
    }
    public function num_minutes_late()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['main_lates'] != '') {
                    $data[] = $arrays[$i]['main_lates'];
                }
            }
        }
        if (empty($data)) {
            $this->num_minutes_late = 0;
        }else{
            $this->num_minutes_late = array_sum($data);
        }
    }
    public function num_leave_early()
    {
        foreach($this->getDataAttendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['leave_mins'] != 0 ) {
                    $data[] = $arrays[$i]['leave_mins'];
                }
            }
        }
        if (empty($data)) {
            $this->num_leave_early = 0;
        }else{
            $this->num_leave_early = count($data);
        }
    }

}
