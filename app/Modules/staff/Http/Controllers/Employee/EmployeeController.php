<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Staff\Http\Requests\EmployeeRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Settings\Document;
use Staff\Models\Settings\Holiday;
use Staff\Models\Settings\Position;
use Staff\Models\Settings\Section;
use Staff\Models\Settings\Sector;
use Staff\Models\Settings\Skill;
use Staff\Models\Settings\Timetable;
use DB;
use Staff\Models\Settings\Department;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Employee::orderBy('attendance_id','asc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('employees.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check'])
                    ->make(true);
        }
        return view('staff::employees.index',
        ['title'=>trans('staff::local.employees')]);   
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
        // dd(request()->all());
        DB::transaction(function() use ($request){
            $employee = [];
            $employee = $request->user()->employees()->firstOrCreate($request->only($this->attributes()));        
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
    public function update(Request $request, Employee $employee)
    {     
        DB::transaction(function() use ($request,$employee){
          
            $employee->update($request->only($this->attributes()));       
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
}
