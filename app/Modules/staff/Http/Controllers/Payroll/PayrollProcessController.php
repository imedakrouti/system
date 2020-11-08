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
use Staff\Models\Payrolls\PayrollSheetEmployee;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\HrReport;
use Staff\Models\Settings\Sector;

class PayrollProcessController extends Controller
{
    private $employees;
    private $employee_id;
    private $from_date;
    private $to_date;
    private $get_data_attendance;
    private $late_absent_value; 
    private $count_vacation; 
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
    private $sa_per_day;
    private $salary;    
    private $bus;
    private $insurance;
    private $tax;
    private $payroll_sheet_id;  
    private $output;

    
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
                        return $data->username ;
                        // . '<br>' . $data->created_at;
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
        $sectors = Sector::sort()->get();            
        $departments = Department::sort()->get();
        $title = trans('staff::local.process_payroll');
        return view('staff::payrolls.process-payroll.index',
        compact('sectors','departments','title'));  
    }
    public function show($code)
    {
        $payroll_sheet_data = PayrollComponent::with('payrollSheet')->where('code',$code)->first();        
        $salary_components = SalaryComponent::where('payroll_sheet_id',$payroll_sheet_data->payroll_sheet_id)->sort()->get();

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
                    <a onclick="departmentReport('."'$data->code'".')" class="dropdown-item" href="#"><i class="la la-print"></i> '.trans('staff::local.department_payroll_report').'</a>                                                    
                    <a class="dropdown-item" href="'.route('payroll-report.bank',$data->code).'"><i class="la la-print"></i> '.trans('staff::local.payroll_bank').'</a>                                             
                    <a target="_blank" class="dropdown-item" href="'.route('payroll-report.cash',$data->code).'"><i class="la la-print"></i> '.trans('staff::local.payroll_cash').'</a>                                                                 
                </div>
            </div>';
    }
    public function create()
    {
        if (request()->ajax()) {
            $data = Employee::whereDoesntHave('payrollSheetEmployee')
            ->where('salary_suspend','no')->work()->get();  
            return $this->dataTable($data);
        }
        $payrollSheets = PayrollSheet::all();
        $title = trans('staff::local.process_payroll');
        return view('staff::payrolls.process-payroll.create',
        compact('payrollSheets','title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('employee_name',function($data){
            return $this->getFullEmployeeName($data);
        })
        ->addColumn('employee_image',function($data){
            return $this->employeeImage($data);
        })
        ->addColumn('working_data',function($data){
            return $this->workingData($data);
        })
        ->addColumn('position',function($data){
            return !empty($data->position->ar_position)?
            (session('lang') == 'ar'?$data->position->ar_position:$data->position->en_position):'';
        })
        ->rawColumns(['employee_name','working_data','position','employee_image'])
        ->make(true);
    }
    private function getFullEmployeeName($data)
    {
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->ar_st_name . ' ' . $data->ar_nd_name.
            ' ' . $data->ar_rd_name.' ' . $data->ar_th_name.'</a>';
        }else{
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->en_st_name . ' ' . $data->en_nd_name.
            ' ' . $data->th_rd_name.' ' . $data->th_th_name.'</a>';
        }
        return $employee_name;
    }
    private function workingData($data)
    {
        $sector = '';
        if (!empty($data->sector->ar_sector)) {
            $sector = session('lang') == 'ar' ?  '<span class="blue">'.$data->sector->ar_sector . '</span>': '<span class="blue">'.$data->sector->en_sector . '</span>';            
        }
        $department = '';
        if (!empty($data->department->ar_department)) {
            $department = session('lang') == 'ar' ?  '<span class="purple">'.$data->department->ar_department . '</span>': '<span class="blue">'.$data->department->en_department . '</span>';            
        }
        $section = '';
        if (!empty($data->section->ar_section)) {
            $section = session('lang') == 'ar' ?  '<span class="red">'.$data->section->ar_section . '</span>': '<span class="blue">'.$data->section->en_section . '</span>';            
        }
        return $sector . ' '. $department . '<br>' .  $section ;
    }
    private function employeeImage($data)
    {
        $employee_id = isset($data->id) ? $data->id : $data->employee_id;   
        $image_path = $data->gender == trans('staff::local.male') ? 'images/website/male.png' : 'images/website/female.png';     
        return !empty($data->employee_image)?
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/employeesImages/'.$data->employee_image).'" />
            </a>':
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset($image_path).'" />
            </a>';
    }


    public function store()
    {      
        set_time_limit(0);
        // to avoid error timeout
        ini_set('mysql.connect_timeout', 300);
        ini_set('default_socket_timeout', 300); 
        
        $this->prePayrollProcess();  
        $period = PayrollComponent::where('code',$this->payroll_date.request('payroll_sheet_id'))->first();
        if (!empty($period)) {
            toast(trans('staff::local.payroll_already_done') . '[' . $this->from_date->format('Y-m-d') . '][' . $this->to_date->format('Y-m-d') .']' ,'error');
            return back()->withInput();
        }        
        $where_net = [
                ['calculate' , 'net'],
                ['payroll_sheet_id' , request('payroll_sheet_id')]
        ];
        $net = SalaryComponent::has('payrollSheet')->where($where_net)->first();
        
        if (empty($net)) {
            toast(trans('staff::local.no_net_detected'),'error');
            return back()->withInput();
        }else{
            $this->net = $net->id;
        }
        
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
                ['payroll_sheet_id', request('payroll_sheet_id')],
                ['registration', 'payroll'],
            ];
            $salary_components = SalaryComponent::has('payrollSheet')
            ->where($where)->sort()->get(); 

            $this->get_data_attendance(); // i will check this method if not important to call again    

            foreach ($this->employees as $employee) {
                $this->employee_id = $employee->id;
                $this->getData();
                               
                foreach ($salary_components as $salary_component) {                    
                    $this->value = $this->getAmountByFormula($salary_component->id,$salary_component->formula,$salary_component->sort);
                    
                    $calculate = $salary_component->calculate == trans('staff::local.net_type') ? 'net' : '';
                    
                    $value = number_format($this->value, 2, '.', '');                    
                    // $value = $this->value;    
                    // dd($value);                

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
        // $salary_components_fixed = SalaryComponent::has('payrollSheet')
        // ->where('payroll_sheet_id',request('payroll_sheet_id'))        
        // ->fixed()->sort()->employee()->get();    

        // foreach ($salary_components_fixed as $comp_id) {
        //     $employees_fixed = Employee::with('fixedComponent','payrollSheetEmployee')
        //     ->whereHas('payrollSheetEmployee',function($q){
        //         $q->where('payroll_sheet_id',request('payroll_sheet_id')) ;
        //     })
        //     ->whereHas('fixedComponent',function($q) use ($comp_id){
        //         $q->where('salary_component_id','!=',$comp_id->id) ;
        //     })
        //     ->get();
            
        //     foreach ($employees_fixed as $employee) {
        //         $this->storePayrollComponent('' , 0, $employee->id, $comp_id->id,$comp_id->sort);                
        //     }          
        // }
        $employees_temporary = Employee::whereDoesntHave('temporaryComponent')->with('payrollSheetEmployee')
        ->whereHas('payrollSheetEmployee',function($q){
            $q->where('payroll_sheet_id',request('payroll_sheet_id')) ;
        })
        ->get();
        $salary_components_variable = SalaryComponent::has('payrollSheet')
        ->where('payroll_sheet_id',request('payroll_sheet_id'))
        ->variable()->sort()->employee()->get();
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
        $this->category = SalaryComponent::has('payrollSheet')
        ->where('payroll_sheet_id',request('payroll_sheet_id'))        
        ->where('calculate','earn')->orWhere('calculate','deduction')->get();        
    }

    private function salaryComponents()
    {        
        $salary_components = SalaryComponent::has('payrollSheet')
        ->where('payroll_sheet_id',request('payroll_sheet_id'))        
        ->where('calculate','earn')->orWhere('calculate','deduction')->get();
        foreach($salary_components as $row)
        {
            $this->salary_components[] =  (array) $row;
        }
    }

    private function preparePeriodDates()
    {                     
        if (request()->has('payroll_sheet_id')) {
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
                  
            }            
        }

        if (!empty(request('from_date')) && !empty(request('to_date'))) {            
            $this->from_date = request('from_date');
            $this->to_date = request('to_date');         
        }
      
        $month_name = date("F", strtotime( $this->to_date));
        
        $year_name = date("Y", strtotime( $this->to_date));
        
        $this->payroll_date = $month_name.'-'.$year_name;
    }

    private function getData()
    {        
        $this->call_methods();

        if (is_countable($this->employees)) {
            foreach($this->employees as $employee)
            {
                if ($employee->id == $this->employee_id) {                
                    $this->salary                   = round($employee->salary);
                    $this->sa_per_day               = $employee->salary/30;                
                    $this->bus                      = empty($employee->bus_value) ?0:$employee->bus_value;                     
                    $this->insurance                = empty($employee->insurance_value) ?0:$employee->insurance_value;                     
                    $this->tax                      = empty($employee->tax_value) ?0:$employee->tax_value;                     
                    $this->salary_mode              = $employee->salary_mode;
                    $this->salary_bank_name         = $employee->salary_bank_name;
                    $this->bank_account             = $employee->bank_account;                
                }            
            }                           
        }else{                   
            $this->salary                   = round($this->employees->salary);
            $this->sa_per_day               = $this->employees->salary/30;                
            $this->bus                      = empty($this->employees->bus_value) ?0:$this->employees->bus_value;                     
            $this->insurance                = empty($this->employees->insurance_value) ?0:$this->employees->insurance_value;                     
            $this->tax                      = empty($this->employees->tax_value) ?0:$this->employees->tax_value;                     
            $this->salary_mode              = $this->employees->salary_mode;
            $this->salary_bank_name         = $this->employees->salary_bank_name;
            $this->bank_account             = $this->employees->bank_account;      
        }
    }

    private function call_methods()
    {
        $this->days_attendance();
        $this->late_absent_value();
        $this->count_vacation();
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
                $this->calculateComponents($this->temporary);
                // +$this->calculateComponents($this->fixed);
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
        $pattern[1] = '/{sa_per_day}/';        
        $pattern[3] = '/{days_attend}/';
        $pattern[4] = '/{loans}/';
        $pattern[5] = '/{deduc}/';
        $pattern[6] = '/{actual_abse}/';
        $pattern[7] = '/{calc_abs}/';
        $pattern[8] = '/{no_attend}/';
        $pattern[9] = '/{no_leave}/';
        $pattern[10] = '/{min_late}/';
        $pattern[11] = '/{le_early}/';        
        $pattern[12] = '/{bus}/';        
        $pattern[13] = '/{insu}/';        
        $pattern[14] = '/{tax}/';        

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
        $replacement[1] = $this->sa_per_day;        
        $replacement[3] = $this->days_attendance;
        $replacement[4] = $this->loans();
        $replacement[5] = $this->deductions();
        $replacement[6] = $this->num_actual_absences() + $this->late_absent_value + $this->count_vacation;
        $replacement[7] = $this->num_calculated_absences();
        $replacement[8] = $this->num_no_attend();
        $replacement[9] = $this->num_no_leave();
        $replacement[10] = $this->num_minutes_late();
        $replacement[11] = $this->num_leave_early();        
        $replacement[12] = $this->bus;    
        $replacement[13] = $this->insurance;    
        $replacement[14] = $this->tax;    

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

                if (request()->has('payroll_sheet_id')) {
                    $this->payroll_sheet_id = request('payroll_sheet_id');
                }
                $component = SalaryComponent::has('payrollSheet')
                ->where('payroll_sheet_id',$this->payroll_sheet_id)
                ->where('id',$type->salary_component_id)
                ->first();
                
                if ($type->employee_id == $this->employee_id) {                    
                    foreach ($this->category as $category) {
                        if ($category->id == $type->salary_component_id) {
                            // insert
                            if (request()->has('payroll_sheet_id')) {
                                $this->storePayrollComponent( $calculate,$type->amount, $type->employee_id, $type->salary_component_id,$component->sort);                                
                            }else{                                
                                $this->output = '<tr class="center"><td>'.$component->ar_item.'</td><td>'.$type->amount.'</td></tr>';                    
                            }
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
                if ($arrays[$i]['absent_after_holidays'] != 'True' && $arrays[$i]['vacation_type'] == '') {
                    $data[] = $arrays[$i]['absent_after_holidays'];
                }
            }
        }
        $this->days_attendance = count($data);        
    }

    public function late_absent_value()
    {
        foreach($this->get_data_attendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['late_absent_value'] == 1) {
                    $data[] = $arrays[$i]['late_absent_value'];
                }
            }
        }
        $this->late_absent_value = count($data);   
    }

    public function count_vacation()
    {
        foreach($this->get_data_attendance as $row)
        {
            $arrays[] =  (array) $row;
        }
        $data = array();
        for ($i=0; $i < count($arrays) ; $i++) {
            if ($arrays[$i]['employee_id'] == $this->employee_id) {
                if ($arrays[$i]['vacation_type'] == 'Start work' || $arrays[$i]['vacation_type'] == 'End work' 
                || $arrays[$i]['vacation_type'] == 'Vacation without pay' || $arrays[$i]['vacation_type'] == 'Sick leave') {
                    $data[] = $arrays[$i]['vacation_type'];
                }
            }
        }    
        $this->count_vacation = count($data);   
    }


    private function loans()
    {
        return Loan::where('employee_id',$this->employee_id)
        ->whereBetween('date_loan',[$this->from_date,$this->to_date])
        ->where('approval1','Accepted')
        ->where('approval2','Accepted')
        ->sum('amount');
    }
    private function deductions()
    {
        return Deduction::where('employee_id',$this->employee_id)
        ->whereBetween('date_deduction',[$this->from_date,$this->to_date])
        ->where('approval1','Accepted')
        ->where('approval2','Accepted')
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
                if ($arrays[$i]['absent_after_holidays'] == 'True' && $arrays[$i]['vacation_type'] == '') {
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
                if ($arrays[$i]['no_attend'] == 1 && $arrays[$i]['no_leave'] == 0 && $arrays[$i]['vacation_type'] == '') {
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
                if ($arrays[$i]['no_attend'] == 0 && $arrays[$i]['no_leave'] == 1 && $arrays[$i]['vacation_type'] == '') {
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
                if ($arrays[$i]['leave_mins'] != 0  && $arrays[$i]['target'] != 'early') {
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
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $payroll_sheet_data = PayrollComponent::with('payrollSheet')->where('code',$code)->first();        
        $salary_components = SalaryComponent::where('payroll_sheet_id',$payroll_sheet_data->payroll_sheet_id)->sort()->get();

        $employees = Employee::with('sector','department')->work()->with('payrollComponents')
        ->whereHas('payrollComponents',function($q) use ($code,$payroll_sheet_data){
            $q->where('code',$code);                                    
            $q->where('payroll_sheet_id',$payroll_sheet_data->payroll_sheet_id);
        })
        ->orderBy('attendance_id','asc')               
        ->get();

        $totals = DB::table('payroll_components')->select(DB::raw('salary_component_id,sum(value) as sum,sort'))
        ->where('payroll_sheet_id',$payroll_sheet_data->payroll_sheet_id)        
        ->groupBy('salary_component_id','sort')
        ->orderBy('sort')
        ->get();


        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.payroll_sheet'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'salary_components'             => $salary_components,                
            'employees'                     => $employees,                                   
            'payroll_sheet_data'            => $payroll_sheet_data,                                   
            'totals'                        => $totals,                                   
        ];

        $config = [
            'orientation'          => 'L',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 60,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::payrolls.process-payroll.reports.all-employees', $data,[],$config);
        return $pdf->stream(trans('staff::local.payroll_sheet').'.pdf');
    }

    public function departmentPayrollReport()
    {
        $code           = request('code');
        $sector_id      = request('sector_id');
        $department_id  = request('department_id');
        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $payroll_sheet_data = PayrollComponent::with('payrollSheet')->where('code',$code)->first();        
        $salary_components = SalaryComponent::where('payroll_sheet_id',$payroll_sheet_data->payroll_sheet_id)->sort()->get();

        $totals = DB::table('payroll_components')->select(DB::raw('salary_component_id,sum(value) as sum,sort'))
        ->where('payroll_sheet_id',$payroll_sheet_data->payroll_sheet_id)
        ->join('employees','payroll_components.employee_id','=','employees.id')        
        ->where('employees.department_id',$department_id)
        ->groupBy('salary_component_id','sort')
        ->orderBy('sort')
        ->get();
        

        $department = Department::findOrFail($department_id);
        $department_name = session('lang') == 'ar' ? $department->ar_department : $department->en_department;

        $employees = Employee::with('sector','department')->work()->with('payrollComponents')
        ->whereHas('payrollComponents',function($q) use ($code){
            $q->where('code',$code);                                    
        })
        ->where('sector_id',$sector_id)
        ->where('department_id',$department_id)
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
            'department_name'               => $department_name,                                   
            'totals'                        => $totals,                                   
        ];

        $config = [
            'orientation'          => 'L',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 60,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 

        // to avoid error timeout
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::payrolls.process-payroll.reports.department', $data,[],$config);
        return $pdf->stream(trans('staff::local.payroll_sheet').'.pdf');
    }
    public function review()
    {
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $title = trans('staff::local.review_payroll');
        return view('staff::payrolls.process-payroll.review-salary',
        compact('employees','title')); 
    }
    public function setSalaryReview()
    {        
        if (request()->ajax()) {
            set_time_limit(0);            
            $output = '';          
          
            $this->prePayrollProcess();  

       
            $this->employees = Employee::work()->where('salary_suspend','no')
            ->where('id',request('employee_id'))->first();
            if (!empty($this->employees)) {
                $this->employee_id = $this->employees->id;    
                $payroll_sheet_id = PayrollSheetEmployee::where('employee_id',$this->employee_id)->first()->payroll_sheet_id;   

                $this->payroll_sheet_id = $payroll_sheet_id;

                $where_net = [
                    ['calculate' , 'net'],
                    ['payroll_sheet_id' , $payroll_sheet_id]
                ];
                $net = SalaryComponent::has('payrollSheet')->where($where_net)->first();
                $this->net = $net->id;
                
                $where = [                
                    ['payroll_sheet_id', $payroll_sheet_id],
                    ['registration', 'payroll'],
                ];

                $salary_components = SalaryComponent::has('payrollSheet')->where($where)->sort()->get();                   
                

                $this->getData();             
                foreach ($salary_components as $salary_component) {                    
                    $this->value = $this->getAmountByFormula($salary_component->id,$salary_component->formula,$salary_component->sort);                                        
                    $value = number_format($this->value, 2, '.', '');  
                    $output .= $this->output;                                     
                    $output .= '<tr class="center"><td>'.$salary_component->ar_item.'</td><td>'.$value.'</td></tr>';                    
                }                
            }
            return json_encode($output);          
        }
    

    }

}
