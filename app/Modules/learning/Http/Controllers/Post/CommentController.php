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
            $comments = Comment::where('post_id', request('id'))
                ->leftJoin('admins', 'comments.admin_id', '=', 'admins.id')
                ->leftJoin('users', 'comments.user_id', '=', 'users.id')
                ->select('comments.*', 'admins.name', 'admins.ar_name', 'users.name as en_student_name', 'users.ar_name as ar_student_name')
                ->get();

            $comment_count = Comment::where('post_id', request('id'))->count();
            return view(
                'learning::teacher.posts.includes._comments',
                compact('comments', 'comment_count')
            );
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
        return response(['status' => true]);
    }
}
