<?php
namespace App\Http\Controllers\ParentStudent\Student;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Homework;
use Learning\Models\Learning\Answer;
use Learning\Models\Learning\DeliverHomework;
use Learning\Models\Learning\Question;
use Carbon\Carbon;
use DB;

class HomeworkController extends Controller
{
    private $file_name;
    
    public function homeworks()
    {        
        $title = trans('student.available_homeworks');
        $data = Homework::with('lessons','classrooms','subject')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        })        
        // ->whereDoesntHave('deliverHomeworks')        
        ->get();                    

        if (request()->ajax()) {
            return $this->homeworkDataTable($data);
        }

        return view('layouts.front-end.student.homeworks.available-homework',
        compact('title'));
    }

    private function homeworkDataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('lessons',function($data){
            $lessons = '';
            foreach ($data->lessons as $lesson) {                
                $lessons .='<div class="mt-1 mr-1 badge badge-info">
                    <i class="la la-book font-medium-3"></i>
                    <span><a target="_blank" href="'.route('student.view-lesson',['id'=>$lesson->id,'playlist_id'=>$lesson->playlist_id]).'">'.$lesson->lesson_title.'</a></span>
                </div>';
            }
            return $lessons;
        })
        ->addColumn('due_date',function($data){
            return Carbon::parse( $data->due_date)->format('M d Y');
        }) 
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subject->ar_name : $data->subject->en_name;
            return '<span class="purple">'.$subject.'</span>';
        })   
        ->addColumn('file_name',function($data){
            return empty($data->file_name) ? '':'<a target="_blank"  href="'.asset('images/homework_attachments/'.$data->file_name).'"
             class="btn btn-primary btn-sm" href="#"><i class=" la la-download"></i></a>';
        }) 
        ->addColumn('deliver',function($data){            
            return ($data->due_date < date_format(Carbon::now(),"Y-m-d") || !empty($data->due_date)) && !empty($data->correct) ? '' :
            '<a class="btn btn-light btn-sm" href="'.route('student.deliver-homeworks',$data->id).'"><i class=" la la-level-up"></i></a>';                            
        })     
                       
        ->rawColumns(['lessons','due_date','subject','file_name','deliver'])
        ->make(true);
    }

    public function deliverHomework($homework_id)
    {
        $title = trans('student.deliver_homework');
        
        $homework = Homework::findOrFail($homework_id);
        $questions = Question::where('homework_id',$homework_id)->get();
        // homework corrected 
        $current_answer = $this->currentAnswer($homework_id);
        if (!empty($homework->correct)) {
            // return to homework results
            
        }   

        // expire date homework
        if ($homework->due_date < date_format(Carbon::now(),"Y-m-d") && !empty($homework->due_date)) {
            return redirect()->route('student.homeworks');
        }

        $path = '';                
        // check type of homework assignment or questions
        if (count($questions) > 0) {
            $path = 'layouts.front-end.student.homeworks.questions-homework';
        }else{
            $path = 'layouts.front-end.student.homeworks.deliver-homework';            
        }
        $n = 1;
        return view($path, compact('title','homework','current_answer','questions','n'));

    }
    
    public function storeHomework()
    {
        $image_path = '';    
        $current_answer = $this->currentAnswer(request('homework_id'));
        if (request()->hasFile('file_name')) {
            $where = [
                ['homework_id',request('homework_id')],
                ['user_id',userAuthInfo()->id]
            ]; 
            $user_answer = DeliverHomework::where($where)->first(); 
            if (!empty($current_answer)) { 
                if ($user_answer->file_name != '') {
                    $image_path = public_path()."/images/homework_attachments/".$user_answer->file_name;                                                             
                    removeFileOrImage($image_path); // remove file from directory                
                }
                $image_path = '';                  
            } 
            
            $this->file_name = uploadFileOrImage($image_path,request('file_name'),'images/homework_attachments');                                             
        }

        if (!empty($current_answer)) {            
            $current_answer->update(
                [
                    'user_answer'   =>  request('user_answer'),
                    'file_name'     =>  $this->file_name
                ]);
        }else{
            request()->user()->deliverHomework()->firstOrCreate([
                'homework_id'   =>  request('homework_id'),
                'user_answer'   =>  request('user_answer'),
                'file_name'     =>  $this->file_name
            ]);
        }
        toast(trans('student.msg_deliver'),'success');
        return redirect()->route('student.homeworks');
    }

    private function currentAnswer($homework_id)
    {
        $where = [
            ['homework_id',request('homework_id')],
            ['user_id',userAuthInfo()->id]
        ];
        return DeliverHomework::where($where)->first();
    }

    public function storeQuestionsAnswers()
    {        
        DB::transaction(function(){
            $questions_count = request('questions_count');                    

            for ($i=0; $i < $questions_count; $i++) { 
                request()->user()->deliverHomework()->firstOrCreate([
                    'question_id'   => request('question_id')[$i],
                    'user_answer'   => request(request('question_id')[$i]),
                    'homework_id'   => request('homework_id'),                
                ]); 
            }
            $this->autoCorrectHomework(request('homework_id'));
            Homework::where('id', request('homework_id'))->update(['correct'=>'corrected']);            
        });  
        return redirect()->route('student.homeworks');
    }

    private function autoCorrectHomework($homework_id)
    {
        DB::transaction(function() use($homework_id){
            $user_answers = DeliverHomework::where('homework_id',$homework_id)->get();
            foreach ($user_answers as $ans) {
                $total_mark = Question::findOrFail($ans->question_id)->mark;
                $correct_answer = Answer::where('question_id',$ans->question_id)->where('right_answer','true')->get();
                
                foreach ($correct_answer as $answer) {
                    if ($ans->user_answer == $answer->answer_text) {
                        DeliverHomework::where('question_id',$ans->question_id)
                        ->update(['mark'=>$total_mark]);
                    }                    
                }
            }                        
        });
    }

    public function homeworkResults()
    {
        $title = trans('student.results');
        $data = Homework::with('lessons','classrooms','subject','deliverHomeworks')
        ->whereHas('classrooms',function($q){
            $q->where('classroom_id',classroom_id());
        }) 
        ->whereHas('deliverHomeworks')               
        ->get();        

        if (request()->ajax()) {
            return $this->deliverHomeworkDataTable($data);
        }

        return view('layouts.front-end.student.homeworks.results',
        compact('title'));
    }

    private function deliverHomeworkDataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('due_date',function($data){
            return Carbon::parse( $data->due_date)->format('M d Y');
        }) 
        ->addColumn('subject',function($data){
            $subject = session("lang") == "ar" ? $data->subject->ar_name : $data->subject->en_name;
            return '<span class="purple">'.$subject.'</span>';
        })   
        ->addColumn('show_answers',function($data){
            return $data->correct == ''?  '<span class="red">'.trans('student.not_correct').'</span>'
            : '<a class="btn btn-primary btn-sm" href="'.route('homework.answers',$data->id).'">
                '.trans('student.answers').'
            </a>';
        }) 
        ->addColumn('mark',function($data){
            return $data->deliverHomeworks->sum('mark') . ' / <strong>' . $data->total_mark .'</strong>';
        })  
        ->rawColumns(['due_date','subject','file_name','deliver','mark','show_answers'])
        ->make(true);
    }

    public function homeworkAnswers($homework_id)
    {
        $homework = Homework::with('deliverHomeworks','questions')->where('id',$homework_id)->first();        
        
        $questions = Question::with('answers','matchings','userAnswers')
        ->where('homework_id',$homework_id)->orderBy('question_type')
        ->get(); 
        
        $title = trans('student.answers');
        
        $n = 1;
        return view('layouts.front-end.student.homeworks.show-answers',
        compact('title','homework','questions','n'));
    }    
}
