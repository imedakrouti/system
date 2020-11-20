<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Question;
use DB;
use Learning\Models\Learning\Answer;
use Learning\Models\Learning\Matching;

class QuestionController extends Controller
{
    private $file_name;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
            'question_type',
            'question_text',
            'mark',        
            'exam_id',                       
            'admin_id',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {        
        DB::transaction(function(){
            // check exist image
            if (request()->hasFile('file_name')) {

                $image_path = '';                                        
                $this->file_name = uploadFileOrImage($image_path,request('file_name'),'images/questions_attachments'); 

                $question =  request()->user()->questions()->firstOrCreate(request()->only($this->attributes()) + 
                [ 'file_name' => $this->file_name]);                
            }else{
                $question =  request()->user()->questions()->firstOrCreate(request()->only($this->attributes()));                
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

            if (request('question_type') == 'essay') {
                request()->user()->answers()->firstOrCreate([
                    'answer_text'   => '',
                    'answer_note'   => '',
                    'right_answer'  => 'false',
                    'question_id'   => $question->id,
                ]);
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
        return redirect()->route('exams.show',request('exam_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        $question = Question::with('exam','answers','matchings')->where('id',$question->id)->first();
        $title = trans('learning::local.edit_question');
        return view('learning::exams.questions.edit',
        compact('title','question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update( Question $question)
    {
        // dd(request()->all());
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
        return redirect()->route('exams.show',$question->exam_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {        
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Question::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    private function removeImage()
    {
        $question = Question::findOrFail(request('question_id')); 
        $image_path = public_path()."/images/questions_attachments/".$question->file_name; 
        if(\File::exists($image_path)) {
            \File::delete($image_path);                
        }  
        $question->update(['file_name' => null]);
    }
}
