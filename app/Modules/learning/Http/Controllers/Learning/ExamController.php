<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller;

use Learning\Models\Learning\Exam;
use Illuminate\Http\Request;
use Learning\Models\Learning\Question;
use Learning\Models\Settings\Subject;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $title = trans('learning::local.exams');
        $data = Exam::orderBy('start_date')->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::exams.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name',function($data){
                return '<a href="'.route('exams.show',$data->id).'"><span><strong>'.$data->exam_name.'</strong></span></a> </br>' .
                '<span class="black small">'.$data->description.'</span>';
            })
            ->addColumn('action', function($data){
                    $btn = '<a class="btn btn-warning btn-sm" href="'.route('exams.edit',$data->id).'">
                    <i class=" la la-edit"></i>
                </a>';
                    return $btn;
            })  
            ->addColumn('start',function($data){
                return '<span class="blue">'.$data->start_date.'</span>' . ' - ' . $data->start_time;
            })  
            ->addColumn('end',function($data){
                return '<span class="red">'.$data->end_date.'</span>' . ' - ' . $data->end_time;
            })                            
            ->addColumn('check', function($data){
                    $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->rawColumns(['action','check','start','end','exam_name'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {          
        $subjects = Subject::sort()->get();    
        $title = trans('learning::local.new_exam');
        return view('learning::exams.create',
        compact('title','subjects'));
    }

    private function attributes()
    {
        return [
            'exam_name',
            'start_date',
            'start_time',
            'end_date',
            'end_time',
            'duration',
            'total_mark',                
            'no_question_per_page',                
            'description',   
            'subject_id',       
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
        $exam =  $request->user()->exams()->firstOrCreate(request()->only($this->attributes()));
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('exams.show',$exam->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function show(Exam $exam)
    {        
        $exam = Exam::with('subjects')->where('id',$exam->id)->first();        
        $questions = Question::with('answers','matchings')->where('exam_id',$exam->id)->orderBy('question_type')
        ->get();    
        $questions = $questions->shuffle();    
        $title = trans('learning::local.exams');
        return view('learning::exams.show',
        compact('title','exam','questions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function edit(Exam $exam)
    {
        $title = trans('learning::local.edit_exam');
        return view('learning::exams.edit',
        compact('title','exam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Exam $exam)
    {
        $exam->update(request()->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('exams.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Exam  $exam
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Exam::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
