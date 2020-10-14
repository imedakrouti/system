<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\Design;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Students\Room;
use Student\Models\Students\Student;
use PDF;

class CardController extends Controller
{
    public function classroom()
    {      
        $grades = Grade::sort()->get();
        $divisions = Division::sort()->get();
        $students = Student::with('father')->where('student_image','!=','')->get();
        $title = trans('student::local.students_id_card');
        return view('student::students-affairs.cards.index',
        compact('title','grades','divisions','students'));
    }
    public function getStudentCards()
    {              
        if (request()->ajax()) {
            $data = '';
            if (empty(request('student_id'))) {
                $data = Student::with('father','rooms')
                ->whereHas('rooms',function($q){
                    $q->where('year_id',currentYear());
                    $q->where('classroom_id',request('classroom_id'));
                })            
                ->where('student_image','!=','')
                ->orderBy('ar_student_name')
                ->get();                
            }else{
                $data = Student::with('father','rooms')
                ->whereHas('rooms',function($q){
                    $q->where('year_id',currentYear());                    
                })            
                ->where('id',request('student_id'))
                ->orderBy('ar_student_name')
                ->get(); 
            }
                
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('student_name',function($data){
                        return $this->fullStudentName($data);
                    })
                    ->addColumn('student_number',function($data){
                        return $data->student_number;
                    }) 
                    ->addColumn('studentImage',function($data){
                        return $this->studentImage($data);
                    })                             
                    ->addColumn('gender',function($data){
                        return $data->gender;
                    }) 
                    ->addColumn('religion',function($data){
                        return $data->religion;
                    })  
                    ->addColumn('grade',function($data){
                        return session('lang') == 'ar' ? $data->grade->ar_grade_name:
                        $data->grade->en_grade_name;
                    })
                    ->addColumn('division',function($data){
                        return session('lang') == 'ar' ? $data->division->ar_division_name:
                        $data->division->en_division_name;
                    })                                                                                                                                                                                  
                    ->addColumn('check', function($data){
                        $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['check','student_name','student_number','gender','religion','studentImage','grade','division'])
                    ->make(true);
    
            }  
    }
    private function studentImage($data)
    {
        return !empty($data->student_image)?
            '<a href="'.route('students.show',$data->id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/studentsImages/'.$data->student_image).'" />
            </a>':
            '<a href="'.route('students.show',$data->id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/studentsImages/stu.jpg').'" />
            </a>';
    }    
    private function fullStudentName($data)
    {   
        if (session('lang') == 'ar') {
          return   '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name . ' ' . $data->father->ar_st_name
          . ' ' . $data->father->ar_nd_name. ' ' . $data->father->ar_rd_name.'</a>';
        }else{
            return   '<a href="'.route('students.show',$data->id).'">'.$data->en_student_name . ' ' . $data->father->en_st_name
            . ' ' . $data->father->en_nd_name. ' ' . $data->father->en_rd_name.'</a>';
        }
    } 

    public function allStudents()
    {
        if (!request()->has(['division_id','grade_id','filter_classroom_id'])) {
            toast(trans('student::local.no_parameters_selected'),'error');  
            return back()->withInput();           
        }
        
        $design  = Design::where('division_id',request('division_id'))
        ->where('grade_id',request('grade_id'))
        ->orderBy('id','desc')->first();
        
        if (empty($design)) {
            toast(trans('student::local.no_design_found'),'error');  
            return back()->withInput();           
        }

        $students = Student::with('father','division','grade','mother','rooms')
        ->whereHas('rooms',function($q){
            $q->where('year_id',currentYear());
            $q->where('classroom_id',request('filter_classroom_id'));
        })
        ->where('division_id',request('division_id'))
        ->where('grade_id',request('grade_id'))
        ->where('student_image','!=','')
        ->orderBy('ar_student_name')
        ->get();

        if (count($students) == 0) {
            toast(trans('student::local.empty_classroom'),'error');  
            return back()->withInput();           
        }

        $division = Division::findOrFail(request('division_id'));
        $schoolName  = session('lang') == 'ar' ? $division->ar_school_name: $division->en_school_name ;

        $class_room = Room::with('classrooms')->where('classroom_id',request('filter_classroom_id'))->where('year_id',currentYear())->first();
        $classroom = session('lang') == 'ar' ? $class_room->classrooms->ar_name_classroom : $class_room->classrooms->en_name_classroom;

        $data = [          
            'path'              => logo(),
            'design'            => public_path('images/id-designs/'.$design->design_name),
            'students'          => $students,                
            'classroom'         => $classroom,                
            'schoolName'        => $schoolName,                
            'studentPathImage'  => public_path('images/studentsImages/'),
        		];
		$pdf = PDF::loadView('student::students-affairs.cards.reports.all-students', $data);
		return $pdf->stream($classroom);
    }

    public function selectedStudents()
    {     
        $schoolName = '';
        $classroom = '';
        $design = '';        

        if (!empty(request('division_id')) && !empty(request('grade_id'))) {
            $design  = Design::where('division_id',request('division_id'))
            ->where('grade_id',request('grade_id'))
            ->orderBy('id','desc')->first();  

            $division = Division::findOrFail(request('division_id'));
            $schoolName  = session('lang') == 'ar' ? $division->ar_school_name: $division->en_school_name ;

            $class_room = Room::with('classrooms')->where('classroom_id',request('filter_classroom_id'))->where('year_id',currentYear())->first();
            $classroom = session('lang') == 'ar' ? $class_room->classrooms->ar_name_classroom : $class_room->classrooms->en_name_classroom;
                    
        }
        // search by student name
        elseif (!empty(request('student_id'))) {
            $student = Student::findOrFail(request('student_id'));

            $design  = Design::where('division_id',$student->division_id)
            ->where('grade_id',$student->grade_id)
            ->first();  

            $division = Division::findOrFail($student->division_id);
            $schoolName  = session('lang') == 'ar' ? $division->ar_school_name: $division->en_school_name ;

            $class_room = Room::with('classrooms')->where('student_id',$student->id)->where('year_id',currentYear())->first();
            $classroom = session('lang') == 'ar' ? $class_room->classrooms->ar_name_classroom : $class_room->classrooms->en_name_classroom;
        }else{
            toast(trans('student::local.no_parameters_selected'),'error');  
            return back()->withInput();   
        }
                
        if (empty($design)) {
            toast(trans('student::local.no_design_found'),'error');  
            return back()->withInput();           
        }
        
        $students = '';
        if (empty(request('student_id'))) {
            $students = Student::with('father','division','grade','mother','rooms')
            ->whereHas('rooms',function($q){
                $q->where('year_id',currentYear());
                $q->where('classroom_id',request('filter_classroom_id'));
            })
            ->whereIn('id',request('id'))        
            ->where('student_image','!=','')
            ->orderBy('ar_student_name')
            ->get();            
        }else{
            $students = Student::with('father','division','grade','mother','rooms')
            ->whereHas('rooms',function($q){
                $q->where('year_id',currentYear());                
            })            
            ->where('id',request('student_id'))
            ->whereIn('id',request('id'))        
            ->orderBy('ar_student_name')
            ->get(); 
        }
        
        
        if (empty($students)) {
            toast(trans('student::local.no_students_found'),'error');  
            return back()->withInput();           
        }

        $data = [          
            'path'              => logo(),
            'design'            => public_path('images/id-designs/'.$design->design_name),
            'students'          => $students,                
            'classroom'         => $classroom,                
            'schoolName'        => $schoolName,                
            'studentPathImage'  => public_path('images/studentsImages/'),
        		];
		$pdf = PDF::loadView('student::students-affairs.cards.reports.all-students', $data);
		return $pdf->stream('student_card');
    }  
    
    public function studentsNotPhotosClass()
    {
        if (!request()->has(['division_id','grade_id','filter_classroom_id'])) {
            toast(trans('student::local.no_parameters_selected'),'error');  
            return back()->withInput();           
        }

        $students = Student::with('father','mother','rooms')
        ->whereHas('rooms',function($q){
            $q->where('classroom_id',request('filter_classroom_id'));
        })
        ->whereNull('student_image')
        ->get();        

        $class_room = Room::with('classrooms')->where('classroom_id',request('filter_classroom_id'))->where('year_id',currentYear())->first();
        $classroom = session('lang') == 'ar' ? $class_room->classrooms->ar_name_classroom : $class_room->classrooms->en_name_classroom;
 
        $data = [                                  
            'title'             => $classroom,                
            'students'          => $students,                
            'classroom'         => $classroom,                         
                ];
        $config = [
            'orientation'          => 'P',
            'margin_header'        => 15,      
            'margin_top'           => 25,
            'margin_bottom'        => 5,
        ]; 
		$pdf = PDF::loadView('student::students-affairs.cards.reports.students-no-photo-class',  $data,[],$config);
		return $pdf->stream($classroom);
    }

    public function studentsNotPhotosGrade()
    {
        if (!request()->has(['division_id','grade_id','filter_classroom_id'])) {
            toast(trans('student::local.no_parameters_selected'),'error');  
            return back()->withInput();           
        }

        $students = Student::with('father','mother','rooms')
        ->where('students.division_id',request('division_id'))
        ->where('students.grade_id',request('grade_id'))
        ->whereNull('student_image')
        ->join('rooms','rooms.student_id','=','students.id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')
        ->orderBy('classrooms.sort','asc')
        ->orderBy('students.gender','asc')
        ->orderBy('students.ar_student_name','asc')
        ->get();
        
        $division = Division::findOrFail(request('division_id'));
        $division_name = session('lang') == 'ar' ? $division->ar_division_name:$division->en_division_name;
        $grade = Grade::findOrFail(request('grade_id'));
        $grade_name = session('lang') == 'ar' ? $grade->ar_grade_name:$grade->en_grade_name;            
 
        $data = [                                  
            'title'             => 'Student no photo',                
            'students'          => $students,                            
            'division_name'     => $division_name,                            
            'grade_name'        => $grade_name,                            
                ];
        $config = [
            'orientation'          => 'P',
            'margin_header'        => 15,      
            'margin_top'           => 25,
            'margin_bottom'        => 5,
        ]; 
		$pdf = PDF::loadView('student::students-affairs.cards.reports.students-no-photo-grade',  $data,[],$config);
		return $pdf->stream('Student no photo');
    }    
    
}
