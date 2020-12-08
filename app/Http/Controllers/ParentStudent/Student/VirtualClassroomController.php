<?php
namespace App\Http\Controllers\ParentStudent\Student;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\ZoomSchedule;
use Student\Models\Settings\Classroom;
use Learning\Models\Learning\ZoomAccount;
use Carbon\Carbon;

class VirtualClassroomController extends Controller
{
    public function viewSchedule()
    {
        $title = trans('student.view_schedule');
        $classroom = Classroom::findOrFail(classroom_id());
        $classroom_name = session('lang') == 'ar'?$classroom->ar_name_classroom : $classroom->en_name_classroom;
        if (request()->ajax()) {
            $subjects = [];
            foreach (studentSubjects() as $subject) {
                $subjects[] = $subject->id;
            }
            $data = [];
            $schedule = ZoomSchedule::with('subject','classroom')
            ->whereHas('subject',function($q) use ($subjects){
                $q->whereIn('subject_id',$subjects);
            })
            ->whereHas('classroom',function($q){
                $q->where('classroom_id',classroom_id());
            })            
            ->get();
            
            foreach ($schedule as  $day) {
        
                $date = Carbon::parse($day->start_date)->format('Y-m-d');
                $time = Carbon::parse($day->start_time)->format('H:i:s');
                $startDateTime = $date.'T'.$time.'Z';
     
                $data[] = array(
                    'id'        => $day->id,
                    'title'     => session('lang') == 'ar' ? $day->subject->ar_shortcut: $day->subject->en_shortcut,
                    'start'     => $startDateTime,
                    'end'       => $startDateTime,
                    'color'     => $this->color($day->start_date,$day->start_time)
                   );
            }
            return json_encode($data);
        }
        return view('layouts.front-end.student.virtual-classrooms.view-schedule',
        compact('title','classroom_name'));
    }

    private function color($date, $time)
    {
        $time = new Carbon( $time);
                
        $color = '';
        // today
        // hidden before date & time
        if($date >= date_format(Carbon::now(),"Y-m-d")){
                $color = 'blue';
        }    

        // today
        if ($date <= date_format(Carbon::now(),"Y-m-d") && 
            date_format($time->subMinutes(1),"H:i") < date_format(Carbon::now(),"H:i")) {
            $color = 'green';
        }
        if($date < date_format(Carbon::now(),"Y-m-d")){
            $color = 'red';
        }
                    
        // hidden after date & time
        
        $time = $time->addMinutes(45);
        
        if($date == date_format(Carbon::now(),"Y-m-d") && 
            date_format($time,"H:i") < date_format(Carbon::now(),"H:i")){
            $color = 'red';
        } 

        return $color;        
    }  

    public function joinClassroom()
    {
        $subjects = [];
        foreach (studentSubjects() as $subject) {
            $subjects[] = $subject->id;
        }
        $title = trans('student.join_class');
        $data = ZoomSchedule::with('subject','classroom','admin')->orderBy('start_date','desc')
        ->whereHas('subject',function($q) use($subjects){
            $q->whereIn('subject_id',$subjects);
        })
        ->whereHas('classroom',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->get();
        if (request()->ajax()) {
            return $this->joinClassroomDataTable($data);
        }
        return view('layouts.front-end.student.virtual-classrooms.join-classroom',
        compact('title'));
    }

    private function joinClassroomDataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('start_class', function($data){
                $time = new Carbon( $data->start_time);
                $btn = '';

                // hidden before date & time
                if($data->start_date >= date_format(Carbon::now(),"Y-m-d")){
                        $btn = '<span class="blue"><strong>'.trans('learning::local.not_yet').'</strong></span>';
                }    

                // today
                if ($data->start_date <= date_format(Carbon::now(),"Y-m-d") && 
                    date_format($time->subMinutes(1),"H:i") < date_format(Carbon::now(),"H:i")) {
                    $employees = $data->subject->employees;                    
                    $btn = '<a target="_blank" href="'.route('student.live-classroom',['employee_id'=>$this->employeeID($employees),
                    'zoom_schedule_id'=>$data->id]).'" 
                                class="btn btn-purple btn-sm" ">'.trans('student.join').' 
                            </a>';
                }
                if($data->start_date < date_format(Carbon::now(),"Y-m-d")){
                    $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
                }
                            
                // hidden after date & time
                
                $time = $time->addMinutes(45);
                
                if($data->start_date == date_format(Carbon::now(),"Y-m-d") && 
                    date_format($time,"H:i") < date_format(Carbon::now(),"H:i")){
                    $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
                } 
                
                return $btn;
            }) 
            ->addColumn('start_date',function($data){
                return '<span class="blue">'.Carbon::parse( $data->start_date)->format('M d Y').'<br>
                '.Carbon::parse( $data->start_time)->format('h:i a').'
                </span>';
            })  
            ->addColumn('subject',function($data){
                return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
            })   
            ->addColumn('pass_code',function($data){
                $time = new Carbon( $data->start_time);
                $passcode = '';

                // hidden before date & time
                if($data->start_date >= date_format(Carbon::now(),"Y-m-d")){
                    $passcode = '*****';
                }    

                // today
                if ($data->start_date <= date_format(Carbon::now(),"Y-m-d") && 
                    date_format($time->subMinutes(1),"H:i") < date_format(Carbon::now(),"H:i")) {
                    $employees = $data->subject->employees;                    
                    $passcode = $this->passcode($employees);
                }

                if($data->start_date < date_format(Carbon::now(),"Y-m-d")){
                    $passcode = '*****';
                }
                            
                // hidden after date & time
                
                $time = $time->addMinutes(45);
                
                if($data->start_date == date_format(Carbon::now(),"Y-m-d") && 
                    date_format($time,"H:i") < date_format(Carbon::now(),"H:i")){
                    $passcode = '*****';
                } 
                
                return $passcode;

            })                                  
            ->rawColumns(['start_date','start_class','subject','pass_code'])
            ->make(true);
    }
    
    private function employeeID($employees)
    {
        $employee_id = '';
        foreach ($employees as $employee) {
            $employee_id = $employee->id;
        }
        return $employee_id;
    }

    private function passcode($employees)
    {
        $employee_id = '';
        foreach ($employees as $employee) {
            $employee_id = $employee->id;
        }
        return  ZoomAccount::where('employee_id',$employee_id)->first()->pass_code;        
    }
    
    public function liveClassroom($employee_id, $zoom_schedule_id)
    {
        $title = "";
        $meeting_id = ZoomAccount::where('employee_id',$employee_id)->first()->meeting_id;
        
        // attempt to join class
        request()->user()->zoomAttendances()->create(['zoom_schedule_id'=>$zoom_schedule_id]);

        return view('layouts.front-end.student.virtual-classrooms.live-classroom',
        compact('title','meeting_id'));
    }    
}
