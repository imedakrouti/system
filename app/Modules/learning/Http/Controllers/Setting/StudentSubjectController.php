<?php

namespace Learning\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Learning\Models\Settings\StudentSubject;
use Learning\Models\Settings\Subject;
use Student\Models\Students\Student;

class StudentSubjectController extends Controller
{
    public function index()
    {
        $title = trans('learning::local.student_subjects');
        
        $data = Student::with('father')->whereHas('statements')
        ->orderBy('ar_student_name')->get();
        
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::settings.student-subjects.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()                       
                    ->addColumn('student_number',function($data){
                        return $data->student_number;
                    })
                    ->addColumn('student_name',function($data){
                        return $this->fullStudentName($data);
                    })
                    ->addColumn('grade',function($data){
                        return session('lang') == 'ar' ? $data->grade->ar_grade_name:$data->grade->en_grade_name;
                    }) 
                    ->addColumn('division',function($data){
                        return session('lang') == 'ar' ? $data->division->ar_division_name:$data->division->en_division_name;
                    })                
                    ->addColumn('subjects',function($data){                        
                        $subject_name = '';
                        foreach ($data->subjects as $subject) {     
                            $sub = session('lang') == 'ar' ? $subject->ar_name : $subject->en_name;
                            $subject_name .= '<div class="badge badge-danger">
                                                <span>'. $sub.'</span>
                                                <i class="la la-book font-medium-3"></i>
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
                    ->rawColumns(['check','subjects','grade','student_number','student_name','division','grade'])
                    ->make(true);
    }
    private function fullStudentName($data)
    {   
        if (session('lang') == 'ar') {
          return   '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name 
          . ' ' . $data->father->ar_st_name
          . ' ' . $data->father->ar_nd_name. ' ' . $data->father->ar_rd_name.'</a>';
        }else{
            return   '<a href="'.route('students.show',$data->id).'">'.$data->en_student_name 
            . ' ' . $data->father->en_st_name
            . ' ' . $data->father->en_nd_name. ' ' . $data->father->en_rd_name.'</a>';
        }
    }
    public function create()
    {                
        $students = Student::with('father')->whereHas('statements')
        ->orderBy('ar_student_name')->get();
        $subjects = Subject::sort()->get();
        $title = trans('learning::local.add_student_subject');
        return view('learning::settings.student-subjects.create',
        compact('students','subjects','title'));
    }

    public function store()
    {
        if (request()->has('student_id','subject_id')) {
            foreach (request('student_id') as $student_id) {
                foreach (request('subject_id') as $subject_id) {
                  request()->user()->studentSubject()->firstOrCreate([                      
                      'student_id'      => $student_id,
                      'subject_id'    => $subject_id,                        
                  ]);
                }
            }
            toast(trans('msg.stored_successfully'),'success');
        }
        return redirect()->route('student-subjects.index');
    }

    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $student_id) {
                    StudentSubject::where('student_id',$student_id)->delete();
                }
            }
        }
        return response(['status'=>true]);
    }
}
