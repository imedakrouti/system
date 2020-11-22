<?php
namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\Playlist;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;
use Learning\Http\Requests\LessonRequest;
use Learning\Models\Learning\LessonFile;
use Student\Models\Settings\Classroom;
use DB;
use Illuminate\Http\Request;
use Learning\Models\Learning\Answer;
use Learning\Models\Learning\Exam;
use Learning\Models\Learning\Matching;
use Learning\Models\Learning\Question;

class TeacherController extends Controller
{
    // employee_id() : is helper function get employee id

    private $video_file_name;
    
    public function playlists()
    {        
        $playlists = Playlist::with('lessons','classes')->orderBy('id','desc')            
        ->where('employee_id',employee_id())
        ->get();
        
        $title = trans('learning::local.playlists');
        return view('learning::teacher.index',
        compact('title','playlists'));
    }
 
    public function storePlaylist()
    {        
        $playlist = request()->user()->playlists()->firstOrCreate([
            'playlist_name'     => request('playlist_name'),
            'subject_id'        => request('subject_id'),
            'employee_id'       => employee_id(),
            'sort'              => request('sort'),
        ]);
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('teacher.show-lessons',$playlist->id);
    }

    public function editPlaylist($playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $title = trans('learning::local.edit_playlist');
        return view('learning::teacher.edit-playlist',
        compact('title','playlist'));
    }

