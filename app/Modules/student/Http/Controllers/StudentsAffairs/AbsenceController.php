<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Students\Absence;
use Student\Models\Students\Student;
use Carbon;
use Student\Models\Settings\Classroom;

class AbsenceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Absence::with('students','admin')
            ->join('students','absences.student_id','=','students.id')
            ->join('rooms','rooms.student_id','=','students.id')
            ->join('classrooms','rooms.classroom_id','=','classrooms.id')
            ->select('absences.*','classrooms.ar_name_classroom','en_name_classroom')
            ->where('rooms.year_id',currentYear())
            ->where('absence_date',Carbon\Carbon::today())
            ->orderBy('absences.id','desc')
            ->get();
            
            return $this->dataTable($data);            
        }
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $title = trans('student::local.absence');
        return view('student::students-affairs.absence.index',
        compact('divisions','grades','title'));  
    }

    private function dataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()   
        ->addColumn('student_number',function($data){
            return $data->students->student_number;
        })
        ->addColumn('student_name',function($data){
            return $this->getFullStudentName($data);
        })
        ->addColumn('student_image',function($data){
            return $this->studentImage($data);
        })
        ->addColumn('grade',function($data){
            return session('lang') == 'ar' ? $data->students->grade->ar_grade_name . ' - ' .
            $data->students->division->ar_division_name . '<br> <span class="purple ">'.$data->ar_name_classroom.'</span>':
            $data->students->grade->en_grade_name . ' - ' .$data->students->division->en_division_name 
            . '<br> <span class="purple ">'.$data->en_name_classroom.'</span>';
        })
        ->addColumn('created_by',function($data){
            return $data->admin->name;
        })
        ->addColumn('created_at',function($data){
            return $data->created_at->diffForHumans();
        })                                                                                                 
        ->addColumn('check', function($data){
               $btnCheck = '<label class="pos-rel">
                            <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
        })
        ->rawColumns(['check','student_number','student_image','student_name',
        'grade','division','created_by','created_at'])
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!request()->has(['division_id','grade_id','filter_classroom_id'])) {
            toast(trans('student::local.no_parameters_selected'),'success');
            return back()->withInput();
        }
        $division = Division::findOrFail(request('division_id'));
        $grade = Grade::findOrFail(request('grade_id'));
        $classroom = Classroom::findOrFail(request('filter_classroom_id'));

        $students = Student::with('rooms','father','absence')
        ->whereHas('rooms',function($q){
            $q->where('classroom_id',request('filter_classroom_id'));
        })        
        ->get();
        $absences = Absence::where('absence_date',Carbon\Carbon::today())->get();
        $title = trans('student::local.add_absence');
        return view('student::students-affairs.absence.create',
        compact('division','grade','classroom','students','title','absences'));
    }
    private function studentImage($data)
    {
        return !empty($data->students->student_image)?
            '<a href="'.route('students.show',$data->student_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/studentsImages/'.$data->students->student_image).'" />
            </a>':
            '<a href="'.route('students.show',$data->student_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/studentsImages/37.jpeg').'" />
            </a>';
    }
    private function getFullStudentName($data)
    {        
        if (session('lang') == 'ar') {
            return '<a href="'.route('students.show',$data->students->id).'">'.$data->students->ar_student_name .'</a>  <a href="'.route('father.show',$data->students->father_id).'">'.$data->students->father->ar_st_name.
            ' '.$data->students->father->ar_nd_name.' '.$data->students->father->ar_rd_name.' '.$data->students->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="'.route('students.show',$data->students->id).'">'.$data->students->en_student_name .'</a> <br> <a href="'.route('father.show',$data->students->father_id).'">'.$data->students->father->en_st_name.
            ' '.$data->students->father->en_nd_name.' '.$data->students->father->en_rd_name.' '.$data->students->father->en_th_name.'</a> ' ;    
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $students   = request('student_id');
        $status     = request('status');
        $notes      = request('notes');

        $count_student = count(request('student_id'));        

        for ($i=1; $i <= $count_student; $i++) { 
            if ($status[$i] != 'attend') {
                $this->updateOldAbsence( $students[$i]); 
                $request->user()->absences()->firstOrCreate([
                    'absence_date'  => Carbon\Carbon::today(),
                    'status'        => $status[$i],
                    'student_id'    => $students[$i],               
                    'notes'         => $notes[$i],               
                ]);                                                      
            }
        }
       toast(trans('msg.stored_successfully'),'success');
       return redirect()->route('absences.index');
    }
    private function updateOldAbsence($student_id)
    {
        $row = Absence::where('student_id',$student_id)
        ->where('absence_date',Carbon\Carbon::today())->first();
        
        if (empty($row)) {
            return true;
        }
        Absence::destroy($row->id);
        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absence  $absence
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absence $absence)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Absence::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function filter()
    {        
        if (request()->ajax()) {            
           $classroom = request()->has('classroom_id') ? request('classroom_id') : null;
           
            $data = Absence::with('students','admin')
            ->join('students','absences.student_id','=','students.id')
            ->join('rooms','rooms.student_id','=','students.id')
            ->join('classrooms','rooms.classroom_id','=','classrooms.id')
            ->select('absences.*','classrooms.ar_name_classroom','en_name_classroom')
            ->where('classrooms.id',$classroom)
            ->orderBy('absences.id','desc')
            ->get();                
            return $this->dataTable($data);                            
        }
    }
}
