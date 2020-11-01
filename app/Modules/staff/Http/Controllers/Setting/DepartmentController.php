<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Staff\Http\Requests\DepartmentRequest;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\Sector;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Department::with('sector')->sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('departments.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('sector_id',function($data){
                        return session('lang') == 'ar' ? $data->sector->ar_sector : $data->sector->en_sector;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','sector_id'])
                    ->make(true);
        }        
        $title = trans('staff::local.departments');
        return view('staff::settings.departments.index',
        compact('title'));   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sectors =  Sector::sort()->get();
        $title = trans('staff::local.new_department');
        return view('staff::settings.departments.create',
        compact('title','sectors'));   
    }

    private function attributes()
    {
        return ['ar_department','en_department','sort','leave_allocate','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        foreach (request('sector_id') as $sector_id) {
            $request->user()->departments()->create($request->only($this->attributes())+
            ['sector_id' => $sector_id]);        
            
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('departments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        $sectors =  Sector::sort()->get();
        $title = trans('staff::local.edit_department');
        return view('staff::settings.departments.edit',        
        compact('title','sectors','department'));   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Department::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function getDepartmentsBySectorId ()
    {
        $output = "";
        $departments = "";
        if (request()->has('sector_id'))
        {
            $departments = Department::where('sector_id',request('sector_id'))->get();       
        }

        foreach ($departments as $department) {
            $selected = '';
            if (request()->has('id'))
            {
                $selected = $department->id == request('id')?"selected":"";
            }
               $department_name = session('lang')=='ar'?$department->ar_department:$department->en_department;
            $output .= ' <option '.$selected.' value="'.$department->id.'">'.$department_name.'</option>';
        };
        return json_encode($output);
    }
}
