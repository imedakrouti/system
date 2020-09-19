<?php

namespace Student\Http\Controllers\ParentsAndStudents;
use App\Http\Controllers\Controller;
use App\Models\Admin;
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
use PDF;
use Illuminate\Support\Facades\Storage;
use Student\Models\Settings\Design;
use Student\Models\Students\Address;
use Student\Models\Students\StudentStatement;

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
                        return $this->studentImage($data);                        
                    })
                    ->addColumn('registration_status',function($data){
                        return session('lang') == 'ar' ? $data->regStatus->ar_name_status:
                        $data->regStatus->en_name_status;
                    })
                    ->addColumn('religion',function($data){
                        return $this->getReligion($data);     
                    })
                    ->addColumn('student_type',function($data){
                        return $data->student_type == trans('student::local.applicant') ? '<span class="red">'.$data->student_type.'</span>':$data->student_type;     
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
                    ->rawColumns(['check','studentName','registration_status','religion','grade','student_type',
                    'division','studentImage','moreBtn'])
                    ->make(true);
        }

        return view('student::students.index',
        ['title'=>trans('student::local.students')]);  
    }
    private function studentImage($data)
    {
        return !empty($data->student_image)?
            '<a href="'.route('students.show',$data->id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('storage/student_image/'.$data->student_image).'" />
            </a>':
            '<a href="'.route('students.show',$data->id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('storage/student_image/stu.jpg').'" />
            </a>';
    }

    private function moreBtn($data)
    {
        $image = !empty($data->student_image) ? '<a class="dropdown-item" href="'.route('students.card',$data->id).'">'.trans('student::local.print_id_card').'</a>' :
        '';
        return $data->student_type == trans('student::local.student')?'
        <div class="btn-group mr-1 mb-1">
            <button type="button" class="btn btn-primary"> '.trans('student::local.more').'</button>
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="'.route('students.edit',$data->id).'">'.trans('student::local.editing').'</a>
                '.$image.'
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
        if (session('lang') == 'ar') {
            return '<a href="'.route('students.show',$data->id).'">'.$data->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->ar_st_name.
            ' '.$data->father->ar_nd_name.' '.$data->father->ar_rd_name.' '.$data->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="'.route('students.show',$data->id).'">'.$data->en_student_name .'</a> <br> <a href="'.route('father.show',$data->father_id).'">'.$data->father->en_st_name.
            ' '.$data->father->en_nd_name.' '.$data->father->en_rd_name.' '.$data->father->en_th_name.'</a> ' ;    
        }
    }

    private function getReligion($data)
    {
        if (session('lang') == 'ar') {
            if ($data->gender == trans('student::local.male')) {
                if ($data->religion == trans('student::local.muslim')) {
                    return trans('student::local.muslim');
                }
                else{
                    return trans('student::local.non_muslim');

                }
            }else{
                if ($data->religion == trans('student::local.muslim')) {
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
            return back()->withInput()->with('error',trans('student::local.older_message'));            
        }
        if ($this->checkAgeForGrade() == 'smaller' ) {
            return back()->withInput()->with('error',trans('student::local.smaller_message'));            
        }
        if ($this->checkAgeForGrade() == 'invalid' ) {
            return back()->withInput()->with('error',trans('student::local.invalid_message'));            
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
            
            $this->studentAddresses($student->id);
        });      
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('father.show',$request->father_id);
    }
    private function uploadStudentImage($studentId)
    {
        if (request()->hasFile('student_image'))
        {
            $imageName = Student::findOrFail($studentId)->student_image;
            Storage::delete('public/student_image/'.$imageName);                                             
            
            $imagePath = request()->file('student_image')->store('public/student_image');
            $imagePath = explode('/',$imagePath);
            $imagePath = $imagePath[2];     
                       
            $this->student_image = empty($imagePath)?'':$imagePath;
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
                
        return view('student::students.show',
        compact('student','title','nationalities','speakingLangs','studyLangs','regStatus',
        'divisions','grades','schools','guardians','mothers','admins','statements'));
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
            return back()->withInput()->with('error',trans('student::local.older_message'));            
        }
        if ($this->checkAgeForGrade() == 'smaller' ) {
            return back()->withInput()->with('error',trans('student::local.smaller_message'));            
        }
        if ($this->checkAgeForGrade() == 'invalid' ) {
            return back()->withInput()->with('error',trans('student::local.invalid_message'));            
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
                $filter[] = request('student_id_type');
                $attribute[] = 'student_id_type';
            }
            if (!empty(request('gender'))) {
                $filter[] = request('gender');
                $attribute[] = 'gender';
            }
            if (!empty(request('student_type'))) {
                $filter[] = request('student_type');
                $attribute[] = 'student_type';
            }
            if (!empty(request('reg_type'))) {
                $filter[] = request('reg_type');
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
        $filename                   = 'student-report.pdf';
        $student                    = Student::with('nationalities','regStatus','division','grade','father','mother')
        ->findOrFail($student_id);
           
        $data = [
            'title'             => 'Student Report',       
            'logo'              => logo(),
            'schoolName'        => schoolName(),          
            'student'           => $student,
            'studentPathImage'  =>public_path('storage/student_image/'.$student->student_image),
        		];

        $pdf = PDF::loadView('student::students.pdf-application', $data);
		return $pdf->stream( $filename);
    }
    public function printStudentCard($student_id)
    {
        $student = Student::with('father','division','grade','mother')
        ->where('student_image','<>','null')
        ->first();
        $design  = Design::where('division_id',$student->division_id)->where('grade_id',$student->grade_id)
        ->orderBy('id','desc')->first()->design_name;
        $data = [
            'schoolName'        => settingHelper()->ar_school_name,
            'path'              => public_path('storage/icon/Fpp0u5uXWs3o4vk9wn2hLJhMol3704IoVPXGT0CZ.png'),
            'design'            => public_path('storage/id-designs/'.$design),
            'student'          => $student,
            'studentPathImage'  =>public_path('storage/student_image/'),
        		];
		$pdf = PDF::loadView('student::students.student-card', $data);
		return $pdf->stream($student->student_number);
    }
}
