<?php

namespace Student\Http\Controllers\Admissions;
use App\Http\Controllers\Controller;

use App\Employee;
use App\Http\Requests\AssessmentRequest;
use Student\Models\Admissions\Assessment;
use Illuminate\Http\Request;
use Student\Models\Settings\AcceptanceTest;
use Student\Models\Students\Student;
use DB;
use PDF;
use Student\Models\Admissions\Test;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {       
            $data = Assessment::with('students')->get();
            
            return datatables($data)
            ->addIndexColumn()
            ->addColumn('studentName',function($data){
                return $this->getFullStudentName($data);                                         
            })
            ->addColumn('studentImage',function($data){
                return $this->studentImage($data);                        
            })
            ->addColumn('application_date',function($data){
                return $data->students->application_date;                       
            })
            ->addColumn('assessment_type',function($data){
                return $data->assessment_type == trans('student::local.assessment') ? $data->assessment_type: '<span class="blue">'.$data->assessment_type.'</span>';                       
            })
            ->addColumn('acceptance',function($data){
                return $data->acceptance == trans('student::local.accepted') ? '<span class="success">'.$data->acceptance.'</span>': '<span class="red">'.$data->acceptance.'</span>';                       
            })
            ->addColumn('student_number',function($data){
                return $data->students->student_number;                       
            })            
            ->addColumn('show_tests',function($data){
                return '<a class="btn btn-primary" href='.route('assessment-result.show',$data->id).'>'.trans('student::local.show_tests').'</a>';                        
            })
            ->addColumn('student_type',function($data){
                return $data->students->student_type == trans('student::local.applicant') ? '<span class="red">'. trans('student::local.applicant') .'</span>': trans('student::local.student');
            })
            ->addColumn('grade',function($data){
                return session('lang') == 'ar' ? $data->students->grade->ar_grade_name:
                $data->students->grade->en_grade_name;
            })
            ->addColumn('division',function($data){
                return session('lang') == 'ar' ? $data->students->division->ar_division_name:
                $data->students->division->en_division_name;
            })
            ->addColumn('check', function($data){
                   $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->rawColumns(['check','studentName','grade','student_type',
            'division','studentImage','show_tests','studentImage','application_date','student_type','assessment_type','acceptance'])
            ->make(true);
            
        }
        $title = trans('student::local.assessment_results');        
        return view('student::admissions.assessment-results.index',
        compact('title'));  
    }
    private function getFullStudentName($data)
    {        
        if (session('lang') == 'ar') {
            return '<a href="'.route('students.show',$data->students->id).'">'.$data->students->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->students->father_id).'">'.$data->students->father->ar_st_name.
            ' '.$data->students->father->ar_nd_name.' '.$data->students->father->ar_rd_name.' '.$data->students->father->ar_th_name.'</a> ' ;    
        }else{
            return '<a href="'.route('students.show',$data->students->id).'">'.$data->students->ar_student_name .'</a> <br> <a href="'.route('father.show',$data->students->father_id).'">'.$data->students->father->ar_st_name.
            ' '.$data->students->father->ar_nd_name.' '.$data->students->father->ar_rd_name.' '.$data->students->father->ar_th_name.'</a> ' ;    
        }
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::where('student_type','applicant')->orderBy('ar_student_name','asc')->get();
        $tests = AcceptanceTest::sort()->get();
        $employees = Employee::all();
        $title = trans('student::local.new_assessment');
        return view('student::admissions.assessment-results.create',
        compact('title','students','tests','employees'));
    }
    private function attributes()
    {
        return [
            'student_id',
            'notes',
            'admin_id',
            'assessment_type',
            'acceptance'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssessmentRequest $request)
    {
        // dd(request()->all());
        DB::transaction(function () use ($request) {                    
            $assessment = $request->user()->assessments()->create($request->only($this->attributes()));                            
            
            $this->storeExams($assessment->id);
        });      
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('assessment-result.index');
    }
    
    public function storeExams($assessment_id)
    {        
        if (request()->has('repeater-group')) {                      
            foreach (request('repeater-group') as $tests) {                  
                Test::create([
                    'assessment_id'         => $assessment_id,
                    'acceptance_test_id'    => $tests['acceptance_test_id'],
                    'test_result'           => $tests['test_result'],
                    'employee_id'           => $tests['employee_id']
                ]);                              
            }            
        }      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employees = Employee::all();
        $tests = AcceptanceTest::sort()->get();
        $assessment = Assessment::with('students','tests')->findOrFail($id);                
        $title = trans('student::local.show_tests');        
        return view('student::admissions.assessment-results.show',
        compact('title','assessment','tests','employees'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function edit(Assessment $assessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function update(AssessmentRequest $request,$id)
    {
        $assessment = Assessment::findOrFail($id);
        $assessment->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('assessment-result.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Assessment  $assessment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Assessment $assessment)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {                
                foreach (request('id') as $id) {
                    Assessment::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function destroyTest()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {                
                foreach (request('id') as $id) {
                    Test::destroy($id);
                }
            }
        }
        return response(['status'=>true]);        
    }
    public function storeTest()
    {
        if (request()->ajax()) {
            Test::create([
                'assessment_id'         => request('assessment_id'),
                'acceptance_test_id'    => request('acceptance_test_id'),
                'test_result'           => request('test_result'),
                'employee_id'           => request('employee_id'),
            ]); 
        }
        return response(['status'=>true]);   
    }
    public function printReport($id)
    {
        $data['schoolName'] = schoolName();    
        $data['logo'] = logo(); 
        $data['tests'] =  AcceptanceTest::sort()->get();
        $data['assessment'] =  Assessment::with('students','tests')->findOrFail($id); 
        $data['title'] = 'Assessment Result';        
        $filename = 'result.pdf';

        $pdf = PDF::loadView('student::admissions.assessment-results.pdf-report', $data);
		return $pdf->stream( $filename);
    }
}
