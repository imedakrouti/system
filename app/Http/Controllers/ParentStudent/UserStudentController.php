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
use DB;

class UserStudentController extends Controller
{
    public function dashboard()
    {                
        $exams = Exam::with('classrooms','subjects')->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->where('start_date','>=',\Carbon\Carbon::today())
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
        return view('layouts.front-end.student.view-lesson',
        compact('lessons','lesson','title'));
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
        ->where('start_date','>=',\Carbon\Carbon::today())
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
            return '<a href="'.route('teacher.show-exam',$data->id).'"><span><strong>'.$data->exam_name.'</strong></span></a> </br>' .
            '<span class="black small">'.$data->description.'</span>';
        })
        ->addColumn('start',function($data){
            return '<span class="blue">'.$data->start_date.'</span>';
        })  
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
            return '<span class="purple">'.$subject.'</span>';
        }) 
        ->addColumn('end',function($data){
            return '<span class="red">'.$data->end_date.'</span>';
        })                            
        ->rawColumns(['start','end','exam_name','subject'])
        ->make(true);
    }

    public function exams()
    {
        $title = trans('student.my_exams');
        $data = Exam::with('lessons','classrooms','questions','userAnswers')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->whereHas('questions',function($q){})
        // ->where('start_date','>=',\Carbon\Carbon::today())
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
            return '<a href="'.route('teacher.show-exam',$data->id).'"><span><strong>'.$data->exam_name.'</strong></span></a> </br>' .
            '<span class="black small">'.$data->description.'</span>';
        })
        ->addColumn('start',function($data){
            return '<span class="blue">'.$data->start_date.'</span>';
        })  
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subjects->ar_name : $data->subjects->en_name;
            return '<span class="purple">'.$subject.'</span>';
        }) 
        ->addColumn('end',function($data){
            return '<span class="red">'.$data->end_date.'</span>';
        })   
        ->addColumn('mark',function($data){
            return $data->userAnswers->sum('mark') == 0 ? '-' :$data->userAnswers->sum('mark');
        }) 
        ->addColumn('answers',function($data){
            return '<span class="red">'.$data->userAnswers->count().'/'.$data->questions->count().'</span>';
        })     
        ->addColumn('start_exam', function($data){
            $btn = '<a class="btn btn-success btn-sm" href="'.route('student.pre-start-exam',$data->id).'">
                '.trans('student.start_exam').'
            </a>';
                return $data->userAnswers->sum('mark') == 0 ? $btn : '';
        })                       
        ->rawColumns(['start','end','exam_name','subject','mark','answers','start_exam'])
        ->make(true);
    }
    public function preStartExam($exam_id)
    {
        $exam = Exam::with('subjects','divisions','grades')->where('id',$exam_id)->first();                
        return view('layouts.front-end.student.exams.pre-start-exam',
        compact('exam'));
    }
    public function startExam($exam_id)
    {
        $exam = Exam::with('subjects','divisions','grades')->where('id',$exam_id)->first();            
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
            UserAnswer::where('exam_id',request('exam_id'))->delete();
            for ($i=0; $i < $questions_count; $i++) { 
                request()->user()->userAnswers()->firstOrCreate([
                    'question_id'   => request('question_id')[$i],
                    'user_answer'   => request(request('question_id')[$i]),
                    'exam_id'       => request('exam_id'),                
                ]); 
            }
            if (request('auto_correct') == 'yes') {            
                $this->autoCorrectExam(request('exam_id'));
            }
        });       
        return redirect()->route('student.feedback-exam',request('exam_id'));
    }
    private function autoCorrectExam($exam_id)
    {
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
    }
    public function examFeedback($exam_id)
    {
        $exam = Exam::with('questions','userAnswers')->where('id',$exam_id)->first();
        return view('layouts.front-end.student.exams.exam-feedback',
        compact('exam'));
    }
}
