<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Question;
use DB;

class QuestionController extends Controller
{
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
        // dd(request()->all());
        DB::transaction(function(){
            $question =  request()->user()->questions()->firstOrCreate(request()->only($this->attributes()));

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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        //
    }
}
