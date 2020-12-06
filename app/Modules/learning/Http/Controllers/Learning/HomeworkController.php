<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Learning\Models\Learning\Homework;
use DB;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Question;
use Student\Models\Settings\Classroom;

class HomeworkController extends Controller
{
    private $file_name;
    private $homework;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function teacherHomeworks()
    {
        $classrooms = Classroom::with('employees')->whereHas('employees',function($q){
            $q->where('employee_id',employee_id());
        })->get();

        $lessons = Lesson::with('subject')->where('admin_id',authInfo()->id)->orderBy('lesson_title')->get(); 

        $data = Homework::where('admin_id',authInfo()->id)->orderBy('created_at','desc')->get();
        $title = trans('learning::local.class_work');
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::teacher.homework.teacher-homeworks',
        compact('title','classrooms','lessons'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()        
                    ->addColumn('subject',function($data){
                        return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
                    })
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('homeworks.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    }) 
                    ->addColumn('show_homework', function($data){
                        $btn = '';
                        if (empty($data->instruction)) {
                            $btn = '<a class="btn btn-primary btn-sm" href="'.route('homework-question',$data->id).'">
                                '.trans('learning::local.show_homework').'
                            </a>';                            
                        }else{
                            $btn = '<a class="btn btn-purple btn-sm" href="'.route('homeworks.show',$data->id).'">
                                '.trans('learning::local.show_homework').'
                            </a>';                            
                        }
                            return $btn;
                    })                               
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','subject','show_homework'])
                    ->make(true);
    }
    public function questionPage($homework_id)
    {
        $homework = Homework::with('classrooms','lessons')->where('id',$homework_id)->first();
        
        $questions = Question::with('answers','matchings')
        ->where('homework_id',$homework_id)->orderBy('question_type')->get();   
        $n = 1;
        $questions = $questions->shuffle();   
        
        $title = trans('learning::local.add_questions');
        
        return view('learning::teacher.homework.question-homework',
        compact('title','questions','homework','n'));
    }
    public function share()
    {
        if (request()->ajax()) {
            if (request()->has('homework_id')) {
                $homework = Homework::with('classrooms')->where('id',request('homework_id'))->first();
                $url = route('homework.solve-question',$homework->id);
                foreach ($homework->classrooms as $classroom) {
                    request()->user()->posts()->create(
                        [                        
                            'post_type'     => 'assignment',                        
                            'post_text'     => $homework->title,                        
                            'url'           => $url,                        
                            'description'   => null,                        
                            'youtube_url'   => null,                        
                            'classroom_id'  => $classroom->id
                        ]);                                        
                }
            }
        }
        return response(['status'=>true]);
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
        DB::transaction(function() use($request){ 
            if ($request->hasFile('file_name')) {
                $file_path = '';                                        
                $this->file_name = uploadFileOrImage($file_path,request('file_name'),'images/homework_attachments');                                             
            }
           $this->homework = request()->user()->homeworks()->firstOrCreate(request()->only($this->attributes()) + [
            'file_name' => $this->file_name,
            ]);
            foreach (request('classroom_id') as $classroom_id) {
                // add to homework_classroom table
                // DB::table('classroom_homework')->where('classroom_id',$classroom_id)->delete();
                $this->homework->classrooms()->attach($classroom_id);  
                // add post
                if (request()->has('instruction')) {
                    $url = route('homework.solve-question',$this->homework->id);
                    request()->user()->posts()->create(
                        [                        
                            'post_type'     => 'assignment',                        
                            'post_text'     => $this->homework->instruction,                        
                            'description'   => $this->homework->title,                        
                            'url'           => $url,                        
                            'youtube_url'   => null,                        
                            'classroom_id'  => $classroom_id,
                        ]);                    
                }
            }
            DB::table('lesson_homework')->where('homework_id',$this->homework->id)->delete();
            foreach (request('lessons') as $lesson_id) {
                $this->homework->lessons()->attach($lesson_id);                        
            }

        });   

        if (request()->has('instruction')) {
            toast(trans('learning::local.add_published_successfully'),'success');
            return redirect()->route('homeworks.show',$this->homework->id);            
        }

        return redirect()->route('homework-question',$this->homework->id);
    }
    private function questionAttributes()
    {
        return [
            'question_type',
            'question_text',
            'mark',        
            'homework_id',                       
            'admin_id',
        ];
    }

    public function storeQuestion()
    {
        DB::transaction(function(){
            // check exist image
            if (request()->hasFile('file_name')) {

                $image_path = '';                                        
                $this->file_name = uploadFileOrImage($image_path,request('file_name'),'images/questions_attachments'); 

                $question =  request()->user()->questions()->firstOrCreate(request()->only($this->questionAttributes()) + 
                [ 'file_name' => $this->file_name]);                
            }else{
                $question =  request()->user()->questions()->firstOrCreate(request()->only($this->questionAttributes()));                
            }

            if (request('question_type') == 'multiple_choice' || request('question_type') == 'complete') {
                foreach (request('repeater-group') as $answer) {                 
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => $answer['answer_note'],
                        'right_answer'  => $answer['right_answer'],
                        'question_id'   => $question->id,
                    ]);
                }                
            }        

            if (request('question_type') == 'true_false') {
                for ($i=0; $i < count(request('answer_text')); $i++) {                     
                   request()->user()->answers()->firstOrCreate([
                       'answer_text'   => request('answer_text')[$i],
                       'answer_note'   => request('answer_note')[$i],
                       'right_answer'  => request('right_answer')[$i],
                       'question_id'   => $question->id,
                   ]);
                }                
            }

            if (request('question_type') == 'matching') {
                // matchings
                foreach (request('repeater-group-a') as $matching) {                 
                    request()->user()->matchings()->firstOrCreate([
                        'matching_item'     => $matching['matching_item'],
                        'matching_answer'   => $matching['matching_answer'],
                        'exam_id'           => request('exam_id'),
                        'question_id'       => $question->id,
                    ]);
                } 
                // answers
                foreach (request('repeater-group-b') as $answer) {                 
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => '',
                        'right_answer'  => 'false',
                        'question_id'   => $question->id,
                    ]);
                } 
            }
    
        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('homework-question',request('homework_id'));
    }

