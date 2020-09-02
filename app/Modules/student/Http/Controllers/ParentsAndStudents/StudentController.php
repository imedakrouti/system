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
use Student\Models\Students\Address;

class StudentController extends Controller
{
    private $father_id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Student::with('nationalities','regStatus','division','father','grade')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('studentName',function($data){
                        return $this->getFullStudentName($data);                                         
                    })
                    ->addColumn('moreBtn',function($data){
                        return $this->moreBtn($data);                                         
                    })
                    ->addColumn('studentImage',function($data){
                        return '<a href="'.route('students.show',$data->id).'">
                            <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                            src="'.asset('images/imagesProfile/'.authInfo()->image_profile).'" />
                        </a>';
                        
                    })
                    ->addColumn('registration_status',function($data){
                        return session('lang') == trans('admin.ar') ? $data->regStatus->ar_name_status:
                        $data->regStatus->en_name_status;
                    })
                    ->addColumn('religion',function($data){
                        return $this->getReligion($data);     
                    })
                    ->addColumn('student_type',function($data){
                        return $data->student_type == trans('student::local.applicant') ? '<span class="red">'.$data->student_type.'</span>':$data->student_type;     
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
                    ->rawColumns(['check','studentName','registration_status','religion','grade','student_type',
                    'division','studentImage','moreBtn'])
                    ->make(true);
        }
        return view('student::students.index',
        ['title'=>trans('student::local.students')]);  
    }

    private function moreBtn($data)
    {
        return $data->student_type == trans('student::local.student')?'
        <div class="btn-group mr-1 mb-1">
            <button type="button" class="btn btn-primary"><i class="la la-user"></i> '.trans('student::local.more').'</button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="'.route('students.edit',$data->id).'">'.trans('student::local.editing').'</a>
                <a class="dropdown-item" href="'.route('students.edit',$data->id).'">'.trans('student::local.print_id_card').'</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">'.trans('student::local.add_permission').'</a>
                <a class="dropdown-item" href="#">'.trans('student::local.add_parent_request').'</a>
                <a class="dropdown-item" href="#">'.trans('student::local.add_proof_enrollments').'</a>
                <a class="dropdown-item" href="#">'.trans('student::local.include_statement').'</a>
            </div>
        </div>':'
        <div class="btn-group mr-1 mb-1">
            <button type="button" class="btn btn-secondary"><i class="la la-user"></i> '.trans('student::local.more').'</button>
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="'.route('students.edit',$data->id).'">'.trans('student::local.editing').'</a>                
            </div>
        </div>';
    }

    private function getFullStudentName($data)
    {        
        if (session('lang') == trans('admin.ar')) {
            return '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
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
            'code',
        ];
    }
    private function medicalAttributes()
    {
        return [            
            'blood_type',
            'food_sensitivity',
            'medicine_sensitivity',
            'other_sensitivity',
            'have_medicine',
            'vision_problem',
            'use_glasses',
            'hearing_problems',
            'speaking_problems',
            'chest_pain',
            'breath_problem',
            'asthma',
            'have_asthma_medicine',
            'heart_problem',
            'hypertension',
            'diabetic',
            'anemia',
            'cracking_blood',
            'coagulation',            
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
        DB::transaction(function () use ($request) {            
            $student = $request->user()->students()->create($request->only($this->studentAttributes()) 
            + [
                'student_number'=> $this->studentNumber(),
                'code'          => $this->studentCode(),
                'year_id'       => currentYear()]);  
            
            $this->studentAdmissionSteps($student->id);
            
            $this->studentDeliverDocuments($student->id);                    
            
            $this->studentAddresses($student->id);
        });      
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father.show',$request->father_id);
    }
    private function studentAdmissionSteps($student_id)
    {              
        DB::table('student_steps')->where('student_id',$student_id)->delete();
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
        DB::table('student_doc_delivers')->where('student_id',$student_id)->delete();
        if (request()->has('admission_document_id'))
        {
            foreach (request('admission_document_id') as  $document) {
                DB::table('student_doc_delivers')->insert([
                    'student_id'                => $student_id,
                    'admission_document_id'     => $document,
                    'admin_id'                  => authInfo()->id
                ]);
            }
        }
    }
    private function studentMedicalQuery($student_id)
    {
        request()->user()->medicals()->create(request()->only($this->medicalAttributes())
        + ['student_id'=>$student_id]);        
    }
    private function studentNumber()
    {
        $student_id = $this->studentCode();
        
        return getYearAcademic().request('division_id').$student_id;
        
    }
    private function studentCode()
    {
        $studentCode = Student::where([
            'year_id'      => currentYear(),
            'division_id'  => request('division_id'),            
        ])->max('code')+1;
        
        return $studentCode;
        
    }
    private function studentAddresses($student_id)
    {        
        if (request()->has('repeater-group')) {  
            DB::table('student_address')->where('student_id',$student_id)->delete();

            foreach (request('repeater-group') as $value) {                                    
                if (!empty($value['full_address'])) {
                    DB::table('student_address')->insert(
                        [
                            'full_address'  => $value['full_address'],
                            'student_id'    => $student_id,
                            'admin_id'      => authInfo()->id
                        ]);
                }             
            }            
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        $title = trans('student::local.show_student_data');
        $nationalities = Nationality::sort()->get();
        $speakingLangs = Language::sort()->where('lang_type','speak')->get();
        $studyLangs = Language::sort()->where('lang_type','<>','speak')->get();
        $regStatus = RegistrationStatus::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();                
        $schools = School::all();
        $guardians = Guardian::all();        
        $father_id = Student::findOrFail($student)->first()->father_id;
        $mothers = Mother::whereHas('fathers',function($q) use ($father_id){
            $q->where('father_id',$father_id);
        })->get();
                
        return view('student::students.show',
        compact('student','title','nationalities','speakingLangs','studyLangs','regStatus',
        'divisions','grades','schools','guardians','mothers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $father_id = Student::findOrFail($student)->first()->father_id;
        $mothers = Mother::whereHas('fathers',function($q) use ($father_id){
            $q->where('father_id',$father_id);
        })->get();
                
        $nationalities = Nationality::sort()->get();
        $speakingLangs = Language::sort()->where('lang_type','speak')->get();
        $studyLangs = Language::sort()->where('lang_type','<>','speak')->get();
        $regStatus = RegistrationStatus::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();        
        
        $schools = School::all();
        $guardians = Guardian::all();        
        
        $title = trans('student::local.edit_student');
        return view('student::students.edit',
        compact('nationalities','title','speakingLangs','studyLangs','regStatus','mothers',
        'divisions','grades','schools','guardians','student'));
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
        DB::transaction(function () use ($request,$student) {            
            $student->update($request->only($this->studentAttributes()));
            
            $this->studentAdmissionSteps($student->id);
            
            $this->studentDeliverDocuments($student->id);
            
            $this->studentMedicalQuery($student->id);
            
            $this->studentAddresses($student->id);
        });   

        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('students.show',$student->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Student::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
