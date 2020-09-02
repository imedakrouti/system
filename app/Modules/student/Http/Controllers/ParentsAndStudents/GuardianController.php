<?php

namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;

use Student\Models\Guardians\Guardian;
use Student\Http\Requests\GuardianRequest;
use Student\Models\Students\Student;

class GuardianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Guardian::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('guardians.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('guardian_full_name',function($data){
                        return '<a href="'.route('guardians.show.students',$data->id).'">'.$data->guardian_full_name.'</a>';
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','guardian_full_name'])
                    ->make(true);
        }
        return view('student::guardians.index',['title'=>trans('student::local.guardians')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::guardians.create',
        ['title'=>trans('student::local.new_guardian')]);
    }
    private function attributes()
    {
        return [
            'guardian_full_name' ,   
            'guardian_guardian_type' ,   
            'guardian_mobile1' ,
            'guardian_mobile2' ,     
            'guardian_id_type' ,
            'guardian_id_number' ,        
            'guardian_email' ,
            'guardian_job' ,        
            'guardian_block_no' ,
            'guardian_street_name' ,
            'guardian_state' ,
            'guardian_government' ,     
            'admin_id'        
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardianRequest $request)
    {
        $request->user()->guardians()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('guardians.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function show(Guardian $guardian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function edit(Guardian $guardian)
    {
        return view('student::guardians.edit',
        ['title'=>trans('student::local.edit_guardian'),'guardian'=>$guardian]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function update(GuardianRequest $request, Guardian $guardian)
    {
        $guardian->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('guardians.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guardian  $guardian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guardian $guardian)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Guardian::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function guardiansShowStudents($id)
    {
        $guardian = Guardian::findOrFail($id);
        $students = Student::with('guardian')->where('guardian_id',$id)->get();
 
        $title = trans('student::local.student_guardians');
        return view('student::guardians.students-guardians',
        compact('title','students','guardian'));
    }
}