    public function editQuestion($question_id)
    {
        $question = Question::with('exam','answers','matchings')->where('id',$question_id)->first();
        $title = trans('learning::local.edit_question');
        return view('learning::teacher.questions.edit-question',
        compact('title','question'));
    }

    public function updateQuestion($question_id)
    {        
        $question = Question::findOrFail($question_id);
        if (request()->has('remove_image')) {
            $this->removeImage();
        }
        DB::transaction(function() use($question){   
            
            if (request()->hasFile('file_name')) {
                $image_path = '';  
                // remove old image
                if (!empty($question->file_name)) {
                    $image_path = public_path()."/images/questions_attachments/".$question->file_name;               
                }
                // upload new image
                $this->file_name = uploadFileOrImage($image_path,request('file_name'),'images/questions_attachments'); 

                $question->update([
                    'question_text' => request('question_text'),
                    'mark'          => request('mark'),
                    'file_name'     => $this->file_name
                ]);              
            }else{
                $question->update([
                    'question_text' => request('question_text'),
                    'mark' => request('mark')
                ]);
            }              
            
            // true or false
            if (request('question_type') == trans('learning::local.question_true_false')) {
                Answer::where('question_id',request('question_id'))->delete();
             
                for ($i=0; $i < count(request('answer_text')); $i++) {                     
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => request('answer_text')[$i],
                        'answer_note'   => request('answer_note')[$i],
                        'right_answer'  => request('right_answer')[$i],
                        'question_id'   => $question->id,
                    ]);
                 }                            
            }
            
            // multiple choice or complete
            if (request('question_type') == trans('learning::local.question_multiple_choice') || 
                request('question_type') == trans('learning::local.question_complete')) {
                Answer::where('question_id',request('question_id'))->delete();
                foreach (request('repeater-group') as $answer) {                 
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => $answer['answer_note'],
                        'right_answer'  => $answer['right_answer'],
                        'question_id'   => $question->id,
                    ]);
                }                
            }  

            // matching
            if (request('question_type') == trans('learning::local.question_matching')) {
                // matchings
                Matching::where('question_id',request('question_id'))->delete();
                foreach (request('repeater-group-a') as $matching) {                 
                    request()->user()->matchings()->firstOrCreate([
                        'matching_item'     => $matching['matching_item'],
                        'matching_answer'   => $matching['matching_answer'],
                        'exam_id'           => request('exam_id'),
                        'question_id'       => $question->id,
                    ]);
                } 
                // answers
                Answer::where('question_id',request('question_id'))->delete();
                foreach (request('repeater-group-b') as $answer) {                 
                    request()->user()->answers()->firstOrCreate([
                        'answer_text'   => $answer['answer_text'],
                        'answer_note'   => '',
                        'right_answer'  => 'false',
                        'question_id'   => $question->id,
                    ]);
                } 
            }
        });

        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('teacher.show-exam',$question->exam_id);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $title = trans('learning::local.class_work');
        $classrooms = Classroom::with('employees')->whereHas('employees',function($q){
            $q->where('employee_id',employee_id());
        })->get();

        $lessons = Lesson::with('subject')->where('admin_id',authInfo()->id)->orderBy('lesson_title')->get(); 
        $homework = Homework::findOrFail($id);
        return view('learning::teacher.homework.show',
        compact('title','homework','classrooms','lessons'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Homework  $Homework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Homework $Homework)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Homework::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function solveHomeworkPage($homework_id)
    {
        dd($homework_id);
    }

    public function edit($id)
    {
        dd($id);
    }

}
