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
use PDF;
use Staff\Models\Employees\Employee;
use Staff\Models\Settings\HrReport;

class PayrollProcessController extends Controller
{
    private $employees;
    private $employee_id;
    private $from_date;
    private $to_date;
    private $get_data_attendance;
    private $fixed; 
    private $category; 
    private $temporary; 
    private $salary_components;  
    private $payroll_date;
    private $net;
    private $salary_mode;
    private $salary_bank_name;
    private $bank_account;
    private $value;
    private $days_attendance;
    private $other_pattern;
    private $other_replacement;
    private $salary_per_day;
    private $salary;    
    private $bus;    

    
    public function index()
    {
        if (request()->ajax()) {
            $data = DB::table('total_payroll_view')->get();

            return datatables($data)
                    ->addIndexColumn()
           
                    ->addColumn('payrollSheet',function($data){
                        $sheet_name = session('lang') == 'ar' ? $data->ar_sheet_name : $data->en_sheet_name; 
                        return '<a href="'.route('payroll-process.show',$data->code).'" >'.$sheet_name.'</a>';
                    })
                    ->addColumn('username',function($data){
                        return $data->username . '<br>' . $data->created_at;
                    })
                    ->addColumn('reports',function($data){
                        return $this->reports($data);
                    })
                    ->addColumn('confirm',function($data){
                        $username = empty($data->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->username;
                        return '<div class="badge badge-danger round">
                                    <span>'.trans('staff::local.not_confirmed').'</span>
                                    <i class="la la-hourglass-1 font-medium-2"></i>
                                </div>' .$username;   
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="code[]" value="'.$data->code.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','payrollSheet','username','reports','confirm'])
                    ->make(true);
        }
        return view('staff::payrolls.process-payroll.index',
        ['title'=>trans('staff::local.process_payroll')]);  
    }
    public function show($code)
    {
        $salary_components = SalaryComponent::has('payrollComponent')->sort()->get();

        $employees = Employee::work()->with('payrollComponents')
        ->whereHas('payrollComponents',function($q) use ($code){
            $q->where('code',$code);                                    
        })
        ->orderBy('attendance_id','asc')        
        ->get();

        $title = trans('staff::local.employees_payrolls');

        return view('staff::payrolls.process-payroll.show',
        compact('employees','title','salary_components'));
    }
    private function reports($data)
    {
        return '<div class="btn-group mr-1 mb-1">
                <button type="button" class="btn btn-primary"> '.trans('student::local.reports').'</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">                    
                    <a target="_blank" class="dropdown-item" href="'.route('payroll-report.all',$data->code).'"><i class="la la-print"></i> '.trans('staff::local.total_payroll_report').'</a>                                             
                    <a target="_blank" class="dropdown-item" href="'.route('employee.experience',$data->code).'"><i class="la la-print"></i> '.trans('staff::local.department_payroll_report').'</a>                                
                    <a target="_blank" class="dropdown-item" href="'.route('employee.leave',$data->code).'"><i class="la la-print"></i> '.trans('staff::local.employee_payroll_report').'</a>                    
                </div>
            </div>';
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
        set_time_limit(0);
        
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
        // dd($this->from_date);
        if ($this->get_data_attendance() == 0) {
            toast(trans('staff::local.no_attendance_records'),'error');
            return back()->withInput();
        }

        $this->employees = Employee::with('payrollSheetEmployee')
        ->whereHas('payrollSheetEmployee',function($q){
            $q->where('payroll_sheet_id',request('payroll_sheet_id'));
        })
        ->work()        
        ->where('salary_suspend','no')
        ->orderBy('attendance_id')
        ->get();        

        if (count($this->employees) == 0) {
            toast(trans('staff::local.no_employees_found'),'error');
            return back()->withInput();
        }
        
        DB::transaction(function(){
            $where = [
                // ['type', 'variable'],
                ['registration', 'payroll'],
            ];
            $salary_components = SalaryComponent::where($where)->sort()->get();    
            
            foreach ($this->employees as $employee) {
                $this->employee_id = $employee->id;
                $this->getData();
                
                foreach ($salary_components as $salary_component) {                    
                    $this->value = $this->getAmountByFormula($salary_component->id,$salary_component->formula,$salary_component->sort);
                    
                    $calculate = $salary_component->calculate == trans('staff::local.net_type') ? 'net' : '';
                    
                    $value = number_format($this->value, 2, '.', '');                    
                    // $value = $this->value;                    

                    $this->storePayrollComponent($calculate , $value, $this->employee_id, $salary_component->id,$salary_component->sort);
                }
            }
            //  set fixed and temporary for employees that not exist in fixed and temporary components
            $this->storeEmployeesNotInFixedTemporaryTables();
        });
        toast(trans('staff::local.payroll_process_done'),'success');
        return redirect()->route('payroll-process.index');               
        
    }
    private function storeEmployeesNotInFixedTemporaryTables()
    {
        $employees_fixed = Employee::whereDoesntHave('fixedComponent')->with('payrollSheetEmployee')
        ->whereHas('payrollSheetEmployee',function($q){
            $q->where('payroll_sheet_id',request('payroll_sheet_id')) ;
        })
        ->get();
        $salary_components_fixed = SalaryComponent::fixed()->sort()->employee()->get();                      
        foreach ($employees_fixed as $employee) {
            foreach ($salary_components_fixed as $comp_id) {
                $this->storePayrollComponent('' , 0, $employee->id, $comp_id->id,$comp_id->sort);                
            }          
        }
        $employees_temporary = Employee::whereDoesntHave('temporaryComponent')->with('payrollSheetEmployee')
        ->whereHas('payrollSheetEmployee',function($q){
            $q->where('payroll_sheet_id',request('payroll_sheet_id')) ;
        })
        ->get();
        $salary_components_variable = SalaryComponent::variable()->sort()->employee()->get();
        foreach ($employees_temporary as $employee) {            
            foreach ($salary_components_variable as $comp_id) {
                $this->storePayrollComponent('' , 0, $employee->id, $comp_id->id,$comp_id->sort);                
            }
        }
    }
    
    private function prePayrollProcess()
    {
        $this->preparePeriodDates();
        $this->categoryTypes();
        $this->fixedComponents();
        $this->temporaryComponents();
        $this->salaryComponents();                       
    }

    private function fixedComponents()
    {        
        $this->fixed = FixedComponent::get();     
    }

    private function temporaryComponents()
    {
        $this->temporary = TemporaryComponent::whereBetween('date',[$this->from_date,$this->to_date])
        ->groupBy('employee_id','salary_component_id')
        ->selectRaw('sum(amount) as amount, employee_id,salary_component_id')
            ->get();
        
    }
    private function categoryTypes()
    {
        $this->category = SalaryComponent::where('calculate','earn')->orWhere('calculate','deduction')->get();
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
            
            $this->from_date = Carbon\Carbon::create( $this_year, $this_month, $from_day , 0, 0, 0);
            // get to date
            $this->to_date = Carbon\Carbon::create($year, $next_month, $to_day, 0, 0, 0);  
            
            if (!empty(request('from_date')) && !empty(request('to_date'))) {
                $this->from_date = request('from_date');
                $this->to_date = request('to_date');         
            }
        }
        
        $month_name = date("F", strtotime( $this->to_date));
        
        $year_name = date("Y", strtotime( $this->to_date));
        
        $this->payroll_date = $month_name.'-'.$year_name;
    }

    private function getData()
    {
        $this->get_data_attendance(); // i will check this method if not important to call again

        $this->call_methods();

        foreach($this->employees as $employee)
        {
            if ($employee->id == $this->employee_id) {                
                $this->salary                   = round($employee->salary);
                $this->salary_per_day           = $employee->salary/30;                
                $this->bus                      = empty($employee->bus_value) ?0:$employee->bus_value;                     
                $this->salary_mode              = $employee->salary_mode;
                $this->salary_bank_name         = $employee->salary_bank_name;
                $this->bank_account             = $employee->bank_account;                
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

    private function getAmountByFormula($salary_component_id,$formula)
    {        
        $formula_value = $this->prepareFormula($formula);
        if (empty($formula_value)) {
            $formula_value = 0;
        }
      
        if (strrchr($formula_value,'{') == $formula) {
            // return 'Error In Formula';
            toast(trans('staff::local.invalid_formula'),'error');
            return redirect('/')->withInput();
        }else{            
            $str = DB::select('select '. $formula_value .' as formula');            
            $value = (float)$str[0]->formula;
            if ($salary_component_id == $this->net) {   
                           
                $value = (float)$str[0]->formula + 
                $this->calculateComponents($this->temporary)+ 
                $this->calculateComponents($this->fixed);
            }
            return $value ;
        }

    }
    private function prepareFormula($formula)
    {
        $pattern = $this->pattern();
        $replacement = $this->replacement();        
        return preg_replace( $pattern, $replacement, $formula);
    }
    private function loadPattern()
    {
        $this->other_pattern = DB::table('external_codes')->select('pattern')->get();
    }

    public function pattern()
    {
        $this->loadPattern();        
        $pattern = array();
        $pattern[0] = '/{salary}/';
        $pattern[1] = '/{salary_per_day}/';        
        $pattern[3] = '/{days_attendance}/';
        $pattern[4] = '/{loans}/';
        $pattern[5] = '/{deductions}/';
        $pattern[6] = '/{num_actual_absences}/';
        $pattern[7] = '/{num_calculated_absences}/';
        $pattern[8] = '/{num_no_attend}/';
        $pattern[9] = '/{num_no_leave}/';
        $pattern[10] = '/{num_minutes_late}/';
        $pattern[11] = '/{num_leave_early}/';        
        $pattern[12] = '/{bus}/';        

        foreach ($this->other_pattern as $value) {
            $pattern[] = "/{".$value->pattern ."}/";
        }
        return $pattern;
    }

    private function loadReplacement()
    {
        $this->other_replacement = DB::table('external_codes')->select('replacement')->get();
    }

    public function replacement()
    {
        $this->loadReplacement();
        $replacement = array();
        $replacement[0] = $this->salary;
        $replacement[1] = $this->salary_per_day;        
        $replacement[3] = $this->days_attendance;
        $replacement[4] = $this->loans();
        $replacement[5] = $this->deductions();
        $replacement[6] = $this->num_actual_absences();
        $replacement[7] = $this->num_calculated_absences();
        $replacement[8] = $this->num_no_attend();
        $replacement[9] = $this->num_no_leave();
        $replacement[10] = $this->num_minutes_late();
        $replacement[11] = $this->num_leave_early();        
        $replacement[12] = $this->bus;    

        foreach ($this->other_replacement as $value) {
            $replacement[] = $value->replacement;
        }
        return $replacement;
    }
    private function calculateComponents($component_type)
    {        
        $amounts = array();
        $calculate = '';
      
        if ($component_type != null ) {  
            foreach ($component_type as $type) {
                $component = SalaryComponent::findOrFail($type->salary_component_id);
                

                if ($type->employee_id == $this->employee_id) {                    
                    foreach ($this->category as $category) {
                        if ($category->id == $type->salary_component_id) {
                            // insert

                            $this->storePayrollComponent( $calculate,$type->amount, $type->employee_id, $type->salary_component_id,$component->sort);

                            // end insert
                            if ($category->calculate == trans('staff::local.deduction_type')) {
                                $amounts[] = $type->amount * -1;
                            }else{
                                $amounts[] = $type->amount;
                            }
                        }
                    }
                }
            }
            return array_sum($amounts);
        }
        return 0;
    }

    private function storePayrollComponent($calculate , $value, $employee, $salary_component_id, $sort)
    {
        // store in payroll components
        request()->user()->payrollComponent()->firstOrCreate([
            'value'                 => $value,                                        
            'period'                => $this->payroll_date,
            'from_date'             => $this->from_date,
            'to_date'               => $this->to_date,
            'employee_id'           => $employee,
            'salary_component_id'   => $salary_component_id,
            'payroll_sheet_id'      => request('payroll_sheet_id'),
            'code'                  => $this->payroll_date.request('payroll_sheet_id'),
            'salary_mode'           => $this->salary_mode,
            'salary_bank_name'      => $this->salary_bank_name,
            'salary_bank_account'   => $this->bank_account,    
            'total_employees'       => count($this->employees),                                    
            'calculate'             => $calculate,                                    
            'sort'                  => $sort,                                    
        ]);
    }

    // parameters

    public function days_attendance()
    {
        foreach($this->get_data_attendance as $row)
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
    private function get_data_attendance()
    {        
        $this->get_data_attendance  = DB::table('last_main_view')
        ->whereBetween('selected_date',[$this->from_date,$this->to_date])->get();
        return count($this->get_data_attendance);
    }

    public function num_actual_absences()
    {
        foreach($this->get_data_attendance as $row)
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
        return count($data);
    }
    public function num_calculated_absences()
    {
        foreach($this->get_data_attendance as $row)
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
        return array_sum($data);
    }
    public function num_no_attend()
    {
        foreach($this->get_data_attendance as $row)
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
        return count($data);
    }
    public function num_no_leave()
    {
        foreach($this->get_data_attendance as $row)
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
        return count($data);
    }
    public function num_minutes_late()
    {
        foreach($this->get_data_attendance as $row)
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
        return array_sum($data);
    }
    public function num_leave_early()
    {
        foreach($this->get_data_attendance as $row)
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
        return count($data);
    }

    public function destroy()
    {        
        if (request()->ajax()) {
            if (request()->has('code'))
            {
                foreach (request('code') as $code) {                    
                    PayrollComponent::where('code',$code)->delete();
                }
            }
        }
        return response(['status'=>true]);
    }

    public function allEmployeesReport($code)
    {
        $payroll_sheet_data = PayrollComponent::with('payrollSheet')->where('code',$code)->first();        
        $salary_components = SalaryComponent::has('payrollComponent')->sort()->get();

        $employees = Employee::with('sector','department')->work()->with('payrollComponents')
        ->whereHas('payrollComponents',function($q) use ($code){
            $q->where('code',$code);                                    
        })
        ->orderBy('attendance_id','asc')        
        ->get();

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.payroll_sheet'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'salary_components'             => $salary_components,                
            'employees'                     => $employees,                                   
            'payroll_sheet_data'            => $payroll_sheet_data,                                   
        ];

        $config = [
            'orientation'          => 'L',
            'margin_header'        => 5,
            'margin_footer'        => 5,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 50,
            'margin_bottom'        => 8,
        ]; 

        $pdf = PDF::loadView('staff::payrolls.process-payroll.reports.all-employees', $data,[],$config);
        return $pdf->stream(trans('staff::local.payroll_sheet'));
    }

}
