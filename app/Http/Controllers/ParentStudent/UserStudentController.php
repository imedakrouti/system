<?php

namespace App\Http\Controllers\ParentStudent;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Answer;
use Learning\Models\Learning\Comment;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Playlist;
use Learning\Models\Learning\Post;
use Learning\Models\Learning\Question;
use Learning\Models\Learning\UserAnswer;
use Staff\Models\Employees\Employee;
use Student\Models\Settings\Classroom;
use Learning\Models\Learning\UserExam;
use Learning\Models\Learning\ZoomSchedule;
use DB;
use Carbon\Carbon;
use Learning\Models\Learning\DeliverHomework;
use Learning\Models\Learning\Homework;
use Learning\Models\Learning\LessonUser;
use Learning\Models\Learning\ZoomAccount;

class UserStudentController extends Controller
{
    private $file_name;

    public function dashboard()
    {                
        $exams = Exam::with('classrooms','subjects')->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->where('start_date','>',date_format(\Carbon\Carbon::now(),"Y-m-d"))
        ->orderBy('start_date','asc')
        ->limit(6)
        ->get(); 

        $classroom = Classroom::findOrFail(classroom_id());

        $posts = Post::with('admin')->where('classroom_id',classroom_id())->orderBy('created_at','desc')->limit(30)->get();
        $title = trans('learning::local.posts');
        return view('layouts.front-end.student.posts',
        compact('title','posts','exams','classroom'));        
    }

    public function comments()
    {
        if (request()->ajax()) {
            $comments = Comment::where('post_id',request('id'))
            ->leftJoin('admins','comments.admin_id','=','admins.id')
            ->leftJoin('users','comments.user_id','=','users.id')
            ->select('comments.*','admins.name','admins.ar_name','users.name as en_student_name','users.ar_name as ar_student_name')
            ->get();
            
            $comment_count = Comment::with('user')->where('post_id',request('id'))->count();
            return view('layouts.front-end.student.includes._comments',
            compact('comments','comment_count'));
        }
    }

    private function attributes()
    {
        return [        
            'comment_text',                                   
            'post_id',                                   
        ];
    }

    public function storeComment()
    {        
        if (request()->ajax()) {        
            request()->user()->comments()->create(request()->only($this->attributes()));
        }
        return response(['status'=>true]);
    }

    public function viewLesson($lesson_id, $playlist_id)
    {
        $lessons = Lesson::where('playlist_id',$playlist_id)->sort()->get();        
        $lesson = Lesson::with('divisions','grades','years','files','playlist','admin')->where('id',$lesson_id)->first();          
        $title = $lesson->lesson_title;
        // set view count
        $this->lessonViews($lesson, $lesson->views);
        return view('layouts.front-end.student.view-lesson',
        compact('lessons','lesson','title'));
    }

    private function lessonViews($lesson, $views)
    {
        DB::transaction(function() use($lesson, $views){
            $checkView = LessonUser::where('lesson_id',$lesson->id)
            ->where('user_id',userAuthInfo()->id)->first();
            if (empty($checkView)) {
                $lesson->update(['views'=>$views+1]);
            }
            request()->user()->lessonUser()->firstOrCreate(['lesson_id'=>$lesson->id]);
        });
    }

    public function subjects()
    {
        $title = trans('student.subjects');
        $subjects = studentSubjects();          
        return view('layouts.front-end.student.subjects.view-subjects',
        compact('subjects','title'));
    }

    public function playlists($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $playlists = Playlist::where('employee_id',$employee_id)->sort()->get();        
        $title = trans('student.playlists');
        return view('layouts.front-end.student.subjects.view-playlists',
        compact('playlists','title','employee'));
    }

    public function showLessons($playlist_id)
    {
        $lessons = Lesson::where('playlist_id',$playlist_id)->paginate(10);
        $playlist = Playlist::findOrFail($playlist_id);
        
        $title = $playlist->playlist_name;
        $n = 1;
        return view('layouts.front-end.student.subjects.show-lessons',
        compact('playlist','title','lessons','n'));
    }
    
