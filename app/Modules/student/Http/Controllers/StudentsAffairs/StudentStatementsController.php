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
            return back()->with('error',trans('student::local.year_close_add'));                        
        }  

        $this->prepareDateBirth();  
        $this->shownRegStatus();

        if ($this->checkExists(request('student_id'))) {
            return back()->with('error',trans('student::local.student_exist_in_statement'));            
        }          

        if ($this->shownRegStatus() != trans('student::local.show_regg')) {
            return back()->with('error',trans('student::local.invalid_reg_status'));            
        }   
                                    
        request()->user()->statements()->create($this->attributes());        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('students.show',request('student_id'));
        
    }

    public function index()
    {
        if (request()->ajax()) {
            $data = StudentStatement::with('student','grade','division','regStatus')->limit(100)->orderBy('id','desc');
            return $this->dataTable($data);
        }
        $regStatus = RegistrationStatus::sort()->get();
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
            $status = empty(request('status_id')) ? ['registration_status_id','<>', ''] :['registration_status_id', request('status_id')]   ;
            $whereData = [
                ['division_id', request('division_id')],
                ['grade_id', request('grade_id')],
                ['year_id', request('year_id')]   ,             
                $status             
            ];
            $data = StudentStatement::with('student','grade','division','regStatus')
            ->where($whereData)
            ->get();     
                        
            return $this->dataTable($data);
        }
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
                ->rawColumns(['check','student_name','regStatus','student_id_number','dob','grade','year'])
                ->make(true);
    }
    public function create()
    {
        $grades = Grade::sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $regStatus = RegistrationStatus::sort()->get();
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

    public function store()
    {
        /**
         *  make sure current year is open and next year is close
         */
        if (!checkYearStatus(request('from_year_id'))) {
            return back()->withInput()->with('error',trans('student::local.close_year_first'));
        }

        if (checkYearStatus(request('to_year_id'))) {
            return back()->withInput()->with('error',trans('student::local.open_year_first'));
        }
        /**
         * loop all grades
         */
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
                        Student::where('id',$student->student_id)
                        ->update([
                            'grade_id'                  => $currentStatement->grade_id,
                            'registration_status_id'    => $currentStatement->registration_status_id,
                        ]);
        
                        $students = StudentStatement::where('year_id',request('to_year_id'))->get();
                        
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
 
}
