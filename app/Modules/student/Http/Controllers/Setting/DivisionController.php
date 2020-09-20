<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Http\Requests\DivisionRequest;
use Student\Models\Settings\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Division::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('divisions.edit',$data->id).'">
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
        return view('student::settings.divisions.index',['title'=>trans('student::local.divisions')]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.divisions.create',
        ['title'=>trans('student::local.new_division')]);
    }
    private function attributes()
    {
        return [
            'ar_division_name',
            'en_division_name',
            'total_students',
            'school_name',
            'sort',
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DivisionRequest $request)
    {
        $request->user()->divisions()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('divisions.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return view('student::settings.divisions.edit',
        ['title'=>trans('student::local.edit_division'),'division'=>$division]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function update(DivisionRequest $request, Division $division)
    {
        $division->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('divisions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division  $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Division::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    private function divisions()
    {
        $divisions = Division::all();
        foreach ($divisions as $division) {
            $division->setAttribute('divisionName',session('lang')=='en'?$division->ar_division_name:$division->en_division_name);
        }
        return $divisions;
    }
    public function getDivisions()
    {
        $output = "";
        $output .='<option value="">'.trans('admin.select').'</option>';
        foreach ($this->divisions() as $division) {
            $output .= ' <option value="'.$division->id.'">'.$division->divisionName.'</option>';
        };
        return json_encode($output);
    }
    public function getDivisionSelected()
    {
        $id = request()->get('division_id');
        $output = "";
        $output .='<option value="">'.trans('admin.select').'</option>';
        foreach ($this->divisions() as $division) {
            $selected = $division->id == $id?"selected":"";
            $output .= ' <option '.$selected.' value="'.$division->id.'">'.$division->divisionName.'</option>';
        };
        return json_encode($output);
    }    
}
