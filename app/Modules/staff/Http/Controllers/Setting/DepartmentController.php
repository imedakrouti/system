<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use DataTables;
use Illuminate\Http\Request;
use Staff\Http\Requests\DepartmentRequest;
use Staff\Models\Settings\Department;

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
            $data = Department::orderBy('sort','asc')->with('sector')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('department.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('sector', function($data){
                        return session('lang') == 'ar'?$data->sector->arabicSector : $data->sector->englishSector;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','sector'])
                    ->make(true);
        }
        return view('staff::settings.department.index',['title'=>trans('staff::admin.departments')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.department.create',['title'=>trans('staff::admin.new_department')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $request->user()->departments()
        ->create($request->only('arabicDepartment','englishDepartment','balanceDepartmentLeave','sector_id','sort'));
        alert()->success(trans('msg.stored_successfully'), trans('staff::admin.new_department'));
        return redirect()->route('department.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('staff::settings.department.edit',['title'=>trans('staff::admin.edit_department'),'department'=>$department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update($request->only('arabicDepartment','englishDepartment','balanceDepartmentLeave','sector_id','sort'));
        alert()->success(trans('msg.updated_successfully'), trans('staff::admin.edit_department'));
        return redirect()->route('department.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
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
    private function departments()
    {
        $departments = "";

        if (request()->has('sectorId'))
        {
            $departments = Department::where('sectorId',request('sectorId'))->get();
        }else{
            $departments = Department::where('id',request('id'))->get();
        }

        foreach ($departments as $department) {
            $department->setAttribute('departmentName',session('lang')!='ar'?$department->arabicDepartment:$department->englishDepartment);
        }
        return $departments;
    }
    public function getDepartments()
    {
        $output = "";

        foreach ($this->departments() as $department) {
            $selected = '';
            if (request()->has('id'))
            {
                $selected = $department->id == request('id')?"selected":"";
            }
            $output .= ' <option '.$selected.' value="'.$department->id.'">'.$this->departmentName.'</option>';
        };
        return json_encode($output);
    }
    public function getDepartmentsWithNull()
    {
        $output = "";
        foreach ($this->departments()  as $department) {
            $output .= ' <option  value="'.$department->id.'">'.$this->departmentName.'</option>';
        };
        $output .='<option value="'.Null.'">'.trans('staff::admin.null').'</option>';
        return json_encode($output);
    }
}
