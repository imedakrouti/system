<?php

namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;
use Student\Http\Controllers\Setting\AdmissionStepsController;
use Student\Http\Requests\StudentRequest;
use Student\Models\Parents\Father;
use Student\Models\Parents\Mother;
use Student\Models\Settings\AdmissionDoc;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Language;
use Student\Models\Settings\Nationality;
use Student\Models\Settings\RegistrationStatus;
use Student\Models\Settings\School;
use Student\Models\Settings\Step;
use Student\Models\Students\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }
    public function applicants()
    {
        if (request()->ajax()) {
            $data = Student::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('students.edit',$data->id).'">
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
        return view('student::students.index',
        ['title'=>trans('student::local.applicants')]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($father_id)
    {
        $nationalities = Nationality::sort()->get();
        $speakingLangs = Language::sort()->where('lang_type','speak')->get();
        $studyLangs = Language::sort()->where('lang_type','<>','speak')->get();
        $regStatus = RegistrationStatus::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $documents = AdmissionDoc::sort()->get();
        $steps = Step::sort()->get();
        $father = Father::findOrFail($father_id);
        $mothers = Mother::whereHas('fathers',function($q) use ($father_id){
            $q->where('father_id',$father_id);
        })->get();
        $schools = School::all();
        
        $title = trans('student::local.new_student');
        return view('student::students.create',
        compact('nationalities','title','speakingLangs','studyLangs','regStatus',
        'father','mothers','divisions','grades','documents','steps','schools'));
    }

    private function attributes()
    {
        return [
            'student_type',
            'ar_student_name',
            'en_student_name',
            'id_type',
            'id_number',
            'gender',
            'religion',
            'native_lang_id',
            'second_lang_id',
            'term',
            'dob',
            'reg_type',
            'student_image',
            'submitted_application',
            'submitted_name',
            'submitted_id_number',
            'submitted_mobile',
            'application_date',
            'liveWith',
            'grade_id',
            'division_id',
            'registration_status_id',
            'nationality_id',
            'father_id',
            'mother_id',
            'admin_id',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(StudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
