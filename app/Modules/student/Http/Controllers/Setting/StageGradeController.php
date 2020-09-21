<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Stage;
use Student\Models\Settings\StageGrade;

class StageGradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = StageGrade::with('stage','grade')
            ->whereHas('stage',function($q){
                $q->orderBy('stages.sort','asc');
            })
            ->get();
            return $this->dataTable($data);
        }
        $stages = Stage::sort()->get();        
        return view('student::settings.stage-grades.index',
        ['title'=>trans('student::local.stages'),'stages' => $stages]);  
    }

    public function filter()
    {                       
        $data = StageGrade::with('grade','stage')
        ->whereHas('stage',function($q){
            $q->orderBy('stages.sort','asc');
        })        
        ->where('stage_id',request('stage_id'))
        ->get();
        
        if (request()->ajax()) {
            return $this->dataTable($data);
        } 
    }  
    
    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('stage',function($data){
                return session('lang') == 'ar' ? $data->stage->ar_stage_name : $data->stage->en_stage_name;
            })
            ->addColumn('grade',function($data){
                return session('lang') == 'ar' ? $data->grade->ar_grade_name : $data->grade->en_grade_name;
            })                    
            ->addColumn('action', function($data){
                $btn = '<a class="btn btn-warning btn-sm" href="'.route('stages-grades.edit',$data->id).'">
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
            ->rawColumns(['action','check','stage','grade'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stages = Stage::sort()->get();        
        $grades = Grade::sort()->get(); 
        $title =  trans('student::local.add_grade_stage');
        return view('student::settings.stage-grades.create',
        compact('stages','grades','title'));
    }
  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->grade_id as $id) {
            $request->user()->stageGrades()->create([
                'stage_id' => $request->stage_id,
                'grade_id' => $id,
            ]);                     
        }           
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('stages-grades.index');            
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stageGrade = StageGrade::findOrFail($id);
        $stages = Stage::sort()->get();        
        $grades = Grade::sort()->get(); 
        $title =  trans('student::local.edit_grade_stage');
        return view('student::settings.stage-grades.edit',
        compact('stages','grades','title','stageGrade'));      
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    private function attributes()
    {
        return [
            'stage_id',
            'grade_id',
        ];
    }
    public function update(Request $request, $id)
    {
        $stageGrade = StageGrade::findOrFail($id);
        $stageGrade->update($request->only($this->attributes()));                        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('stages-grades.index'); 
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
                    StageGrade::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
