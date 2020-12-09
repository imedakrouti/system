<?php

namespace Learning\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Post;
use Learning\Models\Learning\ZoomSchedule;
use Student\Models\Settings\Classroom;
use Student\Models\Students\Student;
use \Carbon\Carbon;
use Staff\Models\Employees\Employee;

class LearningDashboardController extends Controller
{
    public function dashboard()
    {
        $title = trans('admin.e_learning');
        $students  = Student::with('statements')->count();
        $teachers = Admin::where('domain_role','teacher')->orWhere('domain_role','super visor')->count();        
        $posts = Post::count();
        $lessons = Lesson::count();

        return view('learning::dashboard.learning',      
        compact('title','students','teachers','posts','lessons'));
    }

    public function virtualClassroomsSchedule()
    {
        if (request()->ajax()) {
            $classrooms = [];
            $classes = Classroom::where('year_id',currentYear())->get();
            foreach ($classes as $classroom) {
                $classrooms[] = $classroom->id;
            }

            // Classroom schedules
            $schedule = '';  
            if (count($this->classrooms($classrooms)) != 0) {
                foreach ($this->classrooms($classrooms) as $class)  {                   
                    $image = '';
                    foreach ($class->subject->employees as $employee) {
                        $image = $this->employeeImage($employee->id);
                    }

                    $teacher_name = '';
                    foreach ($class->subject->employees as $employee) {
                        $teacher_name = $this->getFullEmployeeName($employee->id);
                    }

                    $subject = session('lang') == 'ar' ? $class->subject->ar_name:$class->subject->en_name;

                    $schedule .= '<tr>
                                <td>
                                    '.$image.'
                                </td>
                                <td>
                                    '.$teacher_name.'
                                </td>
                                <td>
                                    '. $this->classroomName($class->classroom->id).'
                                </td>
                                <td>
                                    '.$subject.'
                                </td>
                                <td>
                                    <span>'.Carbon::parse( $class->start_time)->format('h:i a').'
                                    </span>
                                </td>
                                <td>'.startVirtualClass($class->start_date, $class->start_time,$class->id).'</td>
                            </tr>';
                }                 
            } else{
                $schedule  = '<tr><td colspan="3">'.trans('learning::local.no_virtual_classes').'</td></tr>';
            }
            $data['schedule'] = $schedule;
            
            return json_encode($data);
        }
    }


    private function classrooms($classrooms)
    {
        return  ZoomSchedule::with('classroom')
        ->whereHas('classroom',function($q) use($classrooms){
            $q->whereIn('classroom_id',$classrooms);
        })
        ->where('start_date',date_format(Carbon::now(),"Y-m-d"))
        ->orderBy('start_time','asc')
        ->limit(5)
        ->get();
    }

    private function classroomName($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        return session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom;
    }

    private function getFullEmployeeName($employee_id)
    {
        $data = Employee::findOrFail($employee_id);
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->ar_st_name . ' ' . $data->ar_nd_name.
            ' ' . $data->ar_rd_name.' ' . $data->ar_th_name.'</a>';
        }else{
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->en_st_name . ' ' . $data->en_nd_name.
            ' ' . $data->th_rd_name.' ' . $data->th_th_name.'</a>';
        }
        return $employee_name;
    }

    private function employeeImage($employee_id)
    {
        $data = Employee::findOrFail($employee_id);
        $image_path = $data->gender == trans('staff::local.male') ? 'images/website/male.png' : 'images/website/female.png';     
        return !empty($data->employee_image)?
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/employeesImages/'.$data->employee_image).'" />
            </a>':
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset($image_path).'" />
            </a>';
    }

    public function virtualClassroomsPage()
    {
        $title = trans('staff::local.today_virtual_classes');
        return view('learning::dashboard.view-virtual-classrooms',
        compact('title'));
    }

    public function viewVirtualClassrooms()
    {
        if (request()->ajax()) {
            $classrooms = [];
            $classes = Classroom::where('year_id',currentYear())->get();
            foreach ($classes as $classroom) {
                $classrooms[] = $classroom->id;
            }

            // Classroom schedules
            $schedule = '';  
            if (count($this->viewAllClassrooms($classrooms)) != 0) {
                foreach ($this->viewAllClassrooms($classrooms) as $class)  {                   
                    $image = '';
                    foreach ($class->subject->employees as $employee) {
                        $image = $this->employeeImage($employee->id);
                    }

                    $teacher_name = '';
                    foreach ($class->subject->employees as $employee) {
                        $teacher_name = $this->getFullEmployeeName($employee->id);
                    }

                    $subject = session('lang') == 'ar' ? $class->subject->ar_name:$class->subject->en_name;

                    $schedule .= '<tr>
                                <td>
                                    '.$image.'
                                </td>
                                <td>
                                    '.$teacher_name.'
                                </td>
                                <td>
                                    '. $this->classroomName($class->classroom->id).'
                                </td>
                                <td>
                                    '.$subject.'
                                </td>
                                <td>
                                    <span>'.Carbon::parse( $class->start_time)->format('h:i a').'
                                    </span>
                                </td>
                                <td>'.startVirtualClass($class->start_date, $class->start_time,$class->id).'</td>
                            </tr>';
                }                 
            } else{
                $schedule  = '<tr><td colspan="3">'.trans('learning::local.no_virtual_classes').'</td></tr>';
            }
            $data['schedule'] = $schedule;
            
            return json_encode($data);
        }
    }

    private function viewAllClassrooms($classrooms)
    {
        return  ZoomSchedule::with('classroom')
        ->whereHas('classroom',function($q) use($classrooms){
            $q->whereIn('classroom_id',$classrooms);
        })
        ->where('start_date',date_format(Carbon::now(),"Y-m-d"))
        ->orderBy('start_time','asc')        
        ->get();
    }

    public function recentLessons()
    {
        if (request()->ajax()) {
            $lessons = Lesson::with('subject','admin')->limit(5)->orderBy('created_at','desc')->get();
            $output = '';
            foreach ($lessons as $lesson) {
                $created_at = ' | <strong>'.trans('learning::local.since').'</strong> ' . $lesson->created_at->diffForHumans();
                $name = $this->getFullEmployeeName($lesson->admin->employeeUser->id);

                $create_by = '<br><span class="small"><strong>'.trans('learning::local.created_by').'</strong> ' . $name.$created_at.'</span>';
                $subject = session('lang') == 'ar' ? $lesson->subject->ar_name:$lesson->subject->en_name;
                $output .= '<tr>
                                <td>'.$lesson->lesson_title.$create_by.'</td>
                                <td>'.$subject.'</td>
                            </tr>';
            }
            return json_encode($output);
        }
    }

}
