<?php

namespace App\Http\Controllers\ParentStudent;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Comment;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Playlist;
use Learning\Models\Learning\Post;
use Learning\Models\Learning\Question;
use PhpParser\Node\Expr\FuncCall;
use Staff\Models\Employees\Employee;
use Student\Models\Settings\Classroom;

class UserStudentController extends Controller
{
    public function dashboard()
    {                
        $exams = Exam::with('classrooms')->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })
        ->where('start_date','>=',\Carbon\Carbon::today())
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
    
    public function preview($exam_id)
    {
        $exam = Exam::with('subjects','divisions','grades')->where('id',$exam_id)->first();            
        $questions = Question::with('answers','matchings')->where('exam_id',$exam->id)->orderBy('question_type')
        ->get();    
        $questions = $questions->shuffle();   
                
        $n = 1;
        $title = trans('learning::local.preview_exam');
        return view('layouts.front-end.student.preview-exam',
        compact('title','exam','questions','n'));
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
}
