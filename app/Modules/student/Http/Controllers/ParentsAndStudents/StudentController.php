<?php

namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;
use Student\Http\Controllers\Setting\AdmissionStepsController;
use Student\Http\Requests\StudentRequest;
use Student\Models\Guardians\Guardian;
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
use DB;

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
            $data = Student::with('nationalities','regStatus','division','father','grade')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('students.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('studentName',function($data){
                        return $this->getFullStudentName($data);                                         
                    })
                    ->addColumn('registration_status',function($data){
                        return session('lang') == trans('admin.ar') ? $data->regStatus->ar_name_status:
                        $data->regStatus->en_name_status;
                    })
                    ->addColumn('religion',function($data){
                        return $this->getReligion($data);     
                    })
                    ->addColumn('grade',function($data){
                        return session('lang') == trans('admin.ar') ? $data->grade->ar_grade_name:
                        $data->grade->en_grade_name;
                    })
                    ->addColumn('division',function($data){
                        return session('lang') == trans('admin.ar') ? $data->division->ar_division_name:
                        $data->division->en_division_name;
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','studentName','registration_status','religion','grade','division'])
                    ->make(true);
        }
        return view('student::students.index',
        ['title'=>trans('student::local.applicants')]);  
    }

    private function getFullStudentName($data)
    {        
        if (session('lang') == trans('admin.ar')) {
            return '<a href="#">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="#">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }
    }

    private function getReligion($data)
    {
        if (session('lang') == trans('admin.ar')) {
            if ($data->gender == 'male') {
                if ($data->religion == 'muslim') {
                    return trans('student::local.muslim');
                }
                else{
                    return trans('student::local.non_muslim');

                }
            }else{
                if ($data->religion == 'muslim') {
                    return trans('student::local.muslim_m');
                }
                else{
                    return trans('student::local.non_muslim_m');

                }
            }
        }
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
        $guardians = Guardian::all();
        
        $title = trans('student::local.new_student');
        return view('student::students.create',
        compact('nationalities','title','speakingLangs','studyLangs','regStatus',
        'father','mothers','divisions','grades','documents','steps','schools','guardians'));
    }

    private function studentAttributes()
    {
        return [
            'father_id',
            'mother_id',
            'student_type',
            'ar_student_name',
            'en_student_name',
            'id_number',
            'id_type',
            'student_number',
            'gender',
            'nationality_id',
            'religion',
            'native_lang_id',
            'second_lang_id',
            'term',
            'dob',
            'reg_type',
            'grade_id',
            'division_id',
            'student_image',
            'submitted_application',
            'submitted_name',
            'submitted_id_number',
            'submitted_mobile',
            'school_id',
            'transfer_reason',
            'application_date',
            'guardian_id',
            'place_birth',
            'return_country',
            'registration_status_id',
        ];
    }
    private function medicalAttributes()
    {
        return [
            'blood_type'            => request('blood_type'),
            'food_sensitivity'      => request('food_sensitivity'),
            'medicine_sensitivity'  => request('medicine_sensitivity'),
            'other_sensitivity'     => request('other_sensitivity'),
            'have_medicine'         => request('have_medicine'),
            'vision_problem'        => request('vision_problem'),
            'use_glasses'           => request('use_glasses'),
            'hearing_problems'      => request('hearing_problems'),
            'speaking_problems'     => request('speaking_problems'),
            'chest_pain'            => request('chest_pain'),
            'breath_problem'        => request('breath_problem'),
            'asthma'                => request('asthma'),
            'have_asthma_medicine'  => request('have_asthma_medicine'),
            'heart_problem'         => request('heart_problem'),
            'hypertension'          => request('hypertension'),
            'diabetic'              => request('diabetic'),
            'anemia'                => request('anemia'),
            'cracking_blood'        => request('cracking_blood'),
            'coagulation'           => request('coagulation'),
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
        dd(request()->all());
        DB::transaction(function () use ($request) {            
            $student = $request->user()->students()->create($request->only($this->studentAttributes()) 
            + ['student_number'=>$this->studentNumber(), 'year_id' => currentYear()]);  

            $this->studentAdmissionSteps($student->id);

            $this->studentDeliverDocuments($student->id);

            $this->studentMedicalQuery($student->id);
        });      
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father.show',$request->father_id);
    }
    private function studentAdmissionSteps($student_id)
    {
        if (request()->has('admission_step_id'))
        {
            foreach (request('admission_step_id') as  $step) {
                DB::table('student_steps')->insert([
                    'student_id'           => $student_id,
                    'admission_step_id'    => $step,
                    'admin_id'             => authInfo()->id
                ]);
            }
        }
    }
    private function studentDeliverDocuments($student_id)
    {
        if (request()->has('student_doc_delivers'))
        {
            foreach (request('admission_document_id') as  $step) {
                DB::table('student_steps')->insert([
                    'student_id'                => $student_id,
                    'admission_document_id'     => $step,
                    'admin_id'                  => authInfo()->id
                ]);
            }
        }
    }
    private function studentMedicalQuery($student_id)
    {
        DB::table('medicals')->insert($this->medicalAttributes() 
        + ['student_id'=>$student_id,'admin_id'=> authInfo()->id]);
    }
    private function studentNumber()
    {
        $student_id = Student::where([
            'year_id'       => currentYear(),
            'division_id'   => request('division_id'),
            'grade_id'      => request('grade_id')            
        ])->count('id');
        return currentYear().request('division_id').$student_id.rand(1,132);
        
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