    public function upcomingExams()
    {                
        $title = trans('student.upcoming_exams');
        $data = Exam::with('lessons','classrooms')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->where('start_date','>',date_format(\Carbon\Carbon::now(),"Y-m-d"))
        // ->where('start_time','>',date_format(\Carbon\Carbon::now(),"H:i"))
        ->orderBy('start_date')->get();

        if (request()->ajax()) {
            return $this->dataTableUpComingExams($data);
        }

        return view('layouts.front-end.student.exams.upcoming-exam',
        compact('title'));

    }
    
    private function dataTableUpComingExams($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('exam_name',function($data){
            return '<span><strong>'.$data->exam_name.'</strong></span> </br>' .
            '<span class="black small">'.$data->description.'</span>';
        })
        ->addColumn('start',function($data){
            return '<span class="blue">'.\Carbon\Carbon::parse( $data->start_date)->format('M d Y').'</span>';
        })  
        ->addColumn('end',function($data){
            return '<span class="red">'.\Carbon\Carbon::parse( $data->end_date)->format('M d Y').'</span>';
        })
        ->addColumn('lessons',function($data){
            foreach ($data->lessons as $lesson) {                
                return '<div class="mb-1 badge badge-danger">
                    <i class="la la-book font-medium-3"></i>
                    <span><a target="_blank" href="'.route('student.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id]).'">'.$lesson->lesson_title.'</a></span>
                </div>';
            }
        })
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
            return '<span class="purple">'.$subject.'</span>';
        }) 
                            
        ->rawColumns(['start','end','exam_name','subject','lessons'])
        ->make(true);
    }

    public function exams()
    {
        $title = trans('student.available_exams');
        $data = Exam::with('lessons','classrooms')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->whereHas('questions',function($q){})
        ->whereDoesntHave('userExams')
        ->where('start_date','<=',date_format(\Carbon\Carbon::now(),"Y-m-d"))
        ->where('start_time','<',date_format(\Carbon\Carbon::now(),"H:i"))
        
        ->orderBy('start_date')->get();

        if (request()->ajax()) {
            return $this->dataTableExams($data);
        }

        return view('layouts.front-end.student.exams.exams',
        compact('title'));

    }

    private function dataTableExams($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('exam_name',function($data){
            return '<span><strong>'.$data->exam_name.'</strong></span> </br>' .
            '<span class="black small">'.$data->description.'</span>';
        })
        ->addColumn('start',function($data){
            return '<span class="blue">'.\Carbon\Carbon::parse( $data->start_date)->format('M d Y').'<br>
            '.\Carbon\Carbon::parse( $data->start_time)->format('H:i a').'
            </span>';
        })  
        ->addColumn('end',function($data){
            return '<span class="red">'.\Carbon\Carbon::parse( $data->end_date)->format('M d Y').' <br>
            '.\Carbon\Carbon::parse( $data->end_time)->format('H:i a').'
            </span>';
        }) 
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
            return '<span class="purple">'.$subject.'</span>';
        })   
        ->addColumn('mark',function($data){
            return $data->userAnswers->sum('mark') == 0 ? '-' :$data->userAnswers->sum('mark');
        }) 
        ->addColumn('answers',function($data){
            return '<span class="red">'.$data->userAnswers->count().'/'.$data->questions->count().'</span>';
        })     
        ->addColumn('start_exam', function($data){

            $time = new Carbon( $data->start_time);
            $time_end = new Carbon( $data->start_end);
            $btn = '';

            // hidden before date & time
            if($data->start_date >= date_format(\Carbon\Carbon::now(),"Y-m-d")){
                    $btn = '<span class="blue"><strong>'.trans('learning::local.not_yet').'</strong></span>';
            }    

            // today
            if ($data->start_date <= date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                date_format($time->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")) {
                    $btn = '<a class="btn btn-success btn-sm" href="'.route('student.pre-start-exam',$data->id).'">
                        '.trans('student.start_exam').'
                    </a>';
            }
            if($data->start_date < date_format(\Carbon\Carbon::now(),"Y-m-d")){
                $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
            }
                        
            // hidden after date & time
            
            if($data->start_date == date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                date_format($time_end->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")){
                $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
            } 
            
            return $btn;


        })                       
        ->rawColumns(['start','end','exam_name','subject','mark','answers','start_exam'])
        ->make(true);
    }

    public function preStartExam($exam_id)
    {
        $count = UserExam::where('exam_id',$exam_id)->where('user_id',userAuthInfo()->id)->count();
        if ($count > 0) {
            return view('layouts.front-end.student.exams.finished_exam');
        }
        $exam = Exam::with('subjects','divisions','grades')->where('id',$exam_id)->first();                
        return view('layouts.front-end.student.exams.pre-start-exam',
        compact('exam'));
    }

    public function startExam($exam_id)
    {
        $count = UserExam::where('exam_id',$exam_id)->where('user_id',userAuthInfo()->id)->count();
        if ($count > 0) {
            return view('layouts.front-end.student.exams.finished_exam');
        }
        $exam = Exam::with('subjects','divisions','grades')->where('id',$exam_id)->first();            
        // attend exam
        UserExam::create(['exam_id' => $exam_id,'user_id'=>userAuthInfo()->id]);

        $questions = Question::with('answers','matchings')->where('exam_id',$exam->id)->orderBy('question_type')
        ->get();  

        $questions = $questions->shuffle();   
                
        $n = 1;
        
        return view('layouts.front-end.student.exams.start-exam',
        compact('exam','questions','n'));
    }

    public function submitExam()
    {               
        DB::transaction(function(){
            $questions_count = request('questions_count');
            $this->resetExam();

            request()->user()->userExam()->firstOrCreate(['exam_id'=>request('exam_id')]);            

            for ($i=0; $i < $questions_count; $i++) { 
                request()->user()->userAnswers()->firstOrCreate([
                    'question_id'   => request('question_id')[$i],
                    'user_answer'   => request(request('question_id')[$i]),
                    'exam_id'       => request('exam_id'),                
                ]); 
            }
            $this->autoCorrectExam(request('exam_id'));
            if (request('auto_correct') == 'yes') {
                Exam::where('id', request('exam_id'))->update(['correct'=>'corrected']);
            }
        });       
        return redirect()->route('student.feedback-exam',request('exam_id'));
    }

    private function resetExam()
    {
        UserExam::where('exam_id',request('exam_id'))->delete();
        UserAnswer::where('exam_id',request('exam_id'))->delete();
    }

    private function autoCorrectExam($exam_id)
    {
        DB::transaction(function() use($exam_id){
            $user_answers = UserAnswer::where('exam_id',$exam_id)->get();
            foreach ($user_answers as $ans) {
                $total_mark = Question::findOrFail($ans->question_id)->mark;
                
                $correct_answer = Answer::where('question_id',$ans->question_id)->where('right_answer','true')->get();
                foreach ($correct_answer as $answer) {
                    if ($ans->user_answer == $answer->answer_text) {
                        UserAnswer::where('question_id',$ans->question_id)
                        ->update(['mark'=>$total_mark]);
                    }
                    
                }
            }                        
        });
    }

    public function examFeedback($exam_id)
    {
        $exam = Exam::with('questions','userAnswers')->where('id',$exam_id)->first();
        $questions = Question::with('answers','matchings')->where('exam_id',$exam_id)->orderBy('question_type')
        ->get(); 
        $n = 1;
        return view('layouts.front-end.student.exams.exam-feedback',
        compact('exam','questions','n'));
    }

    public function results()
    {
        $title = trans('student.results');
        $data = Exam::with('questions','classrooms','userAnswers','userExams')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->whereHas('questions',function($q){})
        ->whereHas('userExams',function($q){})        
        ->orderBy('start_date')
        ->where('show_results','yes')
        ->get();

        if (request()->ajax()) {
            return $this->dataTableResults($data);
        }
        
        return view('layouts.front-end.student.exams.results',
        compact('title'));
    }

    private function dataTableResults($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('exam_name',function($data){
            return '<span><strong>'.$data->exam_name.'</strong></span> </br>' .
            '<span class="black small">'.$data->description.'</span>';
        })
        ->addColumn('date_exam',function($data){

            foreach ($data->userExams as $user_exam) {
                return '<span class="blue">'. \Carbon\Carbon::parse( $user_exam->created_at)->format('M d Y, D').'</span>';                
            }           
        })  
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
            return '<span class="purple">'.$subject.'</span>';
        }) 
 
        ->addColumn('mark',function($data){
            return $data->userAnswers->sum('mark');
        }) 
        ->addColumn('answers',function($data){            
            $right_answers = 0;
            foreach ($data->userAnswers as $answer) {
                if ($answer->mark != 0) {
                    $right_answers ++;
                }
            }
            return '<span class="red">'.$right_answers.'/'.$data->questions->count().'</span>';
        }) 
        ->addColumn('show_answers',function($data){
            return '<a class="btn btn-primary btn-sm" href="'.route('student.answers',$data->id).'">
                '.trans('student.answers').'
            </a>';                
        }) 
        ->addColumn('report',function($data){
            foreach ($data->userExams as $user_exam) {
                return empty($user_exam->report)? '':'<a class="btn btn-info btn-sm" onclick="getReport('.$user_exam->exam_id.')" href="#">
                    '.trans('student.report').'
                </a>';                                
            }
        })                                  
        ->rawColumns(['date_exam','exam_name','subject','mark','answers','show_answers','report'])
        ->make(true);
    }
    
    public function answers($exam_id)
    {
        $exam = Exam::with('userAnswers','userExams')->where('id',$exam_id)->first();
        
        $questions = Question::with('answers','matchings')->where('exam_id',$exam_id)->orderBy('question_type')
        ->get(); 
        
        $title = trans('student.answers');
        $n = 1;
        return view('layouts.front-end.student.exams.answers',
        compact('title','exam','questions','n'));
    }

    public function getReport()
    {        
        if (request()->ajax()) {
            $report = UserExam::where('exam_id',request('exam_id'))->first()->report;
            return json_encode($report);
        }
    }

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
        if($date >= date_format(\Carbon\Carbon::now(),"Y-m-d")){
                $color = 'blue';
        }    

        // today
        if ($date <= date_format(\Carbon\Carbon::now(),"Y-m-d") && 
            date_format($time->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")) {
            $color = 'green';
        }
        if($date < date_format(\Carbon\Carbon::now(),"Y-m-d")){
            $color = 'red';
        }
                    
        // hidden after date & time
        
        $time = $time->addMinutes(45);
        
        if($date == date_format(\Carbon\Carbon::now(),"Y-m-d") && 
            date_format($time,"H:i") < date_format(\Carbon\Carbon::now(),"H:i")){
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
                if($data->start_date >= date_format(\Carbon\Carbon::now(),"Y-m-d")){
                        $btn = '<span class="blue"><strong>'.trans('learning::local.not_yet').'</strong></span>';
                }    

                // today
                if ($data->start_date <= date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                    date_format($time->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")) {
                    $employees = $data->subject->employees;                    
                    $btn = '<a target="_blank" href="'.route('student.live-classroom',['employee_id'=>$this->employeeID($employees),
                    'zoom_schedule_id'=>$data->id]).'" 
                                class="btn btn-purple btn-sm" ">'.trans('student.join').' 
                            </a>';
                }
                if($data->start_date < date_format(\Carbon\Carbon::now(),"Y-m-d")){
                    $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
                }
                            
                // hidden after date & time
                
                $time = $time->addMinutes(45);
                
                if($data->start_date == date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                    date_format($time,"H:i") < date_format(\Carbon\Carbon::now(),"H:i")){
                    $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
                } 
                
                return $btn;
            }) 
            ->addColumn('start_date',function($data){
                return '<span class="blue">'.\Carbon\Carbon::parse( $data->start_date)->format('M d Y').'<br>
                '.\Carbon\Carbon::parse( $data->start_time)->format('h:i a').'
                </span>';
            })  
            ->addColumn('subject',function($data){
                return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
            })   
            ->addColumn('pass_code',function($data){
                $time = new Carbon( $data->start_time);
                $passcode = '';

                // hidden before date & time
                if($data->start_date >= date_format(\Carbon\Carbon::now(),"Y-m-d")){
                    $passcode = '*****';
                }    

                // today
                if ($data->start_date <= date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                    date_format($time->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")) {
                    $employees = $data->subject->employees;                    
                    $passcode = $this->passcode($employees);
                }

                if($data->start_date < date_format(\Carbon\Carbon::now(),"Y-m-d")){
                    $passcode = '*****';
                }
                            
                // hidden after date & time
                
                $time = $time->addMinutes(45);
                
                if($data->start_date == date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                    date_format($time,"H:i") < date_format(\Carbon\Carbon::now(),"H:i")){
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

    public function homeworks()
    {        
        $title = trans('student.available_homeworks');
        $data = Homework::with('lessons','classrooms','subject')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })        
        // ->whereDoesntHave('deliverHomeworks')        
        ->get();                    

        if (request()->ajax()) {
            return $this->homeworkDataTable($data);
        }

        return view('layouts.front-end.student.homeworks.available-homework',
        compact('title'));
    }

    private function homeworkDataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('lessons',function($data){
            $lessons = '';
            foreach ($data->lessons as $lesson) {                
                $lessons .='<div class="mt-1 mr-1 badge badge-info">
                    <i class="la la-book font-medium-3"></i>
                    <span><a target="_blank" href="'.route('student.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id]).'">'.$lesson->lesson_title.'</a></span>
                </div>';
            }
            return $lessons;
        })
        ->addColumn('due_date',function($data){
            return \Carbon\Carbon::parse( $data->due_date)->format('M d Y');
        }) 
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subject->ar_name : $data->subject->en_name;
            return '<span class="purple">'.$subject.'</span>';
        })   
        ->addColumn('file_name',function($data){
            return empty($data->file_name) ? '':'<a target="_blank"  href="'.asset('images/homework_attachments/'.$data->file_name).'"
             class="btn btn-primary btn-sm" href="#"><i class=" la la-download"></i></a>';
        }) 
        ->addColumn('deliver',function($data){            
            return ($data->due_date < date_format(\Carbon\Carbon::now(),"Y-m-d") || !empty($data->due_date)) && !empty($data->correct) ? '' :
            '<a class="btn btn-light btn-sm" href="'.route('student.deliver-homeworks',$data->id).'"><i class=" la la-level-up"></i></a>';                            
        })     
                       
        ->rawColumns(['lessons','due_date','subject','file_name','deliver'])
        ->make(true);
    }

    public function deliverHomework($homework_id)
    {
        $title = trans('student.deliver_homework');
        
        $homework = Homework::findOrFail($homework_id);
        $questions = Question::where('homework_id',$homework_id)->get();
        // homework corrected 
        $current_answer = $this->currentAnswer($homework_id);
        if (!empty($homework->correct)) {
            // return to homework results
            
        }   

        // expire date homework
        if ($homework->due_date < date_format(Carbon::now(),"Y-m-d") && !empty($homework->due_date)) {
            return redirect()->route('student.homeworks');
        }

        $path = '';                
        // check type of homework assignment or questions
        if (count($questions) > 0) {
            $path = 'layouts.front-end.student.homeworks.questions-homework';
        }else{
            $path = 'layouts.front-end.student.homeworks.deliver-homework';            
        }
        $n = 1;
        return view($path, compact('title','homework','current_answer','questions','n'));

    }
    public function storeHomework()
    {
        $image_path = '';    
        $current_answer = $this->currentAnswer(request('homework_id'));
        if (request()->hasFile('file_name')) {
            $where = [
                ['homework_id',request('homework_id')],
                ['user_id',userAuthInfo()->id]
            ]; 
            $user_answer = DeliverHomework::where($where)->first(); 
            if (!empty($current_answer)) { 
                if ($user_answer->file_name != '') {
                    $image_path = public_path()."/images/homework_attachments/".$user_answer->file_name;                                                             
                    removeFileOrImage($image_path); // remove file from directory                
                }
                $image_path = '';                  
            } 
            
            $this->file_name = uploadFileOrImage($image_path,request('file_name'),'images/homework_attachments');                                             
        }

        if (!empty($current_answer)) {            
            $current_answer->update(
                [
                    'user_answer'   =>  request('user_answer'),
                    'file_name'     =>  $this->file_name
                ]);
        }else{
            request()->user()->deliverHomework()->firstOrCreate([
                'homework_id'   =>  request('homework_id'),
                'user_answer'   =>  request('user_answer'),
                'file_name'     =>  $this->file_name
            ]);
        }
        toast(trans('student.msg_deliver'),'success');
        return redirect()->route('student.homeworks');
    }

    private function currentAnswer($homework_id)
    {
        $where = [
            ['homework_id',request('homework_id')],
            ['user_id',userAuthInfo()->id]
        ];
        return DeliverHomework::where($where)->first();
    }

    public function storeQuestionsAnswers()
    {        
        DB::transaction(function(){
            $questions_count = request('questions_count');                    

            for ($i=0; $i < $questions_count; $i++) { 
                request()->user()->deliverHomework()->firstOrCreate([
                    'question_id'   => request('question_id')[$i],
                    'user_answer'   => request(request('question_id')[$i]),
                    'homework_id'   => request('homework_id'),                
                ]); 
            }
            $this->autoCorrectHomework(request('homework_id'));
            Homework::where('id', request('homework_id'))->update(['correct'=>'corrected']);            
        });  
        return redirect()->route('student.homeworks');
    }

    private function autoCorrectHomework($homework_id)
    {
        DB::transaction(function() use($homework_id){
            $user_answers = DeliverHomework::where('homework_id',$homework_id)->get();
            foreach ($user_answers as $ans) {
                $total_mark = Question::findOrFail($ans->question_id)->mark;
                $correct_answer = Answer::where('question_id',$ans->question_id)->where('right_answer','true')->get();
                
                foreach ($correct_answer as $answer) {
                    if ($ans->user_answer == $answer->answer_text) {
                        DeliverHomework::where('question_id',$ans->question_id)
                        ->update(['mark'=>$total_mark]);
                    }
                    
                }
            }                        
        });
    }

    public function homeworkResults()
    {
        $title = trans('student.results');
        $data = Homework::with('lessons','classrooms','subject','deliverHomeworks')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        }) 
        ->whereHas('deliverHomeworks')               
        ->get();        

        if (request()->ajax()) {
            return $this->deliverHomeworkDataTable($data);
        }

        return view('layouts.front-end.student.homeworks.results',
        compact('title'));
    }

    private function deliverHomeworkDataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('due_date',function($data){
            return \Carbon\Carbon::parse( $data->due_date)->format('M d Y');
        }) 
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subject->ar_name : $data->subject->en_name;
            return '<span class="purple">'.$subject.'</span>';
        })   
        ->addColumn('show_answers',function($data){
            return $data->correct == ''?  '<span class="red">'.trans('student.not_correct').'</span>'
            : '<a class="btn btn-primary btn-sm" href="'.route('homework.answers',$data->id).'">
                '.trans('student.answers').'
            </a>';
        }) 
        ->addColumn('mark',function($data){
            return $data->deliverHomeworks->sum('mark') . ' / <strong>' . $data->total_mark .'</strong>';
        })  
        ->rawColumns(['due_date','subject','file_name','deliver','mark','show_answers'])
        ->make(true);
    }

    public function homeworkAnswers($homework_id)
    {
        $homework = Homework::with('deliverHomeworks','questions')->where('id',$homework_id)->first();        
        
        $questions = Question::with('answers','matchings','userAnswers')
        ->where('homework_id',$homework_id)->orderBy('question_type')
        ->get(); 
        
        $title = trans('student.answers');
        
        $n = 1;
        return view('layouts.front-end.student.homeworks.show-answers',
        compact('title','homework','questions','n'));
    }

}
