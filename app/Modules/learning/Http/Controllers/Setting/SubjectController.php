<?php

namespace Learning\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Learning\Models\Settings\Subject;
use Learning\Http\Requests\SubjectRequest;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('learning::local.subjects');
        $data = Subject::with('grade','division')->sort()->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::settings.subjects.index',
        compact('grades','divisions','title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('subjects.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('division_id',function($data){
                        return session('lang') == 'ar' ? 
                        $data->division->ar_division_name : $data->division->en_division_name;
                    })                    
                    ->addColumn('grade_id',function($data){
                        return session('lang') == 'ar' ? 
                        $data->grade->ar_grade_name : $data->grade->en_grade_name;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('learning::local.new_subject');
        return view('learning::settings.subjects.create',
        compact('grades','divisions','title'));
    }

    private function attributes()
    {
        return [
            'ar_name',
            'en_name',
            'sort',
            'image',            
            'admin_id',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubjectRequest $request)
    {        
        foreach (request('division_id') as $division_id) {
            foreach (request('grade_id') as $grade_id) {
                $request->user()->subjects()->firstOrCreate($request->only($this->attributes()) + 
                [
                    'division_id' => $division_id,
                    'grade_id' => $grade_id
                ]);
            }
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('subjects.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Settings\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function edit(Subject $subject)
    {
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('learning::local.edit_subject');
        return view('learning::settings.subjects.edit',
        compact('grades','divisions','title','subject'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Settings\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(SubjectRequest $request, Subject $subject)
    {
        $subject->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('subjects.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Settings\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Subject::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function filter()
    {        
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('learning::local.subjects');
        $data = Subject::with('grade','division')->sort()
        ->where('grade_id',request('grade_id'))
        ->Where('division_id',request('division_id'))        
        ->get();
        
        if (request()->ajax()) {
            return $this->dataTable($data);
        } 
    }
}
