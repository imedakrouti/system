<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;

use Student\Models\Students\StudentStatement;
use DB;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\RegistrationStatus;
use Student\Models\Settings\Year;
use Student\Models\Students\SetMigration;
use Student\Models\Students\Student;
use PDF;
use Student\Models\Settings\Stage;
use Student\Models\Settings\StageGrade;

class StudentStatementsController extends Controller
{
    public $dob;

    private function prepareDateBirth()
    {
        $this->dob = getStudentAge(request('dob'));
    }

    private function shownRegStatus($regStatusId = null)
    {
        if (!request()->has('registration_status_id')) {
            return RegistrationStatus::findOrFail($regStatusId)->shown;                    
        }
        return RegistrationStatus::findOrFail(request('registration_status_id'))->shown;        
    }

    private function checkExists($studentId)
    {      
        $year = request()->has('to_year_id') ? request('to_year_id') : currentYear();  
        $statement = StudentStatement::where([
            'student_id' =>  $studentId,
            'year_id'    => $year,            
        ])->count();
        if ($statement > 0) {
            return true;
        }
        return false;
    }

    private function attributes()
    {               
        return [
            'student_id'                => request('student_id'),
            'division_id'               => request('division_id'),
            'grade_id'                  => request('grade_id'),
            'registration_status_id'    => request('registration_status_id'),
            'year_id'                   => currentYear(),
            'dd'                        => $this->dob['dd'],
            'mm'                        => $this->dob['mm'],
            'yy'                        => $this->dob['yy'],
        ];
        
    }

    public function addToStatement()
    {          
        if (checkYearStatus(currentYear())) {
            toast(trans('student::local.year_close_add'),'error');  
            return back()->withInput();              
        }  

        $this->prepareDateBirth();  
        $this->shownRegStatus();

        if ($this->checkExists(request('student_id'))) {            
            toast(trans('student::local.student_exist_in_statement'),'error');  
            return back()->withInput();          
        }          

        if ($this->shownRegStatus() != trans('student::local.show_regg')) {            
            toast(trans('student::local.invalid_reg_status'),'error');  
            return back()->withInput();   
        }   

        $data = $this->checkTotalStudents(request('division_id'),currentYear());
       
        if ($data['total_students']-1 >= $data['current_total_students']) {
            request()->user()->statements()->create($this->attributes());               
        }                     
        else{            
            toast(trans('student::local.total_students_stop'),'error');  
            return back(); 
        }

        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('students.show',request('student_id'));
        
    }

    public function index()
    {
        if (request()->ajax()) {
            $data = StudentStatement::with('student','grade','division','regStatus')
            ->limit(100)            
            ->join('students','students_statements.student_id','=','students.id')
            ->orderBy('gender','asc')
            ->orderBy('ar_student_name','asc')
            ->select('students_statements.*')
            ->get();
            return $this->dataTable($data);
        }
        $regStatus = RegistrationStatus::sort()->shown()->get();
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.students_statements');
        return view('student::students-affairs.students-statements.index',
        compact('title','grades','years','divisions','regStatus'));        
    }
    public function filter()
    {
        if (request()->ajax()) {
            $status = empty(request('status_id')) ? ['students_statements.registration_status_id','<>', ''] :
            ['registration_status_id', request('status_id')]   ;
            $whereData = [
                ['students_statements.division_id', request('division_id')],
                ['students_statements.grade_id', request('grade_id')],
                ['students_statements.year_id', request('year_id')]   ,             
                $status             
            ];
            $data = StudentStatement::with('student','grade','division','regStatus')
            ->where($whereData)
            ->join('students','students_statements.student_id','=','students.id')
            ->orderBy('gender','asc')
            ->orderBy('ar_student_name','asc')    
            ->select('students_statements.*')                    
            ->get();     
                        
            return $this->dataTable($data);
        }
    }
    private function fullStudentName($data)
    {   
        if (session('lang') == 'ar') {
          return   '<a href="'.route('students.show',$data->student->id).'">'.$data->student->ar_student_name 
          . ' ' . $data->student->father->ar_st_name
          . ' ' . $data->student->father->ar_nd_name. ' ' . $data->student->father->ar_rd_name.'</a>';
        }else{
            return   '<a href="'.route('students.show',$data->student->id).'">'.$data->student->en_student_name 
            . ' ' . $data->student->father->en_st_name
            . ' ' . $data->student->father->en_nd_name. ' ' . $data->student->father->en_rd_name.'</a>';
        }
    }
    
