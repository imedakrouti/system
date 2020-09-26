<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Students\Room;
use Student\Models\Students\StudentStatement;

class DistributionController extends Controller
{
    public function index()
    {
        $grades = Grade::sort()->get();
        $divisions = Division::sort()->get();        
        $title = trans('student::local.distributions_students');
        return view('student::students-affairs.distributions-students.index',
        compact('title','grades','divisions'));
    }
    public function getGradeStatistics()
    {        
        $where = [
            ['year_id',currentYear()],
            ['division_id',request('division_id')],
            ['grade_id',request('grade_id')],
        ];            

        $data = $this->gradeStatistics($where);
        
        return json_encode($data);
    }

    private function gradeStatistics($where)
    {
        // male
        $data['male'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','male');            
        })
        ->where($where)->count(); 

        $data['muslim'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){            
            $q->where('religion','muslim');               
        })
        ->where($where)->count();  

        $data['non_muslim'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){            
            $q->where('religion','non_muslim');               
        })
        ->where($where)->count();   
        // female
        $data['female'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','female');            
        })
        ->where($where)->count();          
        
        return $data;
    }

    public function allStudentsGrade()
    {   
        if (request()->ajax()) {
            if (!empty(request('division_id')) && !empty(request('grade_id'))) {
                $where = [
                    ['students_statements.division_id',request('division_id')],
                    ['students_statements.grade_id',request('grade_id')],
                    ['students_statements.year_id',currentYear()],
                ];
                $data = StudentStatement::with('student')                        
                ->join('students','students_statements.student_id','=','students.id')
                ->leftJoin('rooms','students.id','=','rooms.student_id')
                ->where($where)                
                // ->where('rooms.year_id',currentYear())
                ->orderBy('gender','asc')
                ->orderBy('ar_student_name','asc')
                ->select('students_statements.*','rooms.classroom_id')
                ->get();
                
                return $this->dataTable($data);
            }
            
        }
    } 
    private function dataTable($data)
    {
        return datatables($data)
                ->addIndexColumn()
                ->addColumn('student_name',function($data){
                    return $this->fullStudentName($data);
                })
                ->addColumn('student_number',function($data){
                    return $data->student->student_number;
                })        
                ->addColumn('gender',function($data){
                    return $data->student->gender;
                }) 
                ->addColumn('religion',function($data){
                    return $data->student->religion;
                })  
                ->addColumn('second_lang_id',function($data){
                    return session('lang') == 'ar' ?$data->student->languages->ar_name_lang:$data->student->languages->en_name_lang;
                }) 
                ->addColumn('classroom_id',function($data){
                    return $this->getClassroomName($data);
                })                                                                                                                                                                               
                ->addColumn('check', function($data){
                    $btnCheck = '<label class="pos-rel">
                                    <input type="checkbox" class="ace" name="student_id[]" value="'.$data->student_id.'" />
                                    <span class="lbl"></span>
                                </label>';
                        return $btnCheck;
                })
                ->rawColumns(['check','student_name','student_number','gender','religion','second_lang_id','classroom_id'])
                ->make(true);
    }  
    private function fullStudentName($data)
    {   
        if (session('lang') == 'ar') {
          return   '<a href="'.route('students.show',$data->student->id).'">'.$data->student->ar_student_name . ' ' . $data->student->father->ar_st_name
          . ' ' . $data->student->father->ar_nd_name. ' ' . $data->student->father->ar_rd_name.'</a>';
        }else{
            return   '<a href="'.route('students.show',$data->student->id).'">'.$data->student->en_student_name . ' ' . $data->student->father->en_st_name
            . ' ' . $data->student->father->en_nd_name. ' ' . $data->student->father->en_rd_name.'</a>';
        }
    }  
    public function joinToClassroom()
    {
        $result = '';
        if (request()->ajax()) {
            if (request()->has('student_id')) {
                if ($this->checkClassCount()) {
                    foreach (request('student_id') as $studentId) {
                        $this->removing($studentId);
                        
                        request()->user()->rooms()->firstOrCreate([
                            'student_id'    => $studentId,
                            'classroom_id'  => request('roomId'),
                            'year_id'       => currentYear(),
                        ]);                   
                    }                                       
                }else{
                    $result = trans('student::local.invalid_students_count');
                }
            }
        }     
        if (empty($result)) {
            return response(['status'=>true]);            
        }else{
            return response(['status'=>false,'msg'=>$result]);            
        }
    }  
    private function getClassroomName($data)
    {
        if (!empty($data->classroom_id)) {
            $classroom = Classroom::findOrFail($data->classroom_id);         
            return session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom;            
        }
    }  
    public function removeFromClassroom()
    {
        if (request()->ajax()) {
            foreach (request('student_id') as $studentId) {
            $this->removing($studentId);
            }
        }
        return response(['status'=>true]);
    }
    private function removing ($studentId)
    {
        $where = [
            ['student_id',$studentId],
            ['year_id',currentYear()]
        ];
        Room::where($where)->delete();
    }
    private function checkClassCount()
    {
        $classCount = Classroom::findOrFail(request('roomId'))->count();
        $totalStudents = count(request('student_id'));
        $where = [
            ['classroom_id' , request('roomId')],
            ['year_id' ,currentYear()]
        ];
        $totalCurrentClass = Room::where($where)->count();
        
        if ($classCount + 1 < $totalStudents) {
            return false;
        }elseif($classCount + 1 < $totalCurrentClass + $totalStudents){
            return false;
        }

        return true;
    }
    private function getClassStatistics()
    {
        $where = [
            ['year_id',currentYear()],
            ['division_id',request('division_id')],
            ['grade_id',request('grade_id')],
        ];  

        // male
        $data['male_room'] = Room::with('student')
        ->whereHas('student',function($q){
            $q->where('gender','male');            
        })
        ->where($where)->count();  

        dd($data);

        $data['male_non_muslim_room'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','male');
            $q->where('religion','non_muslim');               
        })
        ->where($where)->count();   
        // female
        $data['female_muslim_room'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','female');
            $q->where('religion','muslim');               
        })
        ->where($where)->count();  
        
        $data['female_non_muslim_room'] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','female');
            $q->where('religion','non_muslim');        
        })
        ->where($where)->count();   
        return $data;
    }   

    
}
