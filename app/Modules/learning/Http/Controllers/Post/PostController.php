<?php

namespace Learning\Http\Controllers\Post;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Learning\Models\Learning\Post;
use Illuminate\Http\Request;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Lesson;
use Student\Models\Settings\Classroom;

class PostController extends Controller
{
    private $file_name;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($classroom_id)
    {
         $exams = Exam::with('classrooms')->whereHas('classrooms',function($q) use($classroom_id){
            $q->where('classroom_id',$classroom_id);
         })
         ->where('start_date','>=',\Carbon\Carbon::today())
         ->where('admin_id',authInfo()->id)
         ->get();         

        $classroom = Classroom::findOrFail($classroom_id);
        $where = [
            ['classroom_id',$classroom_id],  
            ['admin_id',authInfo()->id]  
        ];
        $classrooms = Classroom::with('employees')->whereHas('employees',function($q){
            $q->where('employee_id',employee_id());
        })->get();
        
        $lessons = Lesson::with('subject')->where('admin_id',authInfo()->id)->orderBy('lesson_title')->get(); 

        $posts = Post::where($where)->orderBy('created_at','desc')->limit(30)->get();
        $title = trans('learning::local.posts');
        return view('learning::teacher.posts.index',
        compact('title','classroom','posts','exams','lessons'));
    }

    private function attributes()
    {
        return [        
            'post_text',                               
            'youtube_url',                       
            'url',                                               
            'post_type',                                               
            'description',                                               
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
        if ($request->hasFile('file_name')) {
            $image_path = '';                                        
                $this->file_name = uploadFileOrImage($image_path,request('file_name'),'images/posts_attachments');                                             
        }
        foreach (request('classroom_id') as $classroom_id) {
            $request->user()->posts()->firstOrCreate($request->only($this->attributes())+
                [
                    'file_name'     => $this->file_name,
                    'classroom_id'  => $classroom_id,
                ]);            
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('posts.index',request('classroom_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = trans('learning::local.edit_post');
        return view('learning::teacher.posts.edit-post',
        compact('title','post'));
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
        $post->update(request()->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('posts.index',$post->classroom_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        toast(trans('msg.delete_successfully'),'success');
        return redirect()->route('posts.index',request('classroom_id'));
    }

}
