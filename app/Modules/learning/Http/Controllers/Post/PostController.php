<?php

namespace Learning\Http\Controllers\Post;
use App\Http\Controllers\Controller;

use Learning\Models\Learning\Post;
use Illuminate\Http\Request;
use Student\Models\Settings\Classroom;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($classroom_id)
    {
        $classroom = Classroom::findOrFail($classroom_id);
        $where = [
            ['classroom_id',$classroom_id],  
            ['admin_id',authInfo()->id]  
        ];
        $posts = Post::where($where)->orderBy('created_at','desc')->get();
        $title = trans('learning::local.posts');
        return view('learning::teacher.posts.index',
        compact('title','classroom','posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    private function attributes()
    {
        return [        
            'post_text',                               
            'youtube_url',                       
            'url',                       
            'file_name',                       
            'classroom_id',                       
            'admin_id',                                   
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->user()->posts()->firstOrCreate($request->only($this->attributes()));
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('posts.index',request('classroom_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
