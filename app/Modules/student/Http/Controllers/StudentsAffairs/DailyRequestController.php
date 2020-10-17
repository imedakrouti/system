<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use PDF;
use Student\Models\Students\Commissioner;
use Student\Models\Students\DailyRequest;
use Student\Models\Students\ReportContent;
use Carbon;
use DateTime;
use Student\Models\Students\Student;

class DailyRequestController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = DailyRequest::with('students','admin')
            ->orderBy('id','desc')->get();

            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('print', function($data){
                        $btn = '<a class="btn btn-primary btn-sm" target="_blank" href="'.route('daily-requests.print',$data->id).'">
                            '.trans('student::local.print').'
                        </a>';
                            return $btn;
                    })                    
                    ->addColumn('student_number',function($data){
                        return $data->students->student_number;
                    })
                    ->addColumn('student_name',function($data){
                        return $this->getStudentName($data);
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
                    ->rawColumns(['check','student_number','student_name','print','grade','division'])
                    ->make(true);
        }
        return view('student::students-affairs.daily-requests.index',
        ['title'=>trans('student::local.daily_requests')]);  
    }
    private function getStudentName($data)
    {        
        return session('lang') == 'ar' ?
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->ar_student_name.' '. $data->students->father->ar_st_name .' '.$data->students->father->ar_nd_name .' '.$data->students->father->ar_rd_name .' '.$data->students->father->ar_th_name .'</a>':
        
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->en_student_name.' '.$data->students->father->en_st_name .' '.$data->students->father->en_nd_name .' '.$data->students->father->en_rd_name .' '.$data->students->father->en_th_name .'</a>';  
    }
    public function create()
    {
        $commissioners = Commissioner::has('students')->get();
        $students = Student::with('father')->whereHas('statements')
        ->orderBy('ar_student_name')->get();
        $title = trans('student::local.add_daily_request');

        return view('student::students-affairs.daily-requests.create',
        compact('students','title','commissioners'));
    }
    private function attributes()
    {
        return  [            
            'leave_time',
            'recipient_name'            
        ];
    }    
    public function store()
    {
        if (request()->has('student_id')) {
            foreach (request('student_id') as $student_id) {
                request()->user()->dailyRequests()->create(request()->only($this->attributes())+
                [ 'student_id' => $student_id]);                        
            }
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('daily-requests.index');
    }
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    DailyRequest::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function print($id)
    {
        $dailyRequest = DailyRequest::with('students')->findOrFail($id);                
        $division_id = $dailyRequest->students->division_id;
        $content = ReportContent::first()->daily_request;

        $student_name = session('lang') == 'ar' ? $dailyRequest->students->ar_student_name .' ' . $dailyRequest->students->father->ar_st_name
        .' ' . $dailyRequest->students->father->ar_nd_name.' ' . $dailyRequest->students->father->ar_rd_name
        : $dailyRequest->students->en_student_name .' ' . $dailyRequest->students->father->en_st_name
        .' ' . $dailyRequest->students->father->en_nd_name.' ' . $dailyRequest->students->father->en_rd_name ;

        $father_name  = session('lang') == 'ar' ? $dailyRequest->students->father->ar_st_name
        .' ' . $dailyRequest->students->father->ar_nd_name.' ' . $dailyRequest->students->father->ar_rd_name.' ' . $dailyRequest->students->father->ar_th_name: 
        $dailyRequest->students->father->en_st_name
        .' ' . $dailyRequest->students->father->en_nd_name.' ' . $dailyRequest->students->father->en_rd_name.' ' . $dailyRequest->students->father->en_th_name ;
        $father_national_id  = $dailyRequest->students->father->id_number ;
        $grade  = session('lang') == 'ar' ? $dailyRequest->students->grade->ar_grade_name: $dailyRequest->students->grade->en_grade_name ;
        
        $content = str_replace('student_name',$student_name ,$content);
        $content = str_replace('father_name',$father_name ,$content);
        $content = str_replace('father_national_id',$father_national_id ,$content);
        $content = str_replace('grade',$grade ,$content);        
        $content = str_replace('leave_time',$dailyRequest->leave_time ,$content);        
        $content = str_replace('recipient_name',$dailyRequest->recipient_name ,$content);        
        $date = Carbon\Carbon::today();
        $content = str_replace('date', date_format($date,"Y/m/d"),$content);        
        
        
        $data = [         
            'title'                         => 'Daily Request Report',       
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

        $pdf = PDF::loadView('student::students-affairs.daily-requests.reports.student-leave-request', $data,[],$config);
        return $pdf->stream('Daily Request Report');
    }
    public function student($id)
    {
        $student = Student::findOrFail($id);
        $dailyRequests = DailyRequest::with('students')
        ->whereHas('students',function($q) use ($id){
            $q->where('students.id',$id);
        })
        ->get();        
        $title = trans('student::local.daily_request_student');
        return view('student::students-affairs.daily-requests.student-profile.student',
        compact('title','dailyRequests','student'));
    }      
}
