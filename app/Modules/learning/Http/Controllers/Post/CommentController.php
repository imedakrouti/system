<?php

namespace Learning\Http\Controllers\Post;
use App\Http\Controllers\Controller;

use Learning\Models\Learning\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $comments = Comment::with('admin')->where('post_id',request('id'))->get();
            $comment_count = Comment::with('admin')->where('post_id',request('id'))->count();
            return view('learning::teacher.posts.includes._comments',
            compact('comments','comment_count'));
        }
    }

    private function attributes()
    {
        return [        
            'comment_text',                       
            'file_name',                       
            'post_id',                       
            'user_id',                       
            'admin_id',                                          
        ];
    }

    public function store(Request $request)
    {        
        if (request()->ajax()) {
            $request->user()->comments()->create($request->only($this->attributes()));
        }
        return response(['status'=>true]);
    }


}
