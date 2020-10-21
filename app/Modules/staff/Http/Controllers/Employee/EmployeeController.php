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
            $data = Employee::with('sector','section','department','position')->orderBy('attendance_id','asc')->get();
            return $this->dataTable($data);
        }
        $sectors = Sector::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $documents = Document::sort()->get();
        $title = trans('staff::local.employees');
        $timetables = Timetable::all();
        return view('staff::employees.index',
       compact('sectors','sections','positions','documents','title','timetables'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('staff::local.new_employee');
        $sectors = Sector::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $documents = Document::sort()->get();
        $skills = Skill::sort()->get();
        $holidays = Holiday::sort()->get();
        $timetables = Timetable::all();
        return view('staff::employees.create',
        compact('title','sectors','sections','positions','timetables','documents','skills','holidays'));
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
            $employee = [];
            $employee = $request->user()->employees()->firstOrCreate($request->only($this->attributes())+
            ['employee_image' => $this->employee_image]);        
            $this->employeeDocuments($employee->id);
            $this->employeeHolidays($employee->id);
            $this->employeeSkills($employee->id);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $title = trans('staff::local.edit_employee');
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();        
        $timetables = Timetable::all();

        return view('staff::employees.edit',
       compact('employee','title','sectors','sections','positions','timetables','departments'));
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
            $employee_name = '<a href="'.route('employees.show',$data->id).'">' .$data->ar_st_name . ' ' . $data->ar_nd_name.
            ' ' . $data->ar_rd_name.' ' . $data->ar_th_name.'</a>';
        }else{
            $employee_name = '<a href="'.route('employees.show',$data->id).'">' .$data->en_st_name . ' ' . $data->en_nd_name.
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
                    <a target="_blank" class="dropdown-item" href="'.route('student-report.print',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_leave_form').'</a>
                    <a target="_blank" class="dropdown-item" href="'.route('students.proof-enrollment',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_experience_form').'</a>                                
                    <a target="_blank" class="dropdown-item" href="'.route('students.proof-enrollment',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_vacation_form').'</a>                                
                    <a target="_blank" class="dropdown-item" href="'.route('students.proof-enrollment',$data->id).'"><i class="la la-print"></i> '.trans('staff::local.employee_loan_form').'</a>                                
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
        $image_path = $data->gender == 'male' ? 'images/website/male.png' : 'images/website/female.png';     
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
            $fields = array_filter($fields);                     
            foreach (request('id') as $employee_id) {   
                Employee::where('id',$employee_id)->update($fields);
            }                        
        }
        return response(['status'=>true]);
    }

    public function hrLetterReport($id)
    {
        $header = HrReport::first()->header;
        $footer = HrReport::first()->footer;
        $content = HrReport::first()->hr_letter;
        
        $employee = Employee::findOrFail($id)->with('sector','department','section','position')->first();
        
        $employee_name = strip_tags($this->getFullEmployeeName($employee));
        $employee_national_id = $employee->national_id;
        $position = session('lang') == 'ar' ? $employee->position->ar_position : $employee->position->en_position;
        $hiring_date = \Carbon\Carbon::createFromFormat('Y-m-d', $employee->hiring_date)->format("Y/m/d");
        $salary = $employee->salary;
        
        $content = str_replace('employee_name',$employee_name ,$content);        
        $content = str_replace('employee_national_id',$employee_national_id ,$content);        
        $content = str_replace('position',$position ,$content);        
        $content = str_replace('hiring_date', $hiring_date , $content);        
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

}
