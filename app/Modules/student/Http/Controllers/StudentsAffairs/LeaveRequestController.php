<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;

use Student\Models\Students\LeaveRequest;
use Student\Models\Students\Student;
use PDF;
use DB;
use Student\Models\Students\ReportContent;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = LeaveRequest::with('students')->orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('show', function($data){
                           $btn = '<a class="btn btn-info" href="'.route('leave-requests.show',$data->id).'">
                           '.trans('student::local.more').'
                       </a>';
                            return $btn;
                    }) 
                    ->addColumn('print', function($data){
                        $btn = '<a class="btn btn-primary" href="'.route('leave-requests.print',$data->id).'">
                            '.trans('student::local.print_endorsement').'
                        </a>';
                            return $btn;
                    })                     
                    ->addColumn('student_name',function($data){
                        return $this->getStudentName($data);
                    }) 
                    ->addColumn('student_number',function($data){
                        return $data->students->student_number;
                    })  
                    ->addColumn('grade',function($data){
                        return session('lang') == 'ar' ? $data->students->grade->ar_grade_name:$data->students->grade->en_grade_name;
                    })  
                    ->addColumn('division',function($data){
                        return session('lang') == 'ar' ? $data->students->division->ar_division_name:$data->students->division->en_division_name;
                    })                                                                                                   
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['student_number','check','student_name','grade','division','show','print'])
                    ->make(true);
        }
        return view('student::students-affairs.leave-requests.index',
        ['title'=>trans('student::local.leave_requests')]); 
    }
    private function getStudentName($data)
    {        
        return session('lang') == 'ar' ?
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->ar_student_name.' '. $data->students->father->ar_st_name .' '.$data->students->father->ar_nd_name .' '.$data->students->father->ar_rd_name .' '.$data->students->father->ar_th_name .'</a>':
        
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->en_student_name.' '.$data->students->father->en_st_name .' '.$data->students->father->en_nd_name .' '.$data->students->father->en_rd_name .' '.$data->students->father->en_th_name .'</a>';  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::has('statements')
        ->whereDoesntHave('leaveRequests')
        ->get();
        return view('student::students-affairs.leave-requests.create',
        ['title'=>trans('student::local.new_leave_request'),'students'=>$students]);
    }
    private function attributes()
    {
        return [
            'student_id',
            'reason',
            'notes',
            'parent_type',
            'endorsement'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        DB::transaction(function () {
            $endorsement = ReportContent::first()->endorsement;
            request()->user()->leaveRequests()->create(request()->only($this->attributes()) + 
            ['endorsement' => $endorsement]);          
        });
           
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('leave-requests.index');
    }

    public function show($id)
    {
        $leave = LeaveRequest::with('students')->findOrFail($id);
        return view('student::students-affairs.leave-requests.show',
        ['title'=>trans('student::local.new_leave_request'),'leave'=>$leave]);
    }
    public function update($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        DB::transaction(function () use ($id, $leave) { 
            if (request()->has('default')) {
                $reportContent = ReportContent::first();
                $reportContent->update(request()->only(['endorsement']));                
            }                
            $leave->update(request()->only($this->attributes()));
        });
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('leave-requests.show',$leave->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    LeaveRequest::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function  printLeaveRequest($id)
    {
        $leave = LeaveRequest::with('students')->findOrFail($id);
        $division_id = $leave->students->division_id;

        $leave = LeaveRequest::with('students')->findOrFail($id);
        $content =  $leave->endorsement;

        $student_name = session('lang') == 'ar' ? $leave->students->ar_student_name .' ' . $leave->students->father->ar_st_name
        .' ' . $leave->students->father->ar_nd_name.' ' . $leave->students->father->ar_rd_name
        : $leave->students->en_student_name .' ' . $leave->students->father->en_st_name
        .' ' . $leave->students->father->en_nd_name.' ' . $leave->students->father->en_rd_name ;

        $father_name  = session('lang') == 'ar' ? $leave->students->father->ar_st_name
        .' ' . $leave->students->father->ar_nd_name.' ' . $leave->students->father->ar_rd_name.' ' . $leave->students->father->ar_th_name: 
        $leave->students->father->en_st_name
        .' ' . $leave->students->father->en_nd_name.' ' . $leave->students->father->en_rd_name.' ' . $leave->students->father->en_th_name ;
        $father_national_id  = $leave->students->father->id_number ;
        $grade  = session('lang') == 'ar' ? $leave->students->grade->ar_grade_name: $leave->students->grade->en_grade_name ;

        $year = fullAcademicYear();
        $content = str_replace('student_name',$student_name ,$content);
        $content = str_replace('father_name',$father_name ,$content);
        $content = str_replace('father_national_id',$father_national_id ,$content);
        $content = str_replace('grade',$grade ,$content);
        $content = str_replace('year',$year ,$content);
      
        $data = [         
                'title'                         => 'Statistics Report',       
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

		$pdf = PDF::loadView('student::students-affairs.leave-requests.report', $data,[],$config);
		return $pdf->stream('Statistics');
    }

}
