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
 
}
