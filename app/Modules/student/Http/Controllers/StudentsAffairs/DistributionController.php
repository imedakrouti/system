<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Students\Room;
use Student\Models\Students\Student;
use Student\Models\Students\StudentStatement;
use DB;
use PDF;
use Student\Models\Settings\Year;

class DistributionController extends Controller
{
    public function index()
    {
        $years = Year::orderBy('id','desc')->get();
        $grades = Grade::sort()->get();
        $divisions = Division::sort()->get();        
        $title = trans('student::local.distributions_students');
        return view('student::students-affairs.distributions-students.index',
        compact('title','grades','divisions','years'));
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
                ->where('rooms.year_id',currentYear())
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
                        $this->insertIntoClassroom($studentId,request('roomId'));
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
    private function insertIntoClassroom($studentId,$classroom_id ,$year_id = null)
    {        
        $year_id = !empty($year_id) ? $year_id :currentYear();
        
        DB::transaction(function() use($studentId,$classroom_id,$year_id){
            $this->removing($studentId);
                        
            request()->user()->rooms()->firstOrCreate([
                'student_id'    => $studentId,
                'classroom_id'  => $classroom_id,
                'year_id'       => $year_id,
            ]); 
        });
    }
    private function getClassroomName($data)
    {
        if (!empty($data->classroom_id)) {
            $classroom = Classroom::findOrFail($data->classroom_id);  
            $className = session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom ;     
            return '<span class="red"><strong>'. $className.'</strong></span>';            
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
        $classCount = Classroom::findOrFail(request('roomId'))->total_students;
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
    public function getClassStatistics()
    {
        $where = [
            ['rooms.year_id',currentYear()],
            ['rooms.classroom_id',request('room_id')],            
        ];  

        // male
        $data['male_room'] = Room::with('students')
        ->whereHas('students',function($q){
            $q->where('gender','male');            
        })
        ->where($where)->count();  

        $data['female_room'] = Room::with('students')
        ->whereHas('students',function($q){
            $q->where('gender','female');            
        })
        ->where($where)->count();   

        // muslim
        $data['muslim_room'] = Room::with('students')
        ->whereHas('students',function($q){            
            $q->where('religion','muslim');               
        })
        ->where($where)->count();  
        
        $data['non_muslim_room'] = Room::with('students')
        ->whereHas('students',function($q){            
            $q->where('religion','non_muslim');        
        })
        ->where($where)->count();   
        return $data;
    }  
    
    public function getLanguagesGrade()
    {      
        $where = [            
            ['students.division_id',request('division_id')],
            ['students.grade_id',request('grade_id')]
        ]; 

        $langName = session('lang') == 'ar' ? 'languages.ar_name_lang':'languages.en_name_lang';

        $students = DB::select('select languages.ar_name_lang,languages.en_name_lang ,count(students.id) as count
        from students_statements
        inner join students on students_statements.student_id = students.id
        inner join languages on students.second_lang_id = languages.id
        where students_statements.division_id = '.request('division_id').'
         and students_statements.grade_id = '.request('grade_id').' 
         and students_statements.year_id ='.currentYear().'
        group by languages.ar_name_lang,languages.en_name_lang');        
        // dd($students);
        $output = '';

        foreach ($students as $data) {   
            $langName = session('lang') == 'ar' ? $data->ar_name_lang:$data->ar_name_lang;         
            $output .= '<tr><td>'.$langName.'</td><td>'.$data->count.'</td></tr>';
        }       
        return json_encode($output);     
    }

    public function getLanguagesClass()
    {
        $students = Student::with('rooms','languages')
        ->whereHas('rooms',function($q){
            $q->where('classroom_id',request('room_id'));
            $q->where('year_id',currentYear());
        })
        ->groupBy('students.second_lang_id')
        ->select('students.second_lang_id',DB::raw('count(students.id) as count'))
        ->get();
        $output = '';
        foreach ($students as $data) {
            $langName = session('lang') == 'ar' ? $data->languages->ar_name_lang:$data->languages->ar_name_lang;
            $output .= '<tr><td>'.$langName.'</td><td>'.$data->count.'</td></tr>';
        }       
        return json_encode($output);     
    }

    public function nameListReport()
    {
       
        if (request()->has('room_id')) {
            $room = Classroom::findOrFail(request('room_id'));            
        
            $classroom =  session('lang') =='ar'?$room->ar_name_classroom:$room->en_name_classroom;
            $students = Student::with('rooms','languages','regStatus','nationalities')
            ->whereHas('rooms',function($q){
                $q->where('classroom_id',request('room_id'));
            })
            ->orderBy('gender','asc')
            ->orderBy('ar_student_name','asc')
            ->get();
            
            // statistics

            $male = Student::with('rooms')
            ->whereHas('rooms',function($q){
                $q->where('classroom_id',request('room_id'));                
            })
            ->where('gender','male')            
            ->count();
            $female = Student::with('rooms')
            ->whereHas('rooms',function($q){
                $q->where('classroom_id',request('room_id'));                
            })
            ->where('gender','female')            
            ->count(); 

            $muslim = Student::with('rooms')
            ->whereHas('rooms',function($q){
                $q->where('classroom_id',request('room_id'));                
            })
            ->where('religion','muslim')            
            ->count();
            
            $non_muslim = Student::with('rooms')
            ->whereHas('rooms',function($q){
                $q->where('classroom_id',request('room_id'));                
            })
            ->where('religion','non_muslim')            
            ->count();             
            
            $data = [
                'title'                     => 'Name List Report',                       
                'classroom'                 => $classroom,                       
                'students'                  => $students,                       
                'logo'                      => logo(),
                'school_name'               => getSchoolName($room->division_id),               
                'education_administration'  => preamble()['education_administration'],               
                'governorate'               => preamble()['governorate'], 
                'male'                      => $male,
                'female'                    => $female,
                'muslim'                    => $muslim,
                'non_muslim'                => $non_muslim,                                    
            ];
            $config = [
                'orientation'          => 'P',
                'margin_header'        => 5,
                'margin_footer'        => 50,
                'margin_left'          => 10,
                'margin_right'         => 10,
                'margin_top'           => 50,
                'margin_bottom'        => session('lang') == 'ar' ? 52 : 55,
            ];  
            $reportPath = 'student::students-affairs.distributions-students.name-list';
            $pdf = PDF::loadView($reportPath,$data,[],$config);        
    
            return $pdf->stream('Statement');

        }else{
            toast(trans('student::local.select_classroom_first'),'error');
            return back();
        }
    }

    public function moveToClass()
    {
        $result = '';
        
        if (request()->ajax()) {
            if (!request()->has('to_room_id')) {                
                $result = trans('student::local.no_to_room_selected');
            } 
            if (!request()->has('from_room_id')) {                
                $result = trans('student::local.no_from_room_selected');
            }                     
            $current_grade_id = Classroom::findOrFail(request('to_room_id'))->grade_id;   

            $students = Student::whereHas('statements',function($q) use ( $current_grade_id){
            $q->where('year_id',currentYear());
            $q->where('grade_id', $current_grade_id);
            })
            ->whereHas('rooms',function($q){
                $q->where('classroom_id',request('from_room_id'));
                $q->where('year_id',request('from_year_id'));
            })->get();
            
            foreach ($students as $studentId) {
                $this->insertIntoClassroom($studentId->id,request('to_room_id'));                
            }

        }        
        if (empty($result)) {
            return response(['status'=> true]);            
        }else{
            return response(['status'=> false, 'msg' => $result]);                        
        }
    }

    
}