    public function updatePlaylist($playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $playlist->update([
            'playlist_name'     => request('playlist_name'),
            'subject_id'        => request('subject_id'),
            'employee_id'       => employee_id(),
            'sort'              => request('sort'),
        ]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('teacher.show-lessons',$playlist_id);
    }

    public function destroyPlaylist()
    {        
        if (request()->ajax()) {
            Playlist::destroy(request('playlist_id'));
        }
        return response(['status'=>true]);
    }

    public function showLessons($playlist_id)
    {
        $lessons = Lesson::where('playlist_id',$playlist_id)->paginate(10);
        $playlist = Playlist::findOrFail($playlist_id);
        $classes = Classroom::with('employees')->whereHas('employees',function($q){
            $q->where('employee_id',employee_id());
        })->get();
        // all classes related to teacher - get through playlist that related to teacher
        $arr_classes = [];
        foreach ($playlist->classes as $class) {
            $arr_classes []= $class->id;            
        } 
        
        $title = $playlist->playlist_name;
        $n = 1;
        return view('learning::teacher.show-lessons',
        compact('playlist','title','lessons','n','classes','arr_classes'));
    }

    public function newLesson($playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $title = $playlist->playlist_name;
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $years = Year::open()->current()->get();  
        return view('learning::teacher.new-lesson',
        compact('playlist','title','divisions','grades','years'));
    }

    private function attributes()
    {
        return [
            'subject_id',
            'lesson_title',
            'description',
            'explanation',
            'sort',
            'visibility',
            'approval',  
            'video_url',              
            'playlist_id',              
            'admin_id',
        ];
    }

    public function storeLesson(LessonRequest $request)
    {
        DB::transaction(function() use($request) {

            if (request()->hasFile('file_name'))
            {                           
                $image_path = '';                                        
                $this->video_file_name = uploadFileOrImage($image_path,request('file_name'),'images/lesson_attachments');                                             
            } 

            $this->lesson = $request->user()->lessons()->firstOrCreate($request->only($this->attributes())+
            ['file_name' => $this->video_file_name]);
            
            $_lessons = Lesson::find($this->lesson->id);
            foreach (request('division_id') as $division_id) {
                $_lessons->divisions()->attach($division_id);                        
            }
            foreach (request('grade_id') as $grade_id) {
                $_lessons->grades()->attach($grade_id);                        
            }
            foreach (request('year_id') as $year_id) {
                $_lessons->years()->attach($year_id);                        
            }

        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('teacher.show-lessons',request('playlist_id'));
    }

    public function viewLesson($lesson_id, $playlist_id)
    {
        $lessons = Lesson::where('playlist_id',$playlist_id)->sort()->get();        
        $lesson = Lesson::with('divisions','grades','years','files','playlist','admin')->where('id',$lesson_id)->first();          
        $title = $lesson->lesson_title;
        return view('learning::teacher.view-lesson',
        compact('lessons','lesson','title'));
    }

    public function editLesson($lesson_id)
    {
        $lesson = Lesson::with('divisions','grades','years','files','playlist','admin')->where('id',$lesson_id)->first();          
        $title = trans('learning::local.edit_lesson');
        $playlists = Playlist::with('lessons')->orderBy('id','desc')            
        ->where('employee_id',employee_id())
        ->get();
                
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $years = Year::open()->current()->get();  

        $arr_divisions = [];
        $arr_grades = [];
        $arr_years = [];
        
        foreach ($lesson->divisions as $division) {
            $arr_divisions []= $division->id;            
        }   
        foreach ($lesson->grades as $grade) {
            $arr_grades []= $grade->id;            
        }    
        foreach ($lesson->years as $year) {
            $arr_years []= $year->id;            
        } 
        return view('learning::teacher.edit-lesson',
        compact('playlists','title','divisions','grades','years','arr_divisions','arr_grades','arr_years','lesson'));
    }

    public function updateLesson(LessonRequest $request, $lesson_id)
    {
        $lesson_ = Lesson::findOrFail($lesson_id);
        DB::transaction(function() use($request,$lesson_id,$lesson_){
            
            if (request()->hasFile('file_name'))
            {     
                $image_path = '';      
                if (!empty($lesson_->file_name)) {
                    $image_path = public_path()."/images/lesson_attachments/".$lesson_->file_name;                                                                        
                }
                
                $this->video_file_name = uploadFileOrImage($image_path,request('file_name'),'images/lesson_attachments');                                                                             
                $lesson_->update($request->only($this->attributes())+['file_name' => $this->video_file_name]);
            } else{
                if (request()->has('remove_video')) {                
                    $image_path = public_path()."/images/lesson_attachments/".$lesson_->file_name; 
                    if(\File::exists($image_path)) {
                        \File::delete($image_path);                
                    }  
                    $this->video_file_name = null;
                    $lesson_->update($request->only($this->attributes())+['file_name' => $this->video_file_name]);
                } else{

                    $lesson_->update($request->only($this->attributes()));
                }
            }                      
            
            $_lessons = Lesson::findOrFail($lesson_id);
            DB::table('lesson_division')->where('lesson_id',$_lessons->id)->delete();
            
            foreach (request('division_id') as $division_id) {
                $_lessons->divisions()->attach($division_id);                        
            }

            DB::table('lesson_grade')->where('lesson_id',$_lessons->id)->delete();
            foreach (request('grade_id') as $grade_id) {
                $_lessons->grades()->attach($grade_id);                        
            }

            DB::table('lesson_year')->where('lesson_id',$_lessons->id)->delete();
            foreach (request('year_id') as $year_id) {
                $_lessons->years()->attach($year_id);                        
            }
        });
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('teacher.view-lesson',['id'=>$lesson_->id,'playlist_id' =>$lesson_->playlist_id]);
    }

    public function attachment()
    {   
        if (request()->hasFile('file_name'))
        {           
            $image_path = '';                                        
            $file_name = uploadFileOrImage($image_path,request('file_name'),'images/lesson_attachments'); 
            request()->user()->lessonFiles()->firstOrCreate([
                'lesson_id'     => request('lesson_id'),
                'title'         => request('title'),
                'file_name'     => $file_name
            ]);
            toast(trans('msg.stored_successfully'),'success');
        } 
        return redirect()->route('teacher.view-lesson',['id'=>request('lesson_id'),'playlist_id' =>request('playlist_id')]);
    }
    public function attachmentDestroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    $lesson = LessonFile::findOrFail($id); 
                    $image_path = public_path()."/images/lesson_attachments/".$lesson->file_name; 
                    if(\File::exists($image_path)) {
                        \File::delete($image_path);                
                    }  
                    LessonFile::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function approval()
    {        
        $lesson = Lesson::findOrFail(request('lesson_id'));
        $lesson->update([
            'approval' => request('approval')
        ]);
        toast(trans('learning::local.published_successfully'),'success');
        return redirect()->route('teacher.view-lesson',['id'=>request('lesson_id'),'playlist_id' =>request('playlist_id')]);
    }

    public function setClasses()
    {        
        $playlist = Playlist::find(request('playlist_id'));
        DB::table('playlist_classroom')->where('playlist_id',$playlist->id)->delete();
        foreach (request('classroom_id') as $classroom_id) {
            $playlist->classes()->attach($classroom_id);                        
        }
        toast(trans('learning::local.set_classes_successfully'),'success');
        return redirect()->route('teacher.show-lessons',request('playlist_id'));
    }

    public function viewLessons()
    {        
        $title = trans('learning::local.lessons');
        $data = Lesson::with('subject')->sort()->where('admin_id',authInfo()->id)->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::teacher.view-lessons',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('lesson_title',function($data){
                        return '<a href="'.route('teacher.view-lesson',['id'=>$data->id,'playlist_id'=>$data->playlist_id]).'"><span><strong>'.$data->lesson_title.'</strong></span></a> </br>' .
                        '<span class="primary small">'.$data->description.'</span>';
                    })
                    ->addColumn('visibility',function($data){
                        return $data->visibility == 'show' ? '<a class="la la-eye btn btn-success white"></a>' : '<a class="la la-eye-slash btn btn-danger white"></a>';
                    })
                    ->addColumn('approval',function($data){
                        return $data->approval == 'pending' ? '<a class="la la-hourglass btn btn-danger white"></a>' : '<a class="la la-check btn btn-success white"></a>';
                    })
                    ->addColumn('subject',function($data){
                        return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
                    })
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('teacher.edit-lessons',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })                              
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','lesson_title','subject','visibility','approval'])
                    ->make(true);
    }

