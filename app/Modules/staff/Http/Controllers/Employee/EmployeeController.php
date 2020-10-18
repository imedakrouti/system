<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Staff\Http\Requests\EmployeeRequest;
use Staff\Models\Employees\Employee;

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
            $data = Employee::sort()->get();
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
        return view('staff::employees.create',
        ['title'=>trans('staff::local.new_employee')]);
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
            'holiday_id',
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
        $request->user()->employees()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('employees.index');
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
        return view('staff::employees.edit',
        ['title'=>trans('staff::local.edit_employee'),'employee'=>$employee]);
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
        $employee->update($request->only($this->attributes()));
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
