<?php

namespace Learning\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Learning\Models\Settings\GradeSubject;
use Learning\Models\Settings\Subject;
use Student\Models\Settings\Grade;

class GradeSubjectController extends Controller
{
    public function index()
    {
        $title = trans('learning::local.grade_subjects');
        $data = Grade::has('subjects')->get();    
        
        // dd($data);
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::settings.grade-subjects.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()                       
                    ->addColumn('grade',function($data){                        
                      return session('lang') == 'ar' ? $data->ar_grade_name: $data->en_grade_name;
                    })              
                    ->addColumn('subjects',function($data){                        
                        $subject_name = '';
                        foreach ($data->subjects as $subject) {     
                            $sub = session('lang') == 'ar' ? $subject->ar_name : $subject->en_name;
                            $subject_name .= '<div class="badge badge-primary">
                                                <span>'. $sub.'</span>
                                                <i class="la la-folder-o font-medium-3"></i>
                                            </div> ' ;
                        }
                        return $subject_name;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','subjects','grade'])
                    ->make(true);
    }
    public function create()
    {                
        $grades = Grade::sort()->get();
        $subjects = Subject::sort()->get();
        $title = trans('learning::local.add_grade_subject');
        return view('learning::settings.grade-subjects.create',
        compact('grades','subjects','title'));
    }

    public function store()
    {
        if (request()->has('grade_id','subject_id')) {
            foreach (request('grade_id') as $grade_id) {
                foreach (request('subject_id') as $subject_id) {
                  request()->user()->gradeSubjects()->firstOrCreate([                      
                      'grade_id'      => $grade_id,
                      'subject_id'    => $subject_id,                        
                  ]);
                }
            }
            toast(trans('msg.stored_successfully'),'success');
        }
        return redirect()->route('grade-subjects.index');
    }

    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $grade_id) {
                    GradeSubject::where('grade_id',$grade_id)->delete();
                }
            }
        }
        return response(['status'=>true]);
    }
}