    public function viewExams()
    {        
        $title = trans('learning::local.exams');
        $data = Exam::orderBy('start_date')->where('admin_id',authInfo()->id)->get();
        if (request()->ajax()) {
            return $this->examDataTable($data);
        }
        return view('learning::teacher.exams.view-exams',
        compact('title'));
    }
    private function examDataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('exam_name',function($data){
                return '<a href="'.route('teacher.show-exam',$data->id).'"><span><strong>'.$data->exam_name.'</strong></span></a> </br>' .
                '<span class="black small">'.$data->description.'</span>';
            })
            ->addColumn('action', function($data){
                    $btn = '<a class="btn btn-warning btn-sm" href="'.route('teacher.edit-exam',$data->id).'">
                    <i class=" la la-edit"></i>
                </a>';
                    return $btn;
            })  
            ->addColumn('show_questions', function($data){
                $btn = '<a class="btn btn-primary" href="'.route('teacher.show-exam',$data->id).'">
                    '.trans('learning::local.show_questions').'
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
            ->rawColumns(['action','check','start','end','exam_name','show_questions'])
            ->make(true);
    }

    public function newExam()
    {        
        $divisions = Division::sort()->get();     
        $grades = Grade::sort()->get();      
        $lessons = Lesson::with('subject')->where('admin_id',authInfo()->id)->orderBy('lesson_title')->get(); 
        $title = trans('learning::local.new_exam');
        return view('learning::teacher.exams.new-exam',
        compact('title','lessons','divisions','grades'));
    }

    private function examAttributes()
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

    public function storeExam(Request $request)
    {        
        DB::transaction(function() use ($request){
            $this->exam =  $request->user()->exams()->firstOrCreate(request()->only($this->examAttributes()));
            if (request()->has('lessons')) {
                DB::table('lesson_exam')->where('exam_id',$this->exam->id)->delete();
                
                foreach (request('lessons') as $lesson_id) {
                    $this->exam->lessons()->attach($lesson_id);                        
                }
            }
            DB::table('exam_division')->where('exam_id',$this->exam->id)->delete();
                
            foreach (request('divisions') as $division_id) {
                $this->exam->divisions()->attach($division_id);                        
            }

            DB::table('exam_grade')->where('exam_id',$this->exam->id)->delete();
                
            foreach (request('grades') as $grade_id) {
                $this->exam->grades()->attach($grade_id);                        
            }

            DB::table('exam_classroom')->where('exam_id',$this->exam->id)->delete();
                
            foreach (request('classrooms') as $classroom_id) {
                $this->exam->classrooms()->attach($classroom_id);                        
            }
        });      
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('teacher.show-exam',$this->exam->id);
    }

    public function showExam($exam_id)
    {
        $exam = Exam::with('subjects','classrooms')->where('admin_id',authInfo()->id)->where('id',$exam_id)->first();        
        $questions = Question::with('answers','matchings')->where('exam_id',$exam_id)->orderBy('question_type')
        ->get();    
        $questions = $questions->shuffle();   
        
        $title = trans('learning::local.exams');
        $n = 1;
        $classes = Classroom::with('employees')->whereHas('employees',function($q){
            $q->where('employee_id',employee_id());
        })->get();
        // all classes related to teacher - get through playlist that related to teacher
        $arr_classes = [];
        foreach ($exam->classrooms as $class) {
            $arr_classes []= $class->id;            
        } 
        return view('learning::teacher.exams.show-exam',
        compact('title','exam','questions','n','classes','arr_classes'));
    }

    public function editExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        $divisions = Division::sort()->get();     
        $grades = Grade::sort()->get();      
        $lessons = Lesson::with('subject')->orderBy('lesson_title')->get();   
        $title = trans('learning::local.edit_exam');
        $arr_lessons = [];
        $arr_divisions = [];
        $arr_grades = [];

        foreach ($exam->lessons as $lesson) {
            $arr_lessons []= $lesson->id;            
        } 
        foreach ($exam->divisions as $division) {
            $arr_divisions []= $division->id;            
        }   
        foreach ($exam->grades as $grade) {
            $arr_grades []= $grade->id;            
        }   

        return view('learning::teacher.exams.edit-exam',
        compact('title','exam','lessons','arr_lessons','divisions',
        'grades','arr_divisions','arr_grades'));
    }

