<?php

namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;
use App\Models\Admin;
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
use PDF;
use Student\Models\Settings\Design;
use Student\Models\Students\SetMigration;
use Student\Models\Students\StudentStatement;
use Carbon;
use Student\Models\Students\ReportContent;
use DateTime;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\DocumentGrade;
use Student\Models\Students\Room;

class StudentController extends Controller
{
    private $father_id;
    private $dd;
    private $mm;
    private $yy;
    private $student_image;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Student::with('nationalities','regStatus','division','father','grade')
            ->orderBy('ar_student_name','asc')
            ->get();
            return $this->dataTable($data);
        }
        $regStatus = RegistrationStatus::sort()->get();
        $grades = Grade::sort()->get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.students');
        return view('student::students.index',
        compact('regStatus','grades','divisions','title'));  
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
                src="'.asset('images/studentsImages/37.jpeg').'" />
            </a>';
    }

    private function moreBtn($data)
    {
        return $data->student_type == trans('student::local.student')?'
        <div class="btn-group mr-1 mb-1">
            <button type="button" class="btn btn-primary"> '.trans('student::local.more').'</button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="'.route('students.edit',$data->id).'"><i class="la la-edit"></i> '.trans('student::local.editing').'</a>               
                <div class="dropdown-divider"></div>  
                <a target="_blank" class="dropdown-item" href="'.route('students.print',$data->id).'"><i class="la la-print"></i> '.trans('student::local.print').'</a>                                             
                <a target="_blank" class="dropdown-item" href="'.route('student-report.print',$data->id).'"><i class="la la-print"></i> '.trans('student::local.commissioner').'</a>
                <a target="_blank" class="dropdown-item" href="'.route('students.proof-enrollment',$data->id).'"><i class="la la-print"></i> '.trans('student::local.add_proof_enrollments').'</a>                                
            </div>
        </div>':'
        <div class="btn-group mr-1 mb-1">
            <button type="button" class="btn btn-warning">'.trans('student::local.more').'</button>
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="'.route('students.edit',$data->id).'"><i class="la la-edit"></i> '.trans('student::local.editing').'</a>                
                <a target="_blank" class="dropdown-item" href="'.route('students.print',$data->id).'"><i class="la la-print"></i> '.trans('student::local.print').'</a>                                             
                <a target="_blank" class="dropdown-item" href="'.route('students.statement-request',$data->id).'"><i class="la la-print"></i> '.trans('student::local.print_statement_request').'</a>                                             
            </div>
        </div>';
    }

    private function getFullStudentName($data)
    {        
        if (session('lang') == 'ar') {
            return '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="'.route('students.show',$data->id).'">'.$data->en_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->en_st_name.
            ' '.$data->father->en_nd_name.' '.$data->father->en_rd_name.' '.$data->father->en_th_name.'</a> ' ;    
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
        $speakingLangs = Language::sort()->where('lang_type','<>','study')->get();
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
        $admins = Admin::active()->get();
        $guardians = Guardian::all();
        
        $title = trans('student::local.new_student');
        return view('student::students.create',
        compact('nationalities','title','speakingLangs','studyLangs','regStatus',
        'father','mothers','divisions','grades','documents','steps','schools','guardians','admins'));
    }

    private function studentAttributes()
    {
        return [
            'father_id',
            'mother_id',
            'employee_id',
            'student_type',
            'ar_student_name',
            'en_student_name',
            'student_id_number',
            'student_id_type',
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
            'siblings',
            'twins',
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
        if ($this->checkAgeForGrade() == 'older' ) {            
            toast(trans('student::local.older_message'),'error');  
            return back()->withInput();           
        }
        if ($this->checkAgeForGrade() == 'smaller' ) {            
            toast(trans('student::local.smaller_message'),'error');  
            return back()->withInput();             
        }
        if ($this->checkAgeForGrade() == 'invalid' ) {            
            toast(trans('student::local.invalid_message'),'error');  
            return back()->withInput();           
        }        
        DB::transaction(function () use ($request) {        
            $this->uploadStudentImage($request->id);
            $student = $request->user()->students()->create($request->only($this->studentAttributes()) 
            + [
                'student_image' => $this->student_image,
                'student_number'=> $this->studentNumber(),
                'code'          => $this->studentCode(),
                'year_id'       => currentYear()]);  
            
            $this->studentAdmissionSteps($student->id);
            
            $this->studentDeliverDocuments($student->id);     
            
            $this->studentMedicalQuery($student->id);
            
            $this->studentAddresses($student->id);

            $this->updateTwinsAndSiblings($student->father_id,$student->dob,$student->id);
        });      
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father.show',$request->father_id);
    }
    private function uploadStudentImage($student_id)
    {
        if (request()->hasFile('student_image'))
        {
            $student = Student::findOrFail($student_id);
            $image_path = public_path()."/images/studentsImages/".$student->student_image;                                                    
            $this->student_image = uploadFileOrImage($image_path,request('student_image'),'images/studentsImages'); 
        } 
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
        
        return getYearAcademic().request('grade_id').request('division_id').$student_id;
        
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

            foreach (request('repeater-group') as $address) {                 
                foreach ($address as $value) {
                    if (!empty($value)) {
                        DB::table('student_address')->insert(
                            [
                                'full_address'  => $value,
                                'student_id'    => $student_id,
                                'admin_id'      => authInfo()->id
                            ]); 
                    }
                                                  
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
        $speakingLangs = Language::sort()->where('lang_type','<>','study')->get();
        $studyLangs = Language::sort()->where('lang_type','<>','speak')->get();
        $regStatus = RegistrationStatus::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();                
        $schools = School::all();
        $guardians = Guardian::all(); 
        $admins = Admin::active()->get();       
        $father_id = $student->father_id;
        $statements = StudentStatement::where('student_id',$student->id)->get();        
        $mothers = Mother::whereHas('fathers',function($q) use ($father_id){
            $q->where('father_id',$father_id);
        })->get();

        $siblings = Student::with('division','grade')->where('father_id',$student->father_id)->orderBy('dob')->get();
        
        $classroom = $student->student_type == trans('student::local.student') ?$this->getStudentClassroom($student->id):
        trans('student::local.applicant');
        
        return view('student::students.show',
        compact('student','title','nationalities','speakingLangs','studyLangs','regStatus',
        'divisions','grades','schools','guardians','mothers','admins','statements','classroom','siblings'));
    }
    private function getStudentClassroom($student_id)
    {
        $classroom_id = Room::where('student_id',$student_id)
        ->where('year_id',currentYear())
        ->first();        
        if (empty($classroom_id)) {
            return trans('student::local.no_class_registered');
        }
        $classroom = Classroom::findOrFail($classroom_id->classroom_id);
        return session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom;        
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
        $speakingLangs = Language::sort()->where('lang_type','<>','study')->get();
        $studyLangs = Language::sort()->where('lang_type','<>','speak')->get();
        $regStatus = RegistrationStatus::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();        
        
        $schools = School::all();
        $guardians = Guardian::all();        
        $admins = Admin::active()->get();
        $title = trans('student::local.edit_student');
        return view('student::students.edit',
        compact('nationalities','title','speakingLangs','studyLangs','regStatus','mothers',
        'divisions','grades','schools','guardians','student','admins'));
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
        if ($this->checkAgeForGrade() == 'older' ) {            
            toast(trans('student::local.older_message'),'error');  
            return back()->withInput();           
        }
        if ($this->checkAgeForGrade() == 'smaller' ) {            
            toast(trans('student::local.smaller_message'),'error');  
            return back()->withInput();             
        }
        if ($this->checkAgeForGrade() == 'invalid' ) {            
            toast(trans('student::local.invalid_message'),'error');  
            return back()->withInput();           
        }
        $student_type = $request->student_type == 'applicant' ? trans('student::local.applicant') : trans('student::local.student');

        if (!checkYearStatus(currentYear()) && $this->checkStudentStatement($student)) {

            if ($student_type != $student->student_type) {
                toast(trans('student::local.invalid_student_type'),'error');  
                return back()->withInput();  
            }

            if ($request->division_id != $student->division_id) {
                toast(trans('student::local.invalid_division_id'),'error');  
                return back()->withInput();  
            } 
            
            if ($request->grade_id != $student->grade_id) {
                toast(trans('student::local.invalid_grade_id'),'error');  
                return back()->withInput();  
            }  
            
            if ($request->registration_status_id != $student->registration_status_id) {
                toast(trans('student::local.invalid_reg_status_id'),'error');  
                return back()->withInput();  
            }             
        }

        if ($student_type != $student->student_type || $request->division_id != $student->division_id
        || $request->grade_id != $student->grade_id) {
            Room::where('student_id',$student->id)->where('year_id',currentYear()) ->delete();
        }

        DB::transaction(function () use ($request,$student) { 
            if (request()->has('student_image')) {
                $this->uploadStudentImage($student->id);        
                $student->update($request->only($this->studentAttributes())
                + ['student_image' => $this->student_image]);                
            } else{
                $student->update($request->only($this->studentAttributes()));              
            }
            
            $this->studentAdmissionSteps($student->id);
            
            $this->studentDeliverDocuments($student->id);                   
            
            $this->studentAddresses($student->id);

            $this->updateTwinsAndSiblings($student->father_id,$student->dob,$student->id);
        });   
        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('students.show',$student->id);
    }

    private function checkStudentStatement($student)
    {
        $result = StudentStatement::where('student_id',$student->id)
        ->where('year_id',currentYear())->first();

        if (empty($result)) {
            return false;
        }
        return true;
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
                    $student = Student::findOrFail($id);
                    $file_path = public_path()."/images/studentsImages/".$student->student_image;                                                             
                    removeFileOrImage($file_path); // remove file from directory
                    Student::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function advancedSearchPage()
    {     
        $nationalities = Nationality::sort()->get();        
        $studyLangs = Language::sort()->where('lang_type','<>','speak')->get();
        $regStatus = RegistrationStatus::sort()->get();
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $documents = AdmissionDoc::sort()->get();
        $steps = Step::sort()->get();   
        $schools = School::all();
        
        
        $title = trans('student::local.advancedSearch');
        return view('student::advanced-search.search',
        compact('nationalities','title','studyLangs','regStatus',
        'divisions','grades','documents','steps','schools'));
    }
    private function returnDataQuery()
    {
        return ' SELECT * FROM full_student_data WHERE ar_student_name <> "" ';
    }
    public function search()
    {            
        // filer
            $filter         = array();
            $attribute      = array();

            if (!empty(request('student_id_type'))) {
                $filter[] = "'".request('student_id_type')."'";
                $attribute[] = 'student_id_type';
            }
            if (!empty(request('gender'))) {
                $filter[] = "'".request('gender')."'";
                $attribute[] = 'gender';
            }
            if (!empty(request('student_type'))) {
                $filter[] = "'".request('student_type')."'";
                $attribute[] = 'student_type';
            }
            if (!empty(request('reg_type'))) {
                $filter[] = "'".request('reg_type')."'";
                $attribute[] = 'reg_type';
            }
            if (!empty(request('registration_status_id'))) {
                $filter[] = request('registration_status_id');
                $attribute[] = 'registration_status_id';
            }
            if (!empty(request('educational_mandate'))) {
                $filter[] = "'" .request('educational_mandate') ."'";
                $attribute[] = 'educational_mandate';
            }
            if (!empty(request('division_id'))) {
                $filter[] = "'" .request('division_id') ."'";
                $attribute[] = 'division_id';
            }
            if (!empty(request('grade_id'))) {
                $filter[] = "'" .request('grade_id') ."'";
                $attribute[] = 'grade_id';
            }
            if (!empty(request('term'))) {
                $filter[] = "'" .request('term') ."'";
                $attribute[] = 'term';
            }
            if (!empty(request('school_id'))) {
                $filter[] = "'" .request('school_id') ."'";
                $attribute[] = 'school_id';
            }
            if (!empty(request('second_lang_id'))) {
                $filter[] = "'" .request('second_lang_id') ."'";
                $attribute[] = 'second_lang_id';
            }
            if (!empty(request('recognition'))) {
                $filter[] = "'" .request('recognition') ."'";
                $attribute[] = 'recognition';
            }
        // end filter
            
        // set = or Null
            $filterCounter = count($filter);
            $orderBy = ' order by full_student_data.ar_student_name asc';
            $factor = array();

            if (isset($filter[0])) {$factor[0] = $filter[0] == 'Null'? $attribute[0].' is ' . $filter[0]: $attribute[0].' = ' . $filter[0];}
            if (isset($filter[1])) {$factor[1] = $filter[1] == 'Null'? $attribute[1].' is ' . $filter[1]: $attribute[1].' = ' . $filter[1];}
            if (isset($filter[2])) {$factor[2] = $filter[2] == 'Null'? $attribute[2].' is ' . $filter[2]: $attribute[2].' = ' . $filter[2];}
            if (isset($filter[3])) {$factor[3] = $filter[3] == 'Null'? $attribute[3].' is ' . $filter[3]: $attribute[3].' = ' . $filter[3];}
            if (isset($filter[4])) {$factor[4] = $filter[4] == 'Null'? $attribute[4].' is ' . $filter[4]: $attribute[4].' = ' . $filter[4];}
            if (isset($filter[5])) {$factor[5] = $filter[5] == 'Null'? $attribute[5].' is ' . $filter[5]: $attribute[5].' = ' . $filter[5];}
            if (isset($filter[6])) {$factor[6] = $filter[6] == 'Null'? $attribute[6].' is ' . $filter[6]: $attribute[6].' = ' . $filter[6];}
            if (isset($filter[7])) {$factor[7] = $filter[7] == 'Null'? $attribute[7].' is ' . $filter[7]: $attribute[7].' = ' . $filter[7];}
            if (isset($filter[8])) {$factor[8] = $filter[8] == 'Null'? $attribute[8].' is ' . $filter[8]: $attribute[8].' = ' . $filter[8];}
            if (isset($filter[9])) {$factor[9] = $filter[9] == 'Null'? $attribute[9].' is ' . $filter[9]: $attribute[9].' = ' . $filter[9];}
            if (isset($filter[10])) {$factor[10] = $filter[10] == 'Null'? $attribute[10].' is ' . $filter[10]: $attribute[10].' = ' . $filter[10];}
            if (isset($filter[11])) {$factor[11] = $filter[11] == 'Null'? $attribute[11].' is ' . $filter[11]: $attribute[11].' = ' . $filter[11];}
            
            $where = '';
            $sqlWhere = '';
            $searchWord = empty( request('inputSearch'))? 'null':request('inputSearch');
            
            $searchWord = str_replace('\'', '"', $searchWord);
            for ($i=0; $i < $filterCounter ; $i++) {
                $where .=  ' and '. $factor[$i];
            }
            // field search
            if (request()->has('field')) {
                $filedSearch = request('field');
                
                $filedSearchCount = count(request('field'));
                $logicFactor = $filedSearchCount == 1 ? '' : ' or ';
                
                $sqlWhere .= ' and (';
                // set like or =
                $sql_like = '';
                for ($i=0; $i < $filedSearchCount ; $i++) {
                    if ($filedSearch[$i] == 'student_number') {
                        $sql_like = " = " . $searchWord ;
                    }
                    elseif ($filedSearch[$i] == 'student_id_number') {
                        $sql_like = " = " . $searchWord ;
                    }
                    elseif ($filedSearch[$i] == 'id_number') {
                        $sql_like = " = " . $searchWord ;
                    }  
                    elseif ($filedSearch[$i] == 'id_number_m') {
                        $sql_like = " = " . $searchWord ;
                    }                                                 
                    else{
                        $sql_like = " like '%" . $searchWord . "%'";
                    }
                    $sqlWhere .= $logicFactor . '' . $filedSearch[$i] . $sql_like;
                }
                $sqlWhere .= ')';
            }
            $sql = $where . $sqlWhere . $orderBy;
            $sql = str_replace('( or', '(', $sql);
            $data = DB::select($this->returnDataQuery() . $sql) ;
            
            
        // end set = or Null

        return datatables($data)
            ->addIndexColumn()                
            ->addColumn('check', function($data){
                $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->addColumn('student_name',function($data){
                $studentName = session('lang') == 'ar' ? $data->ar_student_name:$data->en_student_name;
                return '<a href="'.route('students.show',$data->student_id).'">'.$studentName.'</a>';
            })                
            ->addColumn('father_name',function($data){
                return $this->getFatherName($data);
            })
            ->addColumn('registration_status',function($data){
                return session('lang') == 'ar' ? $data->ar_name_status:$data->en_name_status;
            })
            ->addColumn('religion',function($data){
                return $this->getReligion($data);     
            })
            ->addColumn('reg_type',function($data){
                return $this->regType($data);     
            })                
            ->addColumn('student_type',function($data){
                return $data->student_type == 'applicant'? trans('student::local.applicant').'</span>':trans('student::local.student');     
            })
            ->addColumn('student_id_type',function($data){
                return $data->student_id_type == 'passport' ?  trans('student::local.passport'): trans('student::local.national_id');     
            })
            ->addColumn('grade',function($data){
                return session('lang') == 'ar' ? $data->ar_grade_name:$data->en_grade_name;
            })
            ->addColumn('division',function($data){
                return session('lang') == 'ar' ? $data->ar_division_name: $data->en_division_name;
            })                
            ->rawColumns(['check','father_name','studentImage','registration_status','religion','student_type',
            'grade','division','student_name','reg_type','student_id_type'])
            ->make(true);
    }
    private function getFatherName($data)
    {
        return session('lang') == 'ar' ?
        '<a href="'.route('father.show',$data->father_id).'">'.$data->ar_st_name .' '.$data->ar_nd_name .' '.$data->ar_rd_name .' '.$data->ar_th_name.'</a>'  :
        '<a href="'.route('father.show',$data->father_id).'">'.$data->en_st_name .' '.$data->en_nd_name .' '.$data->en_rd_name .' '.$data->en_th_name.'</a>';  
    }
    private function regType($data)
    {
        $regType = '';
        switch ($data->reg_type) {
            case 'return':
                $regType = trans('student::local.return');
                break;
            case 'arrival':
                $regType = trans('student::local.arrival');
                break;
            case 'noob':
                $regType = trans('student::local.noob');
                break;                                        
            default:
            $regType = trans('student::local.transfer');
                break;
        }
        return $regType;
    }
    private function checkAgeForGrade()
    {
        //  calculate age
        $age = getStudentAge(request('dob'));
   
        $this->mm = $age['mm'];
        $this->yy = $age['yy'];
        $gradeData = Grade::where('id',request('grade_id'))->first();  
        
        if ($this->yy != 0) {
            if ($this->yy > $gradeData->to_age_year) {
                return 'older';
            }elseif($this->yy == $gradeData->to_age_year){
                if ($this->mm > $gradeData->to_age_month) {
                    return 'older';
                }
            }
        }
        if ($this->yy != 0) {
            if ($this->yy < $gradeData->from_age_year) {
                return 'smaller';
            }elseif($this->yy == $gradeData->from_age_year){
                if ($this->mm < $gradeData->from_age_month) {
                    return 'smaller';
                }
            }
        }
        if ($this->yy == 0) {
            return 'invalid';
        }
    }
    public function printApplicationReport($student_id)
    {        
        $student  = Student::with('nationalities','regStatus','division','grade','father','mother')
        ->findOrFail($student_id);

        $required_documents = AdmissionDoc::with('docsGrade')
        ->whereHas('docsGrade',function($q) use ($student){
            $q->where('grade_id',$student->grade_id);
        })->get();  

        // dd(preg_match('/transfer/i', $student->reg_type) );
           
        $data = [
            'title'             => $student->student_number,       
            'student'           => $student,
            'required_documents'=> $required_documents,
            'logo'              => logo(),
            'schoolName'        => getSchoolName($student->division_id),          
            'studentPathImage'  => public_path('images/studentsImages/'),
        ];

        $pdf = PDF::loadView('student::students.reports.pdf-application', $data);
		return $pdf->stream($student->student_number);
    }

    public function filter()
    {        
        if (request()->ajax()) {
            $status = empty(request('status_id')) ? ['students.registration_status_id','<>', ''] :['registration_status_id', request('status_id')]   ;
            $student_type = empty(request('student_type')) ? ['students.student_type','<>', ''] :['student_type', request('student_type')]   ;
            $division_id = empty(request('division_id')) ? ['students.division_id','<>', ''] :['division_id', request('division_id')]   ;
            $grade_id = empty(request('grade_id')) ? ['students.grade_id','<>', ''] :['grade_id', request('grade_id')]   ;
            
            $whereData = [$division_id, $grade_id, $status, $student_type];
            
            $data = Student::with('nationalities','regStatus','division','father','grade')            
            ->where($whereData)         
            ->orderBy('ar_student_name','asc')                
            ->get();     
                        
            return $this->dataTable($data);
        }
    }
    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('studentName',function($data){
                return $this->getFullStudentName($data);                                         
            })
            ->addColumn('moreBtn',function($data){
                return $this->moreBtn($data);                                         
            })
            ->addColumn('studentImage',function($data){
                return $this->studentImage($data);                        
            })
            ->addColumn('registration_status',function($data){
                return session('lang') == 'ar' ? $data->regStatus->ar_name_status:
                $data->regStatus->en_name_status;
            })
            ->addColumn('student_type',function($data){
                return $data->student_type == trans('student::local.applicant') ? '<span class="red">'.$data->student_type.'</span>':$data->student_type;     
            })
            ->addColumn('grade',function($data){
                return session('lang') == 'ar' ? $data->grade->ar_grade_name . '<br><span class="purple">' .$data->division->ar_division_name.'</span>':
                $data->grade->en_grade_name . '<br><span class="purple">' .$data->division->en_division_name .'</span>';
            })      
            ->addColumn('check', function($data){
                $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->rawColumns(['check','studentName','registration_status','grade','student_type',
            'studentImage','moreBtn'])
            ->make(true);
    }
    public function getGradesData()
    {
        $data = [];
        if (request()->ajax()) {
            $current_grade_id = Student::with('grade')->findOrFail(request('student_id'));

            $data['current_grade_id'] = session('lang') == 'ar'?$current_grade_id->grade->ar_grade_name:
            $current_grade_id->grade->en_grade_name;
            
            $next_grade_id = SetMigration::with('toGrade')->where('from_grade_id',$current_grade_id->grade_id)->first();
            
            $data['next_grade_id'] = $next_grade_id->toGrade->ar_grade_name;
            
            $data['division'] = session('lang') == 'ar'?$current_grade_id->division->ar_division_name
            :$current_grade_id->division->en_division_name;
            
        }
        return json_encode($data);
        
    }
    public function proofEnrollment($id)
    {
        $student = Student::with('grade','division','father','nationalities')->findOrFail($id);                
        $division_id = $student->division_id;
        $content = ReportContent::first()->proof_enrollment;

        $student_name = session('lang') == 'ar' ? $student->ar_student_name .' ' . $student->father->ar_st_name
        .' ' . $student->father->ar_nd_name.' ' . $student->father->ar_rd_name
        : $student->en_student_name .' ' . $student->father->en_st_name
        .' ' . $student->father->en_nd_name.' ' . $student->father->en_rd_name ;

        $father_name  = session('lang') == 'ar' ? $student->father->ar_st_name
        .' ' . $student->father->ar_nd_name.' ' . $student->father->ar_rd_name.' ' . $student->father->ar_th_name: 
        $student->father->en_st_name
        .' ' . $student->father->en_nd_name.' ' . $student->father->en_rd_name.' ' . $student->father->en_th_name ;
        $father_national_id  = $student->father->id_number ;
        
        $division  = session('lang') == 'ar' ? $student->division->ar_division_name: $student->division->en_division_name ;
        $grade  = session('lang') == 'ar' ? $student->grade->ar_grade_name: $student->grade->en_grade_name ;
        
        $content = str_replace('student_name',$student_name ,$content);
        $content = str_replace('nationality',$student->nationalities->ar_name_nat_male ,$content);
        $content = str_replace('religion',$student->religion ,$content);

        $dob =  DateTime::createFromFormat("Y-m-d",$student->dob);
        
        $content = str_replace('dob', $dob->format("Y/m/d") ,$content);
        
        $content = str_replace('division',$division ,$content);        
        $content = str_replace('grade',$grade ,$content);
        $content = str_replace('national_id',$student->student_id_number ,$content);
        
        $content = str_replace('school_name',getSchoolName($division_id) ,$content); 

        $year = fullAcademicYear();
        $content = str_replace('year',$year ,$content);

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        
        
        $data = [         
            'title'                         => trans('student::local.proof_enrollment'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'school_name'                   => getSchoolName($division_id),               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
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

        $pdf = PDF::loadView('student::students.reports.proof', $data,[],$config);
        return $pdf->stream(trans('student::local.proof_enrollment'));
    }

    public function statementRequest($id)
    {
        $student = Student::with('grade','division','father','nationalities')->findOrFail($id);                
        $division_id = $student->division_id;
        $content = ReportContent::first()->statement_request;

        $student_name = session('lang') == 'ar' ? $student->ar_student_name .' ' . $student->father->ar_st_name
        .' ' . $student->father->ar_nd_name.' ' . $student->father->ar_rd_name
        : $student->en_student_name .' ' . $student->father->en_st_name
        .' ' . $student->father->en_nd_name.' ' . $student->father->en_rd_name ;

        $father_name  = session('lang') == 'ar' ? $student->father->ar_st_name
        .' ' . $student->father->ar_nd_name.' ' . $student->father->ar_rd_name.' ' . $student->father->ar_th_name: 
        $student->father->en_st_name
        .' ' . $student->father->en_nd_name.' ' . $student->father->en_rd_name.' ' . $student->father->en_th_name ;
        $father_national_id  = $student->father->id_number ;
        
        $division  = session('lang') == 'ar' ? $student->division->ar_division_name: $student->division->en_division_name ;
        $grade  = session('lang') == 'ar' ? $student->grade->ar_grade_name: $student->grade->en_grade_name ;
        
        $content = str_replace('student_name',$student_name ,$content);
        $content = str_replace('nationality',$student->nationalities->ar_name_nat_male ,$content);
        $content = str_replace('religion',$student->religion ,$content);

        $dob =  DateTime::createFromFormat("Y-m-d",$student->dob);
        
        $content = str_replace('dob', $dob->format("Y/m/d") ,$content);
        
        $content = str_replace('division',$division ,$content);        
        $content = str_replace('grade',$grade ,$content);
        $content = str_replace('national_id',$student->student_id_number ,$content);
        
        $content = str_replace('school_name',getSchoolName($division_id) ,$content); 

        $year = fullAcademicYear();
        $content = str_replace('year',$year ,$content);

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        
        
        $data = [         
            'title'                         => trans('student::local.statement_request'),       
            'content'                       => $content,       
            'logo'                          => logo(),            
            'school_name'                   => getSchoolName($division_id),               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
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

        $pdf = PDF::loadView('student::students.reports.statement-request', $data,[],$config);
        return $pdf->stream( trans('student::local.statement_request'));
    }

    private function updateTwinsAndSiblings($father_id, $dob, $student_id)
    {    
        $father_id = request()->has('father_id') ? request('father_id') : $father_id;
        $dob = request()->has('dob') ? request('dob') : $dob;
        $students = Student::where('father_id',$father_id)->get();
        
        if (count($students) > 0) {
            foreach ($students as $student) {
                Student::where('id',$student->id)->update(['siblings'=>'true']);
                if ($dob == $student->dob && $student->id != $student_id ) {
                    $where = [$student->id, $student_id];                        
                    Student::whereIn('id',$where)->update(['twins'=>'true']);
                }
            }            
        }
    }
}
