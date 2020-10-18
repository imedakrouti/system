<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Staff\Http\Requests\SalaryComponentRequest;
use Staff\Models\Settings\SalaryComponent;

class SalaryComponentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = SalaryComponent::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('salary-components.edit',$data->id).'">
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
        return view('staff::settings.salary-components.index',
        ['title'=>trans('staff::local.salary_components')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.salary-components.create',
        ['title'=>trans('staff::local.new_salary_component')]);
    }
    private function attributes()
    {
        return [    
            'ar_item',
            'en_item',
            'formula',
            'description',
            'sort',
            'type',
            'registration',
            'calculate',
            'admin_id',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SalaryComponentRequest $request)
    {
        $request->user()->salaryComponents()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('salary-components.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SalaryComponent  $salaryComponent
     * @return \Illuminate\Http\Response
     */
    public function edit(SalaryComponent $salaryComponent)
    {
        return view('staff::settings.salary-components.edit',
        ['title'=>trans('staff::local.edit_salary_component'),'salaryComponent'=>$salaryComponent]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SalaryComponent  $salaryComponent
     * @return \Illuminate\Http\Response
     */
    public function update(SalaryComponentRequest $request, SalaryComponent $salaryComponent)
    {
        $salaryComponent->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('salary-components.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SalaryComponent  $salaryComponent
     * @return \Illuminate\Http\Response
     */
    public function destroy(SalaryComponent $salaryComponent)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    SalaryComponent::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
