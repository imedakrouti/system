<?php

namespace Staff\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Post;
use Learning\Models\Learning\ZoomSchedule;
use Staff\Models\Employees\Announcement;
use Student\Models\Students\Student;
use Carbon\Carbon;
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

        // today virtual classes
        $classes = $this->classes();

        $time_remaining = 10000;
        
        return view('staff::dashboard.teacher',
        compact('announcements','students','classrooms','posts','lessons','classes','time_remaining'));
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

    private function classes()
    {
        $classrooms = [];
        foreach (employeeClassrooms() as $classroom) {
            $classrooms[] = $classroom->id;
        }
        return ZoomSchedule::with('classroom')
        ->whereHas('classroom',function($q) use($classrooms){
            $q->whereIn('classroom_id',$classrooms);
        })
        ->where('start_date',date_format(\Carbon\Carbon::now(),"Y-m-d"))
        ->orderBy('start_date','desc')->get();
    }

}