    private function dataTable($data)
    {
        return datatables($data)
                ->addIndexColumn()
                ->addColumn('student_name',function($data){
                    return $this->fullStudentName($data);
                })
                ->addColumn('regStatus',function($data){
                    return session('lang') == 'ar' ?$data->regStatus->ar_name_status:$data->regStatus->en_name_status;
                })        
                ->addColumn('student_id_number',function($data){
                    return $data->student->student_id_number;
                }) 
                ->addColumn('student_number',function($data){
                    return $data->student->student_number;
                })                   
                ->addColumn('dob',function($data){
                    return $data->student->dob;
                })    
                ->addColumn('grade',function($data){
                    return session('lang') == 'ar' ? $data->grade->ar_grade_name:$data->grade->en_grade_name;
                })   
                ->addColumn('year',function($data){
                    return $data->year->name;
                })                                                                                                                                                                 
                ->addColumn('check', function($data){
                    $btnCheck = '<label class="pos-rel">
                                    <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                    <span class="lbl"></span>
                                </label>';
                        return $btnCheck;
                })
                ->rawColumns(['check','student_name','regStatus','student_id_number','dob','grade','year','student_number'])
                ->make(true);
    }
    public function create()
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $regStatus = RegistrationStatus::sort()->shown()->get();
        $title = trans('student::local.data_migration');
        return view('student::students-affairs.students-statements.create',
        compact('title','grades','years','divisions','regStatus'));    
    }

    public function destroy()
    {
        
        $result = '';
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    $year = StudentStatement::findOrFail($id);                     
                   
                    if (!checkYearStatus($year->year_id)) {
                        StudentStatement::destroy($id);                        
                    }else{
                        $result = trans('student::local.year_close_delete');
                    }
                }
            }
        }
        if (empty($result)) {
            return response(['status'=>true]);
        }else{
            return response(['status'=>false,'msg'=>$result]);
        }
       
    }   
    
    public function storeToStatement()
    {
        if (request()->ajax()) {            
            foreach (request('id') as $studentId) {
                $student = Student::findOrFail($studentId);
                $this->dob = getStudentAge($student->dob); // get dob of student
                $this->insertInToStatement($studentId);                              
            }
        }
        return response(['status'=>true]);
    }

    private function checkTotalStudents($divisionId, $yearId,$gradeId=null)
    {
        if (!is_array($divisionId)) {
            $divisionId = str_split($divisionId);            
        }
        
        $data['total_students'] = Division::whereIn('id',$divisionId)->first()->total_students;        
      
        $data['current_total_students'] = StudentStatement::where('year_id', $yearId)
        ->whereIn('division_id',$divisionId)->count();

        $data['current_student_grade'] = StudentStatement::where('year_id', $yearId)
        ->whereIn('division_id',$divisionId)
        ->where('grade_id',$gradeId)
        ->count();                
        
        return $data;
    }

    public function store()
    {       
        /**
         *  make sure current year is open and next year is close
         */
        if (!checkYearStatus(request('from_year_id'))) {                        
            toast(trans('student::local.close_year_first'),'error');  
            return back()->withInput();                       
        }

        if (checkYearStatus(request('to_year_id'))) {            
            toast(trans('student::local.open_year_first'),'error');  
            return back()->withInput(); 
        }
        /**
         * loop all grades
         */

        $data = $this->checkTotalStudents(request('from_division_id'),request('to_year_id'));
        
        if ($data['total_students'] >= $data['current_total_students']) {
            $grades = Grade::sort()->get();
            
            foreach ($grades as $grade) {
                // get all students in current year
                $whereData = [
                    ['year_id'     , request('from_year_id')],
                    ['division_id' , request('from_division_id')],
                    ['grade_id'    , $grade->id ]
                ];
                $currentStatement = StudentStatement::where($whereData)->get();
        
                foreach ($currentStatement as $statement) {     
                    
                    $toGradeId = SetMigration::where('from_grade_id',$grade->id)->first();
                    // update grade and reg_status in students table
                    Student::where('id',$statement->student_id)
                    ->whereIn('registration_status_id',request('from_status_id'))
                    ->update([
                        'grade_id'                  => $toGradeId->to_grade_id , 
                        'registration_status_id'    => request('to_status_id')]);
                    
                    $student = Student::findOrFail($statement->student_id);
        
                    $this->dob = getStudentAgeByYear(request('to_year_id'),$student->dob); // get dob of student
                    // insert students in statements
                    $this->insertInToStatement($statement->student_id);                     
                }            
            }
    
            toast(trans('msg.stored_successfully'),'success');            
            return redirect()->route('statements.index');        
        }
        else{            
            toast(trans('student::local.total_students_stop'),'error');  
            return back(); 
        }

    }

    private function insertInToStatement($studentId)
    {        
        $student = Student::findOrFail($studentId);        
        if ($this->shownRegStatus($student->registration_status_id) == trans('student::local.show_regg')) {
            
            if (!$this->checkExists($student->id)) { // not exist in statement
                
                if ($student->student_type == trans('student::local.student')) { // only add students not applicants
                    $year_id = request()->has('to_year_id')?request('to_year_id') : currentYear();
                                        
                    request()->user()->statements()->create([
                        'student_id'                => $student->id,
                        'division_id'               => $student->division_id,
                        'grade_id'                  => $student->grade_id,
                        'registration_status_id'    => $student->registration_status_id,
                        'year_id'                   => $year_id,
                        'dd'                        => $this->dob['dd'],
                        'mm'                        => $this->dob['mm'],
                        'yy'                        => $this->dob['yy'],
                    ]);                             
                }                        
            }  
        }  
    }  

    public function restoreMigration()
    {
        if (request()->ajax()) {
          
            $invalid = '';
            
            /**
             *  make sure current year is open and next year is close
             */
            if (!checkYearStatus(currentYear())) {                
                $invalid = trans('student::local.close_year_first');
            }
            elseif (checkYearStatus(request('to_year_id'))) {                
                $invalid = trans('student::local.open_year_first');
            }  
            else{                
                DB::transaction(function ()  {
                    $students = StudentStatement::where('year_id',request('to_year_id'))->get();
                    
                    foreach ($students as $student) {
                        $whereData = [
                            ['year_id',currentYear()],
                            ['student_id',$student->student_id]
                        ];
                        
                        $currentStatement = StudentStatement::where($whereData)->first();
                     
                        if (!empty($currentStatement)) {
                            Student::where('id',$student->student_id)
                            ->update([
                                'grade_id'                  => $currentStatement->grade_id,
                                'registration_status_id'    => $currentStatement->registration_status_id,
                            ]);                          
                        }
        
                        $where = [
                            ['year_id',request('to_year_id')],
                            ['student_id',$student->student_id]
                        ];
                        StudentStatement::where($where)->delete();
                    }                                                        
                });
            }

        }
        if (empty($invalid)) {
            return response(['status'=> true]);            
        }else{
            return response(['status' => false,'msg'=>$invalid]);
        }
    }

    public function statisticsReport()
    {        
        if (empty(request('year_id')) || empty(request('division_id'))) {            
            toast(trans('student::local.ensure_year_division'),'error');  
            return back();
        }

        $data = $this->checkTotalStudents(request('division_id'),request('year_id'));
        
        if ($data['current_total_students'] <= 0) {            
            toast(trans('student::local.no_students_found'),'error');  
            return back();                       
        }
        
        $divisions = request('division_id');
        $total_students = 0;

        for ($i=0; $i < count($divisions); $i++) { 
            $total_students += Division::where('id',$divisions[$i])->first()->total_students;
        }

        
        $grades = Grade::sort()->get();
        $stageGrade = StageGrade::with('grade')->get();

        foreach ($grades as $grade) {
            $where = [
                ['year_id',request('year_id')],
                // ['division_id',request('division_id')],
                ['grade_id',$grade->id],
            ];            
            // male
            $male_muslim[] = StudentStatement::with('student','grade')
            ->whereHas('student',function($q) use ($grade){
                $q->where('gender','male');
                $q->where('religion','muslim');               
            })
            ->whereIn('division_id',request('division_id'))
            ->where($where)->count();  

            $male_non_muslim[] = StudentStatement::with('student','grade')
            ->whereHas('student',function($q) use ($grade){
                $q->where('gender','male');
                $q->where('religion','non_muslim');               
            })
            ->whereIn('division_id',request('division_id'))
            ->where($where)->count();   
            // female
            $female_muslim[] = StudentStatement::with('student','grade')
            ->whereHas('student',function($q) use ($grade){
                $q->where('gender','female');
                $q->where('religion','muslim');               
            })
            ->whereIn('division_id',request('division_id'))
            ->where($where)->count();  
            
            $female_non_muslim[] = StudentStatement::with('student','grade')
            ->whereHas('student',function($q) use ($grade){
                $q->where('gender','female');
                $q->where('religion','non_muslim');        
            })
            ->whereIn('division_id',request('division_id'))
            ->where($where)->count();  
        }

       $stages = Stage::sort()->get();

       foreach ($stages as $stage) {
           $allGrades = StageGrade::where('stage_id',$stage->id)->get();
           $gradesWanted = [];
           foreach ($allGrades as $grade) {
                $gradesWanted[] = $grade->grade_id;
           }
            // muslims
            $total_male_muslim[$stage->id] = StudentStatement::with('student','grade')
                ->whereHas('student',function($q){
                    $q->where('gender','male');
                    $q->where('religion','muslim');               
                })
                ->where([
                        ['year_id',request('year_id')],
                        ['division_id',request('division_id')],           
                    ])   
                ->whereIn('grade_id',$gradesWanted)         
                ->count();

            $total_female_muslim[$stage->id] = StudentStatement::with('student','grade')
                ->whereHas('student',function($q){
                    $q->where('gender','female');
                    $q->where('religion','muslim');               
                })
                ->where([
                        ['year_id',request('year_id')],
                        ['division_id',request('division_id')],           
                    ])   
                ->whereIn('grade_id',$gradesWanted)         
                ->count();  
            
            // non muslims

            $total_male_non_muslim[$stage->id] = StudentStatement::with('student','grade')
                ->whereHas('student',function($q){
                    $q->where('gender','male');
                    $q->where('religion','non_muslim');               
                })
                ->where([
                        ['year_id',request('year_id')],
                        ['division_id',request('division_id')],           
                    ])   
                ->whereIn('grade_id',$gradesWanted)         
                ->count();

            $total_female_non_muslim[$stage->id] = StudentStatement::with('student','grade')
                ->whereHas('student',function($q){
                    $q->where('gender','female');
                    $q->where('religion','non_muslim');               
                })
                ->where([
                        ['year_id',request('year_id')],
                        ['division_id',request('division_id')],           
                    ])   
                ->whereIn('grade_id',$gradesWanted)         
                ->count();             
        
        }

        
        $school_name = '';
        if (count(request('division_id')) == 1) {
           $school_name = getSchoolName($divisions[0]);
        }else{
            for ($i=0; $i < count(request('division_id')) ; $i++) { 
                $school_name .= Division::findOrFail($divisions[$i])->ar_division_name . ' / ';
            }
        }   

        $data = [
            'male_muslims'                  => $male_muslim,
            'male_non_muslims'              => $male_non_muslim,
            'female_muslims'                => $female_muslim,
            'female_non_muslims'            => $female_non_muslim,
            'grades'                        => $grades,
            'stageGrade'                    => $stageGrade,
            'total_male_muslim'             => $total_male_muslim,            
            'total_female_muslim'           => $total_female_muslim,            
            'total_male_non_muslim'         => $total_male_non_muslim,            
            'total_female_non_muslim'       => $total_female_non_muslim,          
            'total_students'                => $total_students,          
            'title'                         => 'Statistics Report',       
            'logo'                          => logo(),
            'year_name'                     => fullAcademicYear(request('year_id')),
            'school_name'                   => $school_name,               
            'education_administration'      => preamble()['education_administration'],               
            'governorate'                   => preamble()['governorate'],               
            ];

        $config = [            
            'margin_header'        => 5,
            'margin_footer'        => 50,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 65,
            'margin_bottom'        => session('lang') == 'ar' ? 52 : 55,
        ];  

		$pdf = PDF::loadView('student::students-affairs.students-statements.reports.statistics-report', $data,[],$config);
		return $pdf->stream('Statistics');
    }

    public function insertStatement()
    {
       /**
        * Add all new students to statement
        */        
        $result = '';
        if (request()->ajax()) {
            if (!checkYearStatus(currentYear())) {
                $students = Student::with('statements','regStatus')
                ->whereHas('regStatus',function($q){
                    $q->where('shown','show');
                })
                ->whereDoesntHave('statements',function($q){
                    $q->where('year_id',currentYear());
                })                
                ->student()
                ->get(); 
                // dd($students);
                foreach ($students as $student) {    
                    $this->dob = getStudentAgeByYear(currentYear(),$student->dob); // get dob of student      
                    
                    $data = $this->checkTotalStudents($student->division_id,currentYear());
                   
                    if ($data['total_students']-1 >= $data['current_total_students']) {
                        $this->insertInToStatement($student->id);                        
                    }else{     
                        $division_name =  session('lang') == 'ar' ? $student->division->ar_division_name : $student->division->en_division_name ;
                        $result = trans('student::local.total_students_stop') . ' [ '. $division_name .' ]';
                    }
                }
                
            }else{
                $result = trans('student::local.open_year_first');
            }
        }
        if (empty($result)) {
            return response(['status'=>true]);
        }else{
            return response(['status'=>false,'msg'=> $result]);
        }
    }

    public function printStatementReport()
    {     
        if (empty(request('year_id')) || empty(request('division_id')) || empty(request('grade_id'))) {
            toast(trans('student::local.ensure_year_division_grade'),'error');  
            return back();
        }

        $data = $this->checkTotalStudents(request('division_id'),request('year_id'), request('grade_id'));
        
        if ($data['current_student_grade'] <= 0) {
            toast(trans('student::local.no_students_found'),'error');  
            return back();            
        }
        $divisions = request('division_id');
                
        $statements = StudentStatement::with('grade','division','regStatus')  
        ->where([            
            ['students_statements.grade_id',request('grade_id')],
            ['students_statements.year_id',request('year_id')],
        ]) 
        ->whereIn('students_statements.division_id',request('division_id'))
        ->join('students','students_statements.student_id','=','students.id')
        ->orderBy('gender','asc')
        ->orderBy('ar_student_name','asc')
        ->select('students_statements.*')
        ->get();                 

        $where = [
            ['year_id',request('year_id')],            
            ['grade_id',request('grade_id')],
        ];            
        // male
        $male_muslim[] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','male');
            $q->where('religion','muslim');               
        })
        ->where($where)
        ->whereIn('division_id',request('division_id'))
        ->count();  

        $male_non_muslim[] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','male');
            $q->where('religion','non_muslim');               
        })
        ->where($where)
        ->whereIn('division_id',request('division_id'))
        ->count();   

        // female
        $female_muslim[] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','female');
            $q->where('religion','muslim');               
        })
        ->where($where)
        ->whereIn('division_id',request('division_id'))
        ->count();  
        
        $female_non_muslim[] = StudentStatement::with('student','grade')
        ->whereHas('student',function($q){
            $q->where('gender','female');
            $q->where('religion','non_muslim');        
        })
        ->where($where)
        ->whereIn('division_id',request('division_id'))
        ->count();                  

        $data = [
                    'title'                     => 'Statement Report',       
                    'statements'                => $statements,
                    'logo'                      => logo(),
                    'school_name'               => getSchoolName($divisions[0]),               
                    'education_administration'  => preamble()['education_administration'],               
                    'governorate'               => preamble()['governorate'],  
                    'male_muslims'              => $male_muslim,
                    'male_non_muslims'          => $male_non_muslim,
                    'female_muslims'            => $female_muslim,
                    'female_non_muslims'        => $female_non_muslim,                                            
                ];
        $config = [
                    'orientation'          => 'L',
                    'margin_header'        => 5,
                    'margin_footer'        => 50,
                    'margin_left'          => 10,
                    'margin_right'         => 10,
                    'margin_top'           => 65,
                    'margin_bottom'        => session('lang') == 'ar' ? 52 : 55,
                ];  

        $pdf = PDF::loadView('student::students-affairs.students-statements.reports.statement-report', 
        $data,[],$config);        
		return $pdf->stream('Statement');
    }
 
}
