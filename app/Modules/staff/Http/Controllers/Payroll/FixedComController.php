<?php

namespace Staff\Http\Controllers\Payroll;
use App\Http\Controllers\Controller;
use App\Http\Requests\FixedRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Payrolls\FixedComponent;
use Staff\Models\Settings\SalaryComponent;

class FixedComController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = FixedComponent::with('employees','salaryComponents','admin')->get();
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
        return view('staff::payrolls.fixed-component.index',
        ['title'=>trans('staff::local.fixed_components')]);   
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
        $title = trans('staff::local.add_fixed_component');
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $components = SalaryComponent::fixed()->employee()->sort()->get();
        return view('staff::payrolls.fixed-component.create',
        compact('title','employees','components'));
    }

    private function attributes()
    {
        return [         
            'amount',            
            'salary_component_id',            
        ];
    }

    public function store(FixedRequest $request)
    {
        foreach (request('employee_id') as $employee_id) {            
            $request->user()->fixedComponent()->firstOrCreate($request->only($this->attributes())+
            [
                'employee_id'   => $employee_id,                
            ]);    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('fixed-component.index');               
    }
    
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    FixedComponent::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}