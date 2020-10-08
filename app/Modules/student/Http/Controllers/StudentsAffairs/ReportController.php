<?php
namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;
use PDF;
use Student\Models\Settings\Classroom;
use Student\Models\Settings\Language;
use Student\Models\Settings\RegistrationStatus;
use Student\Models\Students\DailyRequest;
use Student\Models\Students\LeaveRequest;
use Student\Models\Students\ParentRequest;
use Student\Models\Students\Student;
use Student\Models\Students\Transfer;

class ReportController extends Controller
{
    public function statistics()
    {        
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.statistics_reports');
        return view('student::students-affairs.reports.statistics',
        compact('title','years','divisions'));
    }

    public function secondLangReportStatistics()
    {
        if (empty(request('division_id')) || empty(request('year_id'))) {
            toast(trans('student::local.no_division_selected'),'error');  
            return back();
        }

        $languages = Language::study()->sort()->get();        
        $languagesCount = Language::study()->count();        
        $grades = Grade::sort()->get();

        $students = [];

        foreach ($grades as $grade) {
            $where = [                                
                ['grade_id',$grade->id],
            ]; 

            foreach ($languages as $lang) {
                $students[] = [                    
                    'count' => Student::with('languages','statements','grade')
                                    ->whereHas('statements',function($q){
                                        $q->where('year_id',request('year_id'));
                                    })
                                    ->where($where)
                                    ->where('second_lang_id',$lang->id)
                                    ->whereIn('division_id',request('division_id'))
                                    ->count(),
                    'grade' => $grade->id
                ];
                
            }

          
        }        
        foreach ($languages as $lang) {
            $counting[] = [                    
                'count' => Student::with('languages','statements','grade')
                                ->whereHas('statements',function($q){
                                    $q->where('year_id',request('year_id'));
                                })                                    
                                ->whereIn('division_id',request('division_id'))
                                ->where('second_lang_id',$lang->id)
                                ->count(),
                'lang' => $lang->id
            ];
            
        }  
        
        $school_name = $this->schoolName();      

        $data = [         
            'title'                         => 'Second Language Report',       
            'counting'                      => $counting,                   
            'languages'                     => $languages,                   
            'languagesCount'                => $languagesCount,                   
            'grades'                        => $grades,                   
            'students'                      => $students,       
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

		$pdf = PDF::loadView('student::students-affairs.reports.statistics.second-lang', $data,[],$config);
		return $pdf->stream('Second Language Report');
    }

    public function regStatusReportStatistics()
    {
        if (empty(request('division_id')) || empty(request('year_id'))) {
            toast(trans('student::local.no_division_selected'),'error');  
            return back();
        }

        $regStatus = RegistrationStatus::sort()->get();        
        $regStatusCount = RegistrationStatus::count();        
        $grades = Grade::sort()->get();

        $students = [];

        foreach ($grades as $grade) {
            $where = [                                
                ['grade_id',$grade->id],
            ]; 

            foreach ($regStatus as $reg) {
                $students[] = [                    
                    'count' => Student::with('registration_status','grade')         
                                    ->where($where)
                                    ->where('registration_status_id',$reg->id)
                                    ->whereIn('division_id',request('division_id'))
                                    ->count(),
                    'grade' => $grade->id
                ];
                
            }

          
        }        
        foreach ($regStatus as $reg) {
            $counting[] = [                    
                'count' => Student::with('registration_status','grade')                                 
                                ->whereIn('division_id',request('division_id'))
                                ->where('registration_status_id',$reg->id)
                                ->count(),
                'regStatus' => $reg->id
            ];
            
        }  
                
        $school_name = $this->schoolName();
            
        $data = [         
            'title'                         => 'Registration Status Report',       
            'counting'                      => $counting,                   
            'regStatus'                     => $regStatus,                   
            'regStatusCount'                => $regStatusCount,                   
            'grades'                        => $grades,                   
            'students'                      => $students,       
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

		$pdf = PDF::loadView('student::students-affairs.reports.statistics.reg-status', $data,[],$config);
		return $pdf->stream('Registration Status Report');
    }  
    
    public function religionReportStatistics()
    {
        if (empty(request('division_id')) || empty(request('year_id'))) {
            toast(trans('student::local.no_division_selected'),'error');  
            return back();
        }

        $religions = [
                ['id' =>0 ,'religion'=>'muslim'],
                ['id' =>1 ,'religion'=>'non_muslim']            
            ];   

        $religions = collect($religions);
                 
        $religionCount = 2;        
        $grades = Grade::sort()->get();
       

        $students = [];

        foreach ($grades as $grade) {
            $where = [                                
                ['grade_id',$grade->id],
            ]; 

            foreach ($religions as $religion) {   
                
                $students[] = [                    
                    'count' => Student::with('registration_status','grade')         
                                    ->where($where)
                                    ->where('religion',$religion['religion'])
                                    ->whereIn('division_id',request('division_id'))
                                    ->count(),
                    'grade' => $grade->id
                ];
                
            }

          
        }        
        foreach ($religions as $religion) {
            $counting[] = [                    
                'count' => Student::with('registration_status','grade')                                 
                                ->whereIn('division_id',request('division_id'))
                                ->where('religion',$religion['religion'])
                                ->count(),
                'religion' => $religion['religion']
            ];
            
        }  
        // dd($counting);    
        $school_name = $this->schoolName();
            
        $data = [         
            'title'                         => 'Religion Report',       
            'counting'                      => $counting,                   
            'religions'                     => $religions,                   
            'religionCount'                 => $religionCount,                   
            'grades'                        => $grades,                   
            'students'                      => $students,       
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

		$pdf = PDF::loadView('student::students-affairs.reports.statistics.religion', $data,[],$config);
		return $pdf->stream('Religion Report');
    }

    private function schoolName()
    {        
        $divisions = request('division_id');
        $school_name = '';
        if (empty( $divisions)) {
            $divisions = Division::sort()->get();
            foreach ($divisions as $division) {
                $school_name .= session('lang') == 'ar' ?$division->ar_division_name . ' / ':$division->en_division_name . ' / ';
            }
        }else{
            if (count(request('division_id')) == 1) {
                $school_name = getSchoolName($divisions[0]);
             }else{
                 for ($i=0; $i < count(request('division_id')) ; $i++) { 
                     $school_name .= session('lang') == 'ar' ?Division::findOrFail($divisions[$i])->ar_division_name . ' / '
                     :Division::findOrFail($divisions[$i])->en_division_name . ' / ';
                 }
             }  
        }

         return $school_name;
    }

    public function studentData()
    {
        $grades = Grade::sort()->get();
        $languages = Language::study()->sort()->get();
        $years = Year::get();
        $divisions = Division::sort()->get();
        $title = trans('student::local.student_data_reports');
        return view('student::students-affairs.reports.students-data',
        compact('title','grades','years','divisions','languages'));
    }

    public function studentsContactData()
    {        
        if (empty(request('room_id')) || empty(request('year_id'))) {
            toast(trans('student::local.select_classroom_first'),'error');  
            return back();
        }

        $room = Classroom::findOrFail(request('room_id'));                    
        $classroom =  session('lang') =='ar'?$room->ar_name_classroom:$room->en_name_classroom;

        $students = Student::with('father','mother','rooms')
        ->join('rooms','rooms.student_id','=','students.id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')
        ->where('rooms.classroom_id',request('room_id'))
        ->where('rooms.year_id',request('year_id'))
        ->get();

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => 'Contacts data - ' . $classroom ,       
            'students'                      => $students,       
            'classroom'                     => $classroom,       
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.students-data.student-contact-data', $data,[],$config);
        return $pdf->stream('Contacts data - ' . $classroom);
    }

    public function studentsSecondLangData()
    {
        if (empty(request('room_id')) || empty(request('year_id'))) {
            toast(trans('student::local.select_classroom_first'),'error');  
            return back();
        }

        if (empty(request('lang_id')) || empty(request('year_id'))) {
            toast(trans('student::local.select_language_first'),'error');  
            return back();
        }

        $room = Classroom::findOrFail(request('room_id'));                    
        $classroom =  session('lang') =='ar'?$room->ar_name_classroom:$room->en_name_classroom;

        $lang = Language::findOrFail(request('lang_id'));                    
        $language =  session('lang') =='ar'?$lang->ar_name_lang:$lang->en_name_lang;

        $students = Student::with('father','mother','rooms')
        ->join('rooms','rooms.student_id','=','students.id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')
        ->where('rooms.classroom_id',request('room_id'))
        ->where('rooms.year_id',request('year_id'))
        ->where('second_lang_id',request('lang_id'))
        ->get();

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => $classroom . ' - ' . $language,       
            'students'                      => $students,       
            'classroom'                     => $classroom,       
            'language'                      => $language,       
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.students-data.student-second-lang', $data,[],$config);
        return $pdf->stream($classroom . ' - ' . $language);
    }

    public function studentsReligionData()
    {
        if (empty(request('room_id')) || empty(request('year_id'))) {
            toast(trans('student::local.select_classroom_first'),'error');  
            return back();
        }

        if (empty(request('lang_id')) || empty(request('year_id'))) {
            toast(trans('student::local.select_language_first'),'error');  
            return back();
        }

        $room = Classroom::findOrFail(request('room_id'));                    
        $classroom =  session('lang') =='ar'?$room->ar_name_classroom:$room->en_name_classroom;

        $religion ='';
        switch (request('religion_id')) {
            case 'muslim':
                $religion = trans('student::local.muslim');
                break;
            
            default:
                $religion = trans('student::local.non_muslim');
                break;
        }

        $students = Student::with('father','mother','rooms')
        ->join('rooms','rooms.student_id','=','students.id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')
        ->where('rooms.classroom_id',request('room_id'))
        ->where('religion',request('religion_id'))
        ->where('rooms.year_id',request('year_id'))
        ->get();

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => $classroom . ' - ' . $religion,       
            'students'                      => $students,       
            'classroom'                     => $classroom,       
            'religion'                      => $religion,       
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.students-data.student-religion', $data,[],$config);
        return $pdf->stream($classroom . ' - ' . $religion);
    }  
    
    public function period()
    {
        $grades = Grade::sort()->get();        
        $divisions = Division::sort()->get();
        $title = trans('student::local.period_reports');
        return view('student::students-affairs.reports.period',
        compact('title','grades','divisions'));
    }   
    
    public function permissions()
    {           
        if (empty(request('from_date')) || empty(request('to_date'))) {
            toast(trans('student::local.no_period_selected'),'error');  
            return back();
        }
        $all_divisions = Division::select('id')->get()->toArray();        
        $division = request()->has('division_id')? request('division_id'):$all_divisions;

        $daily_requests = DailyRequest::with('students')
        ->whereDate('daily_requests.created_at','>=',request('from_date'))
        ->whereDate('daily_requests.created_at','<=',request('to_date'))
        ->whereHas('students',function($q) use ($division){
            $q->whereIn('division_id',$division);
        })        
        ->join('rooms','rooms.student_id','=','daily_requests.student_id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')  
        ->select('daily_requests.*','classrooms.ar_name_classroom','en_name_classroom')        
        ->orderBy('daily_requests.id','asc')
        ->orderBy('classrooms.sort','asc')
        ->get();
        

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => 'Daily Requests',       
            'daily_requests'                => $daily_requests,            
            'from_date'                     => request('from_date'),            
            'to_date'                       => request('to_date'),            
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.period.daily-permissions', $data,[],$config);
        return $pdf->stream('Daily Requests');        
    }

    public function parentRequests()
    {
        if (empty(request('from_date')) || empty(request('to_date'))) {
            toast(trans('student::local.no_period_selected'),'error');  
            return back();
        }
        $all_divisions = Division::select('id')->get()->toArray();        
        $division = request()->has('division_id')? request('division_id'):$all_divisions;

        $parent_requests = ParentRequest::with('students')
        ->whereDate('parent_requests.date_request','>=',request('from_date'))
        ->whereDate('parent_requests.date_request','<=',request('to_date'))
        ->whereHas('students',function($q) use ($division){
            $q->whereIn('division_id',$division);
        })        
        ->join('rooms','rooms.student_id','=','parent_requests.student_id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')  
        ->select('parent_requests.*','classrooms.ar_name_classroom','en_name_classroom')        
        ->orderBy('parent_requests.id','asc')
        ->orderBy('classrooms.sort','asc')
        ->get();
        

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => 'Parent Requests',       
            'parent_requests'                => $parent_requests,            
            'from_date'                     => request('from_date'),            
            'to_date'                       => request('to_date'),            
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.period.parent-request', $data,[],$config);
        return $pdf->stream('Parent Requests');  
    }

    public function leaveRequests()
    {
        if (empty(request('from_date')) || empty(request('to_date'))) {
            toast(trans('student::local.no_period_selected'),'error');  
            return back();
        }
        $all_divisions = Division::select('id')->get()->toArray();        
        $division = request()->has('division_id')? request('division_id'):$all_divisions;

        $leave_requests = LeaveRequest::with('students')
        ->whereDate('leave_requests.created_at','>=',request('from_date'))
        ->whereDate('leave_requests.created_at','<=',request('to_date'))
        ->whereHas('students',function($q) use ($division){
            $q->whereIn('division_id',$division);
        })        
        ->join('rooms','rooms.student_id','=','leave_requests.student_id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')  
        ->select('leave_requests.*','classrooms.ar_name_classroom','en_name_classroom')        
        ->orderBy('leave_requests.id','asc')
        ->orderBy('classrooms.sort','asc')
        ->get();
        

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => 'Leave Requests',       
            'leave_requests'                => $leave_requests,            
            'from_date'                     => request('from_date'),            
            'to_date'                       => request('to_date'),            
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.period.leave-request', $data,[],$config);
        return $pdf->stream('Leave Requests'); 
    }

    public function transfers()
    {
        if (empty(request('from_date')) || empty(request('to_date'))) {
            toast(trans('student::local.no_period_selected'),'error');  
            return back();
        }
        $all_divisions = Division::select('id')->get()->toArray();        
        $division = request()->has('division_id')? request('division_id'):$all_divisions;

        $transfers = Transfer::with('students','schools')
        ->whereDate('transfers.created_at','>=',request('from_date'))
        ->whereDate('transfers.created_at','<=',request('to_date'))
        ->whereHas('students',function($q) use ($division){
            $q->whereIn('division_id',$division);
        })        
        ->join('rooms','rooms.student_id','=','transfers.student_id')
        ->join('classrooms','rooms.classroom_id','=','classrooms.id')  
        ->select('transfers.*','classrooms.ar_name_classroom','en_name_classroom')        
        ->orderBy('transfers.id','asc')
        ->orderBy('classrooms.sort','asc')
        ->get();
        

        $school_name = $this->schoolName();

        $data = [         
            'title'                         => 'Transfers',       
            'transfers'                     => $transfers,            
            'from_date'                     => request('from_date'),            
            'to_date'                       => request('to_date'),            
            'logo'                          => logo(),            
            'school_name'                   => $school_name,               
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

        $pdf = PDF::loadView('student::students-affairs.reports.period.transfers', $data,[],$config);
        return $pdf->stream('Transfers'); 
    }
    
    
}
