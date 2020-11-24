<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Learning\Models\Learning\Homework;
use DB;

class HomeworkController extends Controller
{
    private $file_name;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attributes()
    {
        return [
            'title',
            'due_date',
            'instruction',            
            'subject_id',
            'admin_id',                
            'total_mark',                        
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
        // dd(request()->all());
        DB::transaction(function() use($request){ 
            if ($request->hasFile('file_name')) {
                $file_path = '';                                        
                $this->file_name = uploadFileOrImage($file_path,request('file_name'),'images/homework_attachments');                                             
            }
           $homework = request()->user()->homeworks()->firstOrCreate(request()->only($this->attributes()) + [
            'file_name' => $this->file_name,
            ]);
            foreach (request('classroom_id') as $classroom_id) {
                // add to homework_classroom table
                $homework->classrooms()->attach($classroom_id);  
                // add post
                request()->user()->posts()->firstOrCreate(
                    [                        
                        'post_type'     => 'assignment',                        
                        'post_text'     => $homework->instruction,                        
                        'description'   => $homework->title,                        
                        'url'           => null,                        
                        'youtube_url'   => null,                        
                        'classroom_id'  => $classroom_id,
                    ]);
            }

            foreach (request('lessons') as $lesson_id) {
                $homework->lessons()->attach($lesson_id);                        
            }

        });   
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('posts.index',request('current_classroom_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function show(Homework $Homework)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function edit(Homework $Homework)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Homework $Homework)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $Homework)
    {
        //
    }
}
