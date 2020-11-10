<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use Staff\Http\Requests\EmployeeRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Settings\Document;
use Staff\Models\Settings\Holiday;
use Staff\Models\Settings\Position;
use Staff\Models\Settings\Section;
use Staff\Models\Settings\Sector;
use Staff\Models\Settings\Skill;
use Staff\Models\Settings\Timetable;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\HrReport;
use DB;
use PDF;
use Carbon;
use Alkoumi\LaravelArabicTafqeet\Tafqeet;
use App\Models\Admin;
use Staff\Models\Payrolls\PayrollSheet;

class EmployeeController extends Controller
{
    private $employee_image;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Employee::with('sector','section','department','position')
            ->orderBy('attendance_id','asc')
            ->where('leaved','No')
            ->get();
            return $this->dataTable($data);
        }
        $sectors = Sector::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $documents = Document::sort()->get();
        $title = trans('staff::local.employees');
        $timetables = Timetable::all();
        $holidays = Holiday::sort()->get();
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::employees.index',
       compact('sectors','sections','positions','documents','title','timetables','holidays','employees'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('staff::local.new_employee');
        $payrollSheets = PayrollSheet::all();
        $sectors = Sector::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $documents = Document::sort()->get();
        $skills = Skill::sort()->get();
        $holidays = Holiday::sort()->get();
        $timetables = Timetable::all();
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::employees.create',
        compact('title','sectors','sections','positions','timetables','documents','skills','holidays','employees','payrollSheets'));
    }
    private function attributes()
    {
        return[
            'attendance_id',
            'ar_st_name',
            'ar_nd_name',
            'ar_rd_name',
            'ar_th_name',
            'en_st_name',
            'en_nd_name',
            'en_rd_name',
            'en_th_name',
            'email',
            'mobile1',
            'mobile2',
            'dob',
            'gender',
            'address',
            'religion',
            'native',
            'marital_status',
            'health_details',
            'national_id',
            'military_service',
            'hiring_date',
            'job_description',
            'has_contract',
            'contract_type',
            'contract_date',
            'contract_end_date',
            'previous_experience',
            'institution',
            'qualification',
            'social_insurance',
            'social_insurance_num',
            'social_insurance_date',
            'medical_insurance',
            'medical_insurance_num',
            'medical_insurance_date',
            'exit_interview_feedback',
            'leave_date',
            'leave_reason',
            'leaved',
            'salary',
            'salary_suspend',
            'salary_mode',
            'salary_bank_name',
            'bank_account',
            'leave_balance',
            'bus_value',
            'vacation_allocated',            
            'sector_id',
            'department_id',
            'section_id',
            'position_id',
            'timetable_id',
            'admin_id',
            'direct_manager_id', 
            'insurance_value',
            'tax_value'          
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {             
        DB::transaction(function() use ($request){
            $this->uploadEmployeeImage($request->id);
            // create user for employee
            $user_id = Admin::create([
                'name'          => request('en_st_name'),
                'ar_name'       => request('ar_st_name'),
                'domain_role'   => request('domain_role'),
                'username'      => strtolower(str_replace(' ', '', trim(request('en_st_name')))).request('attendance_id'),
                'email'         => request('email'),
                'password'      => 'password'.request('attendance_id'),
                'image_profile' => $this->employee_image,
            ]);

            $employee = [];
            $employee = $request->user()->employees()->firstOrCreate($request->only($this->attributes())+
            ['employee_image' => $this->employee_image ,'user_id' => $user_id->id]);        
            $this->employeeDocuments($employee->id);
            $this->employeeHolidays($employee->id);
            $this->employeeSkills($employee->id);
            if (!empty(request('payroll_sheet_id'))) {
                $request->user()->payrollSheetEmployee()->firstOrCreate([
                    'employee_id'       => $employee->id,
                    'payroll_sheet_id'  => request('payroll_sheet_id')
                ]);
            }
        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('employees.index');
    }

    private function employeeDocuments($employee_id)
    {
        DB::table('employee_documents')->where('employee_id',$employee_id)->delete();
        if (request()->has('document_id'))
        {
            foreach (request('document_id') as  $id) {
                DB::table('employee_documents')->insert([
                    'employee_id'          => $employee_id,
                    'document_id'          => $id                    
                ]);
            }
        }
    }
    private function employeeHolidays($employee_id)
    {
        DB::table('employee_holidays')->where('employee_id',$employee_id)->delete();
        if (request()->has('holiday_id'))
        {
            foreach (request('holiday_id') as  $id) {
                DB::table('employee_holidays')->insert([
                    'employee_id'         => $employee_id,
                    'holiday_id'          => $id                    
                ]);
            }
        }
    }
    private function employeeSkills($employee_id)
    {
        DB::table('employee_skills')->where('employee_id',$employee_id)->delete();
        if (request()->has('skill_id'))
        {
            foreach (request('skill_id') as  $id) {
                DB::table('employee_skills')->insert([
                    'employee_id'       => $employee_id,
                    'skill_id'          => $id                    
                ]);
            }
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {       
        $payrollSheets = PayrollSheet::all(); 
        $title = trans('staff::local.employee_data');
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();        
        $timetables = Timetable::all();
        return view('staff::employees.show',
        compact('employee','title','sectors','departments','sections','positions','timetables','payrollSheets'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {        
        $payrollSheets = PayrollSheet::all(); 
        $title = trans('staff::local.edit_employee');
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();        
        $timetables = Timetable::all();
        $headers = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::employees.edit',
       compact('employee','title','sectors','sections','positions','timetables','departments','headers','payrollSheets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {     
        DB::transaction(function() use ($request,$employee){
            if (request()->has('employee_image')) {
                $this->uploadEmployeeImage($employee->id);                    
                $employee->update($request->only($this->attributes())
                + ['employee_image' => $this->employee_image]);                
            } else{
                $employee->update($request->only($this->attributes()));
            }
            
            $this->employeeDocuments($employee->id);
            $this->employeeHolidays($employee->id);
            $this->employeeSkills($employee->id);
        });
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Employee::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
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
    private function reports($data)
    {
        return '<div class="btn-group mr-1 mb-1">
                <button type="button" class="btn btn-primary"> '.trans('student::local.reports').'</button>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu">                    
                    <a target="_blank" class="dropdown-item" href="'.route('employee.hr-letter',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.hr_letter_form').'</a>                                             
                    <a target="_blank" class="dropdown-item" href="'.route('employee.leave',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_leave_form').'</a>
                    <a target="_blank" class="dropdown-item" href="'.route('employee.experience',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_experience_form').'</a>                                
                    <a target="_blank" class="dropdown-item" href="'.route('employee.vacation',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_vacation_form').'</a>                                
                    <a target="_blank" class="dropdown-item" href="'.route('employee.loan',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_loan_form').'</a>                                
                </div>
            </div>';
    }
    private function dataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
               $btn = '<a class="btn btn-warning btn-sm" href="'.route('employees.edit',$data->id).'">
               <i class=" la la-edit"></i>
           </a>';
                return $btn;
        })
        ->addColumn('employee_name',function($data){
            return $this->getFullEmployeeName($data);
        })
        ->addColumn('employee_image',function($data){
            return $this->employeeImage($data);
        })
        ->addColumn('mobile',function($data){
            return $data->mobile1 .'<br>'.$data->mobile2;
        })
        ->addColumn('working_data',function($data){
            return $this->workingData($data);
        })
        ->addColumn('reports',function($data){
            return $this->reports($data);
        })
        ->addColumn('position',function($data){
            return !empty($data->position->ar_position)?
            (session('lang') == 'ar'?$data->position->ar_position:$data->position->en_position):'';
        })
        ->addColumn('check', function($data){
               $btnCheck = '<label class="pos-rel">
                            <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
        })
        ->rawColumns(['action','check','employee_name','mobile','working_data','position','reports','employee_image'])
        ->make(true);
    }
    public function filter()
    {
        if (request()->ajax()) {
            
            $sector_id = empty(request('sector_id')) ? ['employees.sector_id', NULL] :['sector_id', request('sector_id')]   ;
            $department_id = empty(request('department_id')) ? ['employees.department_id', NULL] :['department_id', request('department_id')]   ;
            $section_id = empty(request('section_id')) ? ['employees.section_id', NULL] :['section_id', request('section_id')]   ;
            $position_id = empty(request('position_id')) ? ['employees.position_id', NULL] :['position_id', request('position_id')]   ;
            $leaved = empty(request('leaved')) ? ['employees.leaved', NULL] :['leaved', request('leaved')]   ;
            
            $whereData = [$sector_id, $department_id, $section_id, $position_id,['leaved', request('leaved')] ];
                    
            
            $data = Employee::with('sector','section','department','position')
            ->where($whereData)         
            ->orderBy('attendance_id','asc')
            ->get();
            return $this->dataTable($data);
        }
    }

    private function uploadEmployeeImage($employee_id)
    {
        if (request()->hasFile('employee_image'))
        {
            $employee = Employee::findOrFail($employee_id);
            $image_path = public_path()."/images/employeesImages/".$employee->employee_image;                                                    
            $this->employee_image = uploadFileOrImage($image_path,request('employee_image'),'images/employeesImages'); 
        } 
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

    public function updateStructure()
    {
        if (request()->ajax()) {            
            $fields = [];
            $fields ['sector_id'] = !empty(request('sector_id'))? request('sector_id'):'';                          
            $fields ['department_id'] = !empty(request('department_id'))? request('department_id'):'';                          
            $fields ['section_id'] = !empty(request('section_id'))? request('section_id'):'';                              
            $fields ['position_id'] = !empty(request('position_id'))?request('position_id'):'';                              
            $fields ['timetable_id'] = !empty(request('timetable_id'))? request('timetable_id'):'';                              
            $fields ['bus_value'] = !empty(request('bus_value'))? request('bus_value'):'';        
            $fields ['insurance_value'] = !empty(request('insurance_value'))? request('insurance_value'):'';        
            $fields ['tax_value'] = !empty(request('tax_value'))? request('tax_value'):'';        
            $fields ['direct_manager_id'] = !empty(request('direct_manager_id'))? request('direct_manager_id'):'';        
            $fields = array_filter($fields);                     
            foreach (request('employee_id') as $employee_id) {   
                Employee::where('id',$employee_id)->update($fields);
                if (request()->has('holiday_id')) {
                    $this->employeeHolidays($employee_id);                    
                }
            }                        
        }
        return response(['status'=>true]);
    }

    public function hrLetterReport($id)
    {
        $header = HrReport::first()->header;
        $footer = HrReport::first()->footer;
        $content = HrReport::first()->hr_letter;
        
        $employee = Employee::where('id',$id)->with('sector','department','section','position')->first();
        
        $employee_name = strip_tags($this->getFullEmployeeName($employee));
        $employee_national_id = $employee->national_id;
        $sector = !empty($employee->sector->ar_sector) ? (session('lang') == 'ar' ? $employee->sector->ar_sector : $employee->sector->en_sector):'';
        $department = !empty($employee->department->ar_department) ? (session('lang') == 'ar' ? $employee->department->ar_department : $employee->department->en_department):'';
        $section = !empty($employee->section->ar_section) ? (session('lang') == 'ar' ? $employee->section->ar_section : $employee->section->en_section):'';
        $position = !empty($employee->position->ar_position) ? (session('lang') == 'ar' ? $employee->position->ar_position : $employee->position->en_position):'';
        
        
        $hiring_date = !empty($employee->hiring_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $employee->hiring_date)->format("Y/m/d"):'';
        $salary = $employee->salary;
        
        $content = str_replace('employee_name',$employee_name ,$content);        
        $content = str_replace('employee_national_id',$employee_national_id ,$content);        
        $content = str_replace('sector',$sector ,$content);        
        $content = str_replace('department',$department ,$content);        
        $content = str_replace('section',$section ,$content);        
        $content = str_replace('position',$position ,$content);        
        $content = str_replace('hiring_date', $hiring_date , $content); 
        $content = str_replace('salary_text', Tafqeet::inArabic($salary,'egp') , $content);        
               
        $content = str_replace('salary', $salary , $content);        

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        $data = [         
            'title'                         => trans('staff::local.hr_letter_form'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'header'                        => $header,               
            'footer'                        => $footer            
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 10,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 50,
            'margin_bottom'        => 10,
        ]; 

        $pdf = PDF::loadView('staff::employees.reports.hr-letter', $data,[],$config);
        return $pdf->stream(trans('staff::local.hr_letter_form'));
    }

    public function vacationReport($id)
    {
        $header = HrReport::first()->header;
        $footer = HrReport::first()->footer;
        $content = HrReport::first()->employee_vacation;
        
        $employee = Employee::where('id',$id)->with('sector','department','section','position')->first();
        
        $employee_name = strip_tags($this->getFullEmployeeName($employee));
        $employee_national_id = $employee->national_id;
        $sector = !empty($employee->sector->ar_sector) ? (session('lang') == 'ar' ? $employee->sector->ar_sector : $employee->sector->en_sector):'';
        $department = !empty($employee->department->ar_department) ? (session('lang') == 'ar' ? $employee->department->ar_department : $employee->department->en_department):'';
        $section = !empty($employee->section->ar_section) ? (session('lang') == 'ar' ? $employee->section->ar_section : $employee->section->en_section):'';
        $position = !empty($employee->position->ar_position) ? (session('lang') == 'ar' ? $employee->position->ar_position : $employee->position->en_position):'';
                
        
        $content = str_replace('employee_name',$employee_name ,$content);        
        $content = str_replace('employee_national_id',$employee_national_id ,$content);        
        $content = str_replace('sector',$sector ,$content);        
        $content = str_replace('department',$department ,$content);        
        $content = str_replace('section',$section ,$content);        
        $content = str_replace('position',$position ,$content);                
        

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        $data = [         
            'title'                         => trans('staff::local.employee_vacation_form'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'header'                        => $header,               
            'footer'                        => $footer            
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 10,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 50,
            'margin_bottom'        => 10,
        ]; 

        $pdf = PDF::loadView('staff::employees.reports.hr-letter', $data,[],$config);
        return $pdf->stream(trans('staff::local.employee_vacation_form'));
    }

    public function leaveReport($id)
    {
        $header = HrReport::first()->header;
        $footer = HrReport::first()->footer;
        $content = HrReport::first()->employee_leave;
        
        $employee = Employee::where('id',$id)->with('sector','department','section','position')->first();
    
        $employee_name = strip_tags($this->getFullEmployeeName($employee));
        $employee_national_id = $employee->national_id;
        $sector = !empty($employee->sector->ar_sector) ? (session('lang') == 'ar' ? $employee->sector->ar_sector : $employee->sector->en_sector):'';
        $department = !empty($employee->department->ar_department) ? (session('lang') == 'ar' ? $employee->department->ar_department : $employee->department->en_department):'';
        $section = !empty($employee->section->ar_section) ? (session('lang') == 'ar' ? $employee->section->ar_section : $employee->section->en_section):'';
        $position = !empty($employee->position->ar_position) ? (session('lang') == 'ar' ? $employee->position->ar_position : $employee->position->en_position):'';
        $hiring_date = !empty($employee->hiring_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $employee->hiring_date)->format("Y/m/d"):'';
        $leave_date = !empty($employee->leave_date)? (\Carbon\Carbon::createFromFormat('Y-m-d', $employee->leave_date)->format("Y/m/d")):'';
        
        $content = str_replace('employee_name',$employee_name ,$content);        
        $content = str_replace('employee_national_id',$employee_national_id ,$content);        
        $content = str_replace('sector',$sector ,$content);        
        $content = str_replace('department',$department ,$content);        
        $content = str_replace('section',$section ,$content);        
        $content = str_replace('position',$position ,$content);                
        $content = str_replace('hiring_date',$hiring_date ,$content);                
        $content = str_replace('leave_date',$leave_date ,$content);                
        

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        $data = [         
            'title'                         => trans('staff::local.employee_leave_form'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'header'                        => $header,               
            'footer'                        => $footer            
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 10,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 50,
            'margin_bottom'        => 10,
        ]; 

        $pdf = PDF::loadView('staff::employees.reports.leave-report', $data,[],$config);
        return $pdf->stream(trans('staff::local.employee_leave_form'));
    }

    public function experienceReport($id)
    {
        $header = HrReport::first()->header;
        $footer = HrReport::first()->footer;
        $content = HrReport::first()->employee_experience;
        
        $employee = Employee::where('id',$id)->with('sector','department','section','position')->first();
        
        $employee_name = strip_tags($this->getFullEmployeeName($employee));
        $employee_national_id = $employee->national_id;
        $sector = !empty($employee->sector->ar_sector) ? (session('lang') == 'ar' ? $employee->sector->ar_sector : $employee->sector->en_sector):'';
        $department = !empty($employee->department->ar_department) ? (session('lang') == 'ar' ? $employee->department->ar_department : $employee->department->en_department):'';
        $section = !empty($employee->section->ar_section) ? (session('lang') == 'ar' ? $employee->section->ar_section : $employee->section->en_section):'';
        $position = !empty($employee->position->ar_position) ? (session('lang') == 'ar' ? $employee->position->ar_position : $employee->position->en_position):'';
        $hiring_date = !empty($employee->hiring_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $employee->hiring_date)->format("Y/m/d"):'';
        $leave_date = !empty($employee->leave_date)? (\Carbon\Carbon::createFromFormat('Y-m-d', $employee->leave_date)->format("Y/m/d")):'';
        
        $content = str_replace('employee_name',$employee_name ,$content);        
        $content = str_replace('employee_national_id',$employee_national_id ,$content);        
        $content = str_replace('sector',$sector ,$content);        
        $content = str_replace('department',$department ,$content);        
        $content = str_replace('section',$section ,$content);        
        $content = str_replace('position',$position ,$content);                
        $content = str_replace('hiring_date',$hiring_date ,$content);                
        $content = str_replace('leave_date',$leave_date ,$content);                
        

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        $data = [         
            'title'                         => trans('staff::local.employee_experience_form'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'header'                        => $header,               
            'footer'                        => $footer            
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 10,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 50,
            'margin_bottom'        => 10,
        ]; 

        $pdf = PDF::loadView('staff::employees.reports.experience-report', $data,[],$config);
        return $pdf->stream(trans('staff::local.employee_experience_form'));
    }

    public function loanReport($id)
    {
        $header = HrReport::first()->header;
        $footer = HrReport::first()->footer;
        $content = HrReport::first()->employee_loan;
        
        $employee = Employee::where('id',$id)->with('sector','department','section','position')->first();
        
        $employee_name = strip_tags($this->getFullEmployeeName($employee));
        $employee_national_id = $employee->national_id;
        $sector = !empty($employee->sector->ar_sector) ? (session('lang') == 'ar' ? $employee->sector->ar_sector : $employee->sector->en_sector):'';
        $department = !empty($employee->department->ar_department) ? (session('lang') == 'ar' ? $employee->department->ar_department : $employee->department->en_department):'';
        $section = !empty($employee->section->ar_section) ? (session('lang') == 'ar' ? $employee->section->ar_section : $employee->section->en_section):'';
        $position = !empty($employee->position->ar_position) ? (session('lang') == 'ar' ? $employee->position->ar_position : $employee->position->en_position):'';
        $hiring_date = !empty($employee->hiring_date) ? \Carbon\Carbon::createFromFormat('Y-m-d', $employee->hiring_date)->format("Y/m/d"):'';
        $leave_date = !empty($employee->leave_date)? (\Carbon\Carbon::createFromFormat('Y-m-d', $employee->leave_date)->format("Y/m/d")):'';
        
        $content = str_replace('employee_name',$employee_name ,$content);        
        $content = str_replace('employee_national_id',$employee_national_id ,$content);        
        $content = str_replace('sector',$sector ,$content);        
        $content = str_replace('department',$department ,$content);        
        $content = str_replace('section',$section ,$content);        
        $content = str_replace('position',$position ,$content);                
        $content = str_replace('hiring_date',$hiring_date ,$content);                
        $content = str_replace('leave_date',$leave_date ,$content);                
        

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        $data = [         
            'title'                         => trans('staff::local.employee_loan_form'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'header'                        => $header,               
            'footer'                        => $footer            
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 10,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 50,
            'margin_bottom'        => 10,
        ]; 

        $pdf = PDF::loadView('staff::employees.reports.loan-report', $data,[],$config);
        return $pdf->stream(trans('staff::local.employee_loan_form'));
    }

    public function leaved()
    {
        if (request()->ajax()) {
            $data = Employee::with('sector','section','department','position')
            ->orderBy('attendance_id','asc')
            ->where('leaved','Yes')
            ->get();
            return $this->dataTable($data);
        }
        $title = trans('staff::local.leaved');        
        return view('staff::employees.leaved',
        compact('title')); 
    }
    public function backToWork()
    {
        if (request()->ajax()) {
            foreach (request('id') as $employee_id) {
                Employee::where('id',$employee_id)->update(['leaved'=>'No','leave_date' => null]);
            }
        }
        return response(['status'=>true]);
    }

    public function trash()
    {
        if (request()->ajax()) {
            $data = Employee::with('sector','section','department','position')
            ->orderBy('attendance_id','asc')            
            ->onlyTrashed()->get();
            return $this->dataTable($data);
        }
        $title = trans('staff::local.employees_trash');        
        return view('staff::employees.trash',
        compact('title')); 
    }
    public function restore()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Employee::where('id',$id)->restore();
                }
            }
        }
        return response(['status'=>true]);
    }

    public function advancedSearchPage()
    {     
        $sectors = Sector::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $documents = Document::sort()->get();
        $skills = Skill::sort()->get();
        $holidays = Holiday::sort()->get();
        $timetables = Timetable::all();
        
        
        $title = trans('staff::local.advanced_search');
        return view('staff::employees.advanced-search',
        compact('sectors','title','sections','positions',
        'documents','skills','holidays','timetables'));
    }
    private function returnDataQuery()
    {
        return ' SELECT * FROM full_employee_data WHERE ar_st_name <> "" ';
    }
    public function search()
    {            
        // filer
            $filter         = array();
            $attribute      = array();

            if (!empty(request('sector_id'))) {
                $filter[] = "'".request('sector_id')."'";
                $attribute[] = 'sector_id';
            }
            if (!empty(request('department_id'))) {
                $filter[] = "'".request('department_id')."'";
                $attribute[] = 'department_id';
            }
            if (!empty(request('section_id'))) {
                $filter[] = "'".request('section_id')."'";
                $attribute[] = 'section_id';
            }
            if (!empty(request('position_id'))) {
                $filter[] = "'".request('position_id')."'";
                $attribute[] = 'position_id';
            }
            if (!empty(request('timetable_id'))) {
                $filter[] = request('timetable_id');
                $attribute[] = 'timetable_id';
            }
            if (!empty(request('leaved'))) {
                $filter[] = "'" .request('leaved') ."'";
                $attribute[] = 'leaved';
            }
            if (!empty(request('has_contract'))) {
                $filter[] = "'" .request('has_contract') ."'";
                $attribute[] = 'has_contract';
            }
            if (!empty(request('contract_type'))) {
                $filter[] = "'" .request('contract_type') ."'";
                $attribute[] = 'contract_type';
            }
            if (!empty(request('salary_mode'))) {
                $filter[] = "'" .request('salary_mode') ."'";
                $attribute[] = 'salary_mode';
            }
            if (!empty(request('salary_suspend'))) {
                $filter[] = "'" .request('salary_suspend') ."'";
                $attribute[] = 'salary_suspend';
            }
            if (!empty(request('social_insurance'))) {
                $filter[] = "'" .request('social_insurance') ."'";
                $attribute[] = 'social_insurance';
            }
            if (!empty(request('medical_insurance'))) {
                $filter[] = "'" .request('medical_insurance') ."'";
                $attribute[] = 'medical_insurance';
            }
        // end filter
            
        // set = or Null
            $filterCounter = count($filter);
            $orderBy = ' order by full_employee_data.attendance_id asc';
            $factor = array();

            if (isset($filter[0])) {$factor[0] = $filter[0] == 'Null'? $attribute[0].' is ' . $filter[0]: $attribute[0].' = ' . $filter[0];}
            if (isset($filter[1])) {$factor[1] = $filter[1] == 'Null'? $attribute[1].' is ' . $filter[1]: $attribute[1].' = ' . $filter[1];}
            if (isset($filter[2])) {$factor[2] = $filter[2] == 'Null'? $attribute[2].' is ' . $filter[2]: $attribute[2].' = ' . $filter[2];}
            if (isset($filter[3])) {$factor[3] = $filter[3] == 'Null'? $attribute[3].' is ' . $filter[3]: $attribute[3].' = ' . $filter[3];}
            if (isset($filter[4])) {$factor[4] = $filter[4] == 'Null'? $attribute[4].' is ' . $filter[4]: $attribute[4].' = ' . $filter[4];}
            if (isset($filter[5])) {$factor[5] = $filter[5] == 'Null'? $attribute[5].' is ' . $filter[5]: $attribute[5].' = ' . $filter[5];}
            if (isset($filter[6])) {$factor[6] = $filter[6] == 'Null'? $attribute[6].' is ' . $filter[6]: $attribute[6].' = ' . $filter[6];}
            if (isset($filter[7])) {$factor[7] = $filter[7] == 'Null'? $attribute[7].' is ' . $filter[7]: $attribute[7].' = ' . $filter[7];}
            if (isset($filter[8])) {$factor[8] = $filter[8] == 'Null'? $attribute[8].' is ' . $filter[8]: $attribute[8].' = ' . $filter[8];}
            if (isset($filter[9])) {$factor[9] = $filter[9] == 'Null'? $attribute[9].' is ' . $filter[9]: $attribute[9].' = ' . $filter[9];}
            if (isset($filter[10])) {$factor[10] = $filter[10] == 'Null'? $attribute[10].' is ' . $filter[10]: $attribute[10].' = ' . $filter[10];}
            if (isset($filter[11])) {$factor[11] = $filter[11] == 'Null'? $attribute[11].' is ' . $filter[11]: $attribute[11].' = ' . $filter[11];}
            
            $where = '';
            $sqlWhere = '';
            $searchWord = empty( request('inputSearch'))? 'null':request('inputSearch');
            
            $searchWord = str_replace('\'', '"', $searchWord);
            for ($i=0; $i < $filterCounter ; $i++) {
                $where .=  ' and '. $factor[$i];
            }
            // field search
            if (request()->has('field')) {
                $filedSearch = request('field');
                
                $filedSearchCount = count(request('field'));
                $logicFactor = $filedSearchCount == 1 ? '' : ' or ';
                
                $sqlWhere .= ' and (';
                // set like or =
                $sql_like = '';
                for ($i=0; $i < $filedSearchCount ; $i++) {
                    if ($filedSearch[$i] == 'attendance_id') {
                        $searchWord = is_numeric($searchWord) ?$searchWord:0;
                        $sql_like = " = " . $searchWord ;
                    }
                    elseif ($filedSearch[$i] == 'national_id') {
                        $searchWord = is_numeric($searchWord) ?$searchWord:0;
                        $sql_like = " = " . $searchWord ;
                    }
                    elseif ($filedSearch[$i] == 'social_insurance_num') {
                        $searchWord = is_numeric($searchWord) ?$searchWord:0;
                        $sql_like = " = " . $searchWord ;
                    }  
                    elseif ($filedSearch[$i] == 'medical_insurance_num') {
                        $searchWord = is_numeric($searchWord) ?$searchWord:0;
                        $sql_like = " = " . $searchWord ;
                    }   
                    elseif ($filedSearch[$i] == 'bank_account') {
                        $searchWord = is_numeric($searchWord) ?$searchWord:0;
                        $sql_like = " = " . $searchWord ;
                    }                                                                     
                    else{
                        $sql_like = " like '%" . $searchWord . "%'";
                    }
                    $sqlWhere .= $logicFactor . '' . $filedSearch[$i] . $sql_like;
                }
                $sqlWhere .= ')';
            }
            $sql = $where . $sqlWhere . $orderBy;
            $sql = str_replace('( or', '(', $sql);
            $data = DB::select($this->returnDataQuery() . $sql) ;
            
            
        // end set = or Null

        return datatables($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
               $btn = '<a class="btn btn-warning btn-sm" href="'.route('employees.edit',$data->id).'">
               <i class=" la la-edit"></i>
           </a>';
                return $btn;
        })
        ->addColumn('employee_name',function($data){
            return $this->getFullEmployeeName($data);
        })
        ->addColumn('employee_image',function($data){
            return $this->employeeImage($data);
        })
        ->addColumn('mobile',function($data){
            return $data->mobile1 .'<br>'.$data->mobile2;
        })
        ->addColumn('working_data',function($data){
            return $this->workingData($data);
        })
        ->addColumn('reports',function($data){
            return $this->reports($data);
        })
        ->addColumn('position',function($data){
            return !empty($data->position->ar_position)?
            (session('lang') == 'ar'?$data->position->ar_position:$data->position->en_position):'';
        })
        ->addColumn('check', function($data){
               $btnCheck = '<label class="pos-rel">
                            <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
        })
        ->rawColumns(['action','check','employee_name','mobile','working_data','position','reports','employee_image'])
        ->make(true);
    }

    public function employeesReports()
    {
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = SEction::sort()->get();
        $title = trans('staff::local.reports');
        return view('staff::employees.reports.reports-page',
        compact('title','sectors','departments','sections'));
    }

    public function contacts()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $where = [
            ['sector_id' ,request('sector_id')],
            ['department_id' ,request('department_id')],
            ['section_id' ,request('section_id')],
        ];
        $employees = Employee::with('sector','department','section','position')->work()
        ->where($where)
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

 

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_contact'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.contacts', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_contact').'.pdf');
    }
    public function insurance()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $where = [
            ['sector_id' ,request('sector_id')],
            ['department_id' ,request('department_id')],
            ['section_id' ,request('section_id')],
            ['social_insurance' ,'yes'],
        ];
        $employees = Employee::with('sector','department','section','position')->work()
        ->where($where)
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

 

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_insurance'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.insurance', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_insurance').'.pdf');
    }
    public function tax()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $where = [
            ['sector_id' ,request('sector_id')],
            ['department_id' ,request('department_id')],
            ['section_id' ,request('section_id')],
            ['tax_value' ,'!=',0],
        ];
        $employees = Employee::with('sector','department','section','position')->work()
        ->where($where)
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

 

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_tax'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.tax', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_tax').'.pdf');
    }
    public function bus()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $employees = Employee::with('sector','department','section','position')->work()        
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

 

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_bus'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.bus', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_bus').'.pdf');
    }
    public function salaries()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $where = [
            ['sector_id' ,request('sector_id')],
            ['department_id' ,request('department_id')],
            ['section_id' ,request('section_id')],            
        ];
        $employees = Employee::with('sector','department','section','position')->work()
        ->where($where)
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

 

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_salaries'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.salaries', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_salaries').'.pdf');
    }
    public function salarySuspended()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
        $employees = Employee::with('sector','department','section','position')->work()        
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_salary_suspended'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.suspended', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_salary_suspended').'.pdf');
    }
    public function noTimetable()
    {        
        if (empty(logo())) {
            toast(trans('staff::local.no_logo_found'),'error');
            return back()->withInput();
        }  
  
        $employees = Employee::with('sector','department','section','position')->work()        
        ->whereNull('timetable_id')
        ->orderBy('attendance_id','asc')               
        ->get();

        $sectors = Sector::findOrFail(request('sector_id'));
        $sector_name = session('lang') == 'ar' ? $sectors->ar_sector : $sectors->en_sector;

        $departments = Department::findOrFail(request('department_id'));
        $department_name = session('lang') == 'ar' ? $departments->ar_department : $departments->en_department;

 

        $header = HrReport::first()->header;        
        $data = [         
            'title'                         => trans('staff::local.employees_no_timetable'),                   
            'logo'                          => logo(),            
            'header'                        => $header,                
            'employees'                     => $employees,                
            'sector_name'                   => $sector_name,                
            'department_name'               => $department_name,                                    
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::employees.reports.timetable', $data,[],$config);
        return $pdf->stream(trans('staff::local.employees_no_timetable').'.pdf');
    }

}
