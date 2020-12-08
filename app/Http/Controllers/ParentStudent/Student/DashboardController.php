<?php

namespace App\Http\Controllers\ParentStudent\Student;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Comment;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Post;
use Student\Models\Settings\Classroom;

class DashboardController extends Controller
{
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

        $posts = Post::with('admin')->where('classroom_id',classroom_id())
        ->orderBy('created_at','desc')->limit(30)->get();
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
            ->select('comments.*','admins.name','admins.ar_name','users.name as en_student_name',
            'users.ar_name as ar_student_name')
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
}
