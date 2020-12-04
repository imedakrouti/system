<?php

namespace Staff\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Post;
use Learning\Models\Learning\ZoomSchedule;
use Staff\Models\Employees\Announcement;
use Student\Models\Students\Student;
use Carbon\Carbon;
use Student\Models\Settings\Classroom;

class StaffDashboardController extends Controller
{
    public function dashboard()
    {
        $title = trans('admin.hr');

        return view('staff::dashboard.staff',      
        compact('title'));
    }

    public function teacherDashboard()
    {
        // total students
        $students = $this->totalStudents();
        // total classrooms
        $classrooms = employeeClassrooms()->count();
        // total posts
        $posts = Post::where('admin_id',authInfo()->id)->count();
        // total lessons
        $lessons = Lesson::where('admin_id',authInfo()->id)->count();
        // administrative messages
        $announcements = $this->announcements();        
        
        return view('staff::dashboard.teacher',
        compact('announcements','students','classrooms','posts','lessons'));
    }

    private function totalStudents()
    {
        $subjects = [];
        foreach (employeeSubjects() as $subject) {
            $subjects[] = $subject->id;
        }
        // total students
        return Student::with('subjects')
        ->whereHas('subjects',function($q) use($subjects){
            $q->whereIn('subject_id',$subjects);
        })->count();
        
    }

    private function announcements()
    {
        return Announcement::where('domain_role','teacher')
        ->where('start_at','<=',\Carbon\Carbon::today())
        ->where('end_at','>=',\Carbon\Carbon::today())
        ->orderBy('id','desc')->limit(5)->get();
    } 

    public function nextVirtualClassroom()
    {
        if (request()->ajax()) {
            $classrooms = [];
            foreach (employeeClassrooms() as $classroom) {
                $classrooms[] = $classroom->id;
            }
                        
            // dd($this->getRemainingTime($classrooms));
            $data['time'] = $this->getRemainingTime($classrooms) *60*1000; 

            $virtual_classroom = $this->virtualClassroom($classrooms);

            $data['classroom'] = $this->classroomName($virtual_classroom->classroom_id);


            // Classroom schedules
            $n=1;
            $schedule ='';    
            foreach ($this->classrooms($classrooms) as $class)  {
            $schedule .= '<tr>
                        <td>
                            '. $this->classroomName($class->classroom->id).'
                        </td>
                        <td>
                            <span class="blue">'.\Carbon\Carbon::parse( $class->start_date)->format('M d Y').'<br>
                                '.\Carbon\Carbon::parse( $class->start_time)->format('h:i a').'
                            </span>
                        </td>
                        <td>'.startVirtualClass($class->start_date, $class->start_time).'</td>
                    </tr>';
                    $n++;
            } 
            $data['schedule'] = $schedule;
            
            return json_encode($data);
        }
    }

    private function virtualClassroom($employeeClassrooms)
    {
        return ZoomSchedule::with('classroom')
        ->whereHas('classroom',function($q) use($employeeClassrooms){
            $q->whereIn('classroom_id',$employeeClassrooms);
        })
        ->where('start_date','>=',date_format(\Carbon\Carbon::now(),"Y-m-d"))
        ->where('start_time','>=',date_format(\Carbon\Carbon::now(),"H:i"))
        ->orderBy('start_time','asc')->first();
    }


    private function getRemainingTime($employeeClassrooms)
    {
        $virtual_class = $this->virtualClassroom($employeeClassrooms);

         return Carbon::parse(date_format(\Carbon\Carbon::now(),"H:i"))
        ->diffInMinutes(Carbon::parse($virtual_class->start_time));
    }

    private function classroomName($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        return session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom;
    }

    private function classrooms($employeeClassrooms)
    {
        return  ZoomSchedule::with('classroom')
        ->whereHas('classroom',function($q) use($employeeClassrooms){
            $q->whereIn('classroom_id',$employeeClassrooms);
        })
        ->where('start_date',date_format(\Carbon\Carbon::now(),"Y-m-d"))
        ->orderBy('start_time','asc')->get();
    }

}
