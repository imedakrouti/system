<?php


namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;

use Student\Models\Students\ParentRequest;
use PDF;
use Carbon;
use DateTime;
use Student\Models\Students\ReportContent;
use Student\Models\Students\Student;

class ParentRequestController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = ParentRequest::with('students')->orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                        $btn = '<a class="btn btn-warning btn-sm" href="'.route('parent-requests.edit',$data->id).'">
                            <i class=" la la-edit"></i>
                        </a>';
                            return $btn;
                    })                    
                    ->addColumn('print', function($data){
                        $btn = '<a class="btn btn-primary btn-sm" target="_blank" href="'.route('parent-requests.print',$data->id).'">
                            '.trans('student::local.print').'
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
                    ->rawColumns(['student_number','check','student_name','grade','division','print','action'])
                    ->make(true);
        }
        return view('student::students-affairs.parent-requests.index',
        ['title'=>trans('student::local.parent_requests')]); 
    }
    private function getStudentName($data)
    {        
        return session('lang') == 'ar' ?
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->ar_student_name.' '. $data->students->father->ar_st_name .' '.$data->students->father->ar_nd_name .' '.$data->students->father->ar_rd_name .' '.$data->students->father->ar_th_name .'</a>':
        
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->en_student_name.' '.$data->students->father->en_st_name .' '.$data->students->father->en_nd_name .' '.$data->students->father->en_rd_name .' '.$data->students->father->en_th_name .'</a>';  
    }
    public function create()
    {
        $students = Student::has('statements')->orderBy('ar_student_name')        
        ->get();
        return view('student::students-affairs.parent-requests.create',
        ['title'=>trans('student::local.new_parent_request'),'students'=>$students]);
    }
    private function attributes()
    {
        return [            
            'date_request',
            'time_request' ,
            'notes'           
        ];
    }
    public function store()
    {      
        if (request()->has('student_id')) {
            foreach (request('student_id') as $student_id) {
                request()->user()->parentRequests()->create(request()->only($this->attributes())+
                ['student_id' => $student_id]);                          
            }
        }  
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('parent-requests.index');
    }
    public function edit($id)
    {
        $parentRequest = ParentRequest::findOrFail($id);
        $students = Student::has('statements')->orderBy('ar_student_name')        
        ->get();
        $title = trans('student::local.edit_parent_request');
        return view('student::students-affairs.parent-requests.edit',
       compact('parentRequest','students','title'));
    }
    public function update($id)
    {
        $parentRequest = ParentRequest::findOrFail($id);
        $parentRequest->update(request()->only($this->attributes())+
        [ 'student_id' => request('student_id')]);   
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('parent-requests.index');
    }
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    ParentRequest::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function  printLeaveRequest($id)
    {
        $parentRequest = ParentRequest::with('students')->findOrFail($id);
        $division_id = $parentRequest->students->division_id;
                        
        $content = ReportContent::first()->parent_request;

        $student_name = session('lang') == 'ar' ? $parentRequest->students->ar_student_name .' ' . $parentRequest->students->father->ar_st_name
        .' ' . $parentRequest->students->father->ar_nd_name.' ' . $parentRequest->students->father->ar_rd_name
        : $parentRequest->students->en_student_name .' ' . $parentRequest->students->father->en_st_name
        .' ' . $parentRequest->students->father->en_nd_name.' ' . $parentRequest->students->father->en_rd_name ;

        $father_name  = session('lang') == 'ar' ? $parentRequest->students->father->ar_st_name
        .' ' . $parentRequest->students->father->ar_nd_name.' ' . $parentRequest->students->father->ar_rd_name.' ' . $parentRequest->students->father->ar_th_name: 
        $parentRequest->students->father->en_st_name
        .' ' . $parentRequest->students->father->en_nd_name.' ' . $parentRequest->students->father->en_rd_name.' ' . $parentRequest->students->father->en_th_name ;
        $father_national_id  = $parentRequest->students->father->id_number ;
        $grade  = session('lang') == 'ar' ? $parentRequest->students->grade->ar_grade_name: $parentRequest->students->grade->en_grade_name ;

        $content = str_replace('student_name',$student_name ,$content);
        $content = str_replace('father_name',$father_name ,$content);
        $content = str_replace('father_national_id',$father_national_id ,$content);
        $content = str_replace('grade',$grade ,$content);
        
        $year = fullAcademicYear();
        $content = str_replace('year',$year ,$content);
        
        $date_request = DateTime::createFromFormat("Y-m-d",$parentRequest->date_request);
        $content = str_replace('date_request',$date_request->format('Y/m/d') ,$content);

        $content = str_replace('notes',$parentRequest->notes ,$content);
        $content = str_replace('time_request',$parentRequest->time_request ,$content);

        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
      
        $data = [         
                'title'                         => 'Leave Request Report Report',       
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

		$pdf = PDF::loadView('student::students-affairs.parent-requests.reports.student-parent-request', $data,[],$config);
		return $pdf->stream('Leave Request Report');
    }
    public function student($id)
    {
        $student = Student::findOrFail($id);
        $parentRequests = ParentRequest::with('students')
        ->whereHas('students',function($q) use ($id){
            $q->where('students.id',$id);
        })
        ->get();        
        $title = trans('student::local.parent_request_student');
        return view('student::students-affairs.parent-requests.student-profile.student',
        compact('title','parentRequests','student'));
    } 
}