    public function updateExam($exam_id)
    {
        $exam = Exam::findOrFail($exam_id);
        DB::transaction(function() use ($exam){
            $exam->update(request()->only($this->examAttributes()));

            DB::table('lesson_exam')->where('exam_id',$exam->id)->delete();
            if (request()->has('lessons')) {            
                foreach (request('lessons') as $lesson_id) {
                    $exam->lessons()->attach($lesson_id);                        
                }
            }

            // DB::table('exam_division')->where('exam_id',$exam->id)->delete();                   
            // foreach (request('divisions') as $division_id) {
            //     $exam->divisions()->attach($division_id);                        
            // }
    
            // DB::table('exam_grade')->where('exam_id',$exam->id)->delete();
                
            // foreach (request('grades') as $grade_id) {
            //     $exam->grades()->attach($grade_id);                        
            // }          
        });
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('teacher.view-exams');
    }

    private function questionAttributes()
    {
        return [
            'question_type',
            'question_text',
            'mark',        
            'exam_id',                       
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
        return redirect()->route('teacher.show-exam',request('exam_id'));
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

    public function preview($exam_id)
    {
        $exam = Exam::with('subjects','divisions','grades')->where('id',$exam_id)->first();            
        $questions = Question::with('answers','matchings')->where('exam_id',$exam->id)->orderBy('question_type')
        ->get();    
        $questions = $questions->shuffle();   
                
        $n = 1;
        $title = trans('learning::local.preview_exam');
        return view('learning::teacher.exams.preview',
        compact('title','exam','questions','n'));
    }

    public function setExamClasses()
    {
        $exam = Exam::find(request('exam_id'));
        DB::table('exam_classroom')->where('exam_id',$exam->id)->delete();
        foreach (request('classroom_id') as $classroom_id) {
            $exam->classrooms()->attach($classroom_id);                        
        }
        toast(trans('learning::local.set_classes_successfully'),'success');
        return redirect()->route('teacher.show-exam',request('exam_id'));
    }
 
}
