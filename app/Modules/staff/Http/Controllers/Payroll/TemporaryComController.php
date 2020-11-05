<?php

namespace Staff\Http\Controllers\Payroll;
use App\Http\Controllers\Controller;
use App\Http\Requests\TemporaryRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Payrolls\TemporaryComponent;
use Staff\Models\Settings\SalaryComponent;

class TemporaryComController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = TemporaryComponent::with('employees','salaryComponents','admin')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('employee_name',function($data){
                        return $this->getFullEmployeeName($data->employees);
                    })
                    ->addColumn('salary_component',function($data){
                        return session('lang') == 'ar' ? $data->salaryComponents->ar_item : $data->salaryComponents->en_item;
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
                    ->rawColumns(['check','employee_name','salary_component','username'])
                    ->make(true);
        }
        return view('staff::payrolls.temporary-component.index',
        ['title'=>trans('staff::local.temporary_components')]);   
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

    public function create()
    {
        $title = trans('staff::local.add_temporary_component');
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $components = SalaryComponent::variable()->employee()->sort()->get();
        return view('staff::payrolls.temporary-component.create',
        compact('title','employees','components'));
    }

    private function attributes()
    {
        return [
            'date',
            'remark',                      
            'salary_component_id',            
        ];
    }

    public function store(TemporaryRequest $request)
    {        
        foreach (request('employee_id') as $employee_id) {            
            $request->user()->temporaryComponent()->firstOrCreate($request->only($this->attributes())+
            [
                'employee_id'   => $employee_id,    
                'amount'        => request('amount') * $this->salaryPerDay($employee_id)                      
            ]);    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('temporary-component.index');               
    }
    private function salaryPerDay($employee_id)
    {
        return Employee::findOrFail($employee_id)->salary / 30;
    }
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    TemporaryComponent::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
