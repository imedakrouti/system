<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Lesson;
use Learning\Http\Requests\LessonRequest;
use Learning\Models\Settings\Subject;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;
use Learning\Models\Learning\LessonFile;
use Learning\Models\Learning\Playlist;
use DB;

class LessonController extends Controller
{
    private $lesson;
    private $video_file_name;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $title = trans('learning::local.lessons');
        $data = Lesson::with('subject')->sort()->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::lessons.admin.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('lesson_title',function($data){
                        return '<a href="'.route('lessons.show',$data->id).'"><span><strong>'.$data->lesson_title.'</strong></span></a> </br>' .
                        '<span class="primary small">'.$data->description.'</span>';
                    })
                    ->addColumn('visibility',function($data){
                        return $data->visibility == 'show' ? '<a class="la la-eye btn btn-success white"></a>' : '<a class="la la-eye-slash btn btn-primary white"></a>';
                    })
                    ->addColumn('approval',function($data){
                        return $data->approval == 'pending' ? '<a class="la la-hourglass btn btn-primary white"></a>' : '<a class="la la-check btn btn-success white"></a>';
                    })
                    ->addColumn('subject',function($data){
                        return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
                    })
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('lessons.edit',$data->id).'">
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
                    ->addColumn('division',function($data){
                        $division_name = '';
                        foreach ($data->divisions as $division) {     
                            $sub = session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name;
                            $division_name .= '<div class="badge badge-info">
                                                    <span>'. $sub.'</span>
                                                    <i class="la la-folder-o font-medium-3"></i>
                                                </div> ' ;
                        }
                        return $division_name;
                    })
                    ->addColumn('grade',function($data){
                        $grade_name = '';
                        foreach ($data->grades as $grade) {     
                            $sub = session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name;
                            $grade_name .= '<div class="badge badge-danger">
                                                <span>'. $sub.'</span>
                                                <i class="la la-folder-o font-medium-3"></i>
                                            </div> ' ;
                        }
                        return $grade_name;
                    })
                    ->rawColumns(['action','check','division','grade','lesson_title','subject','visibility','approval'])
                    ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        $playlists = Playlist::all();
        $divisions = Division::sort()->get();     
        $grades = Grade::sort()->get();     
        $years = Year::open()->current()->get();     
        $subjects = Subject::sort()->get();   
        $title = trans('learning::local.new_lesson');
        return view('learning::lessons.admin.create',
        compact('title','subjects','divisions','grades','years','playlists'));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LessonRequest $request)
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
        return redirect()->route('lessons.show',$this->lesson->id);

    }

    /**
     * Display the specified resource.
     *
     * @param  \Learning\Models\Learning\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {        
        $lessons = Lesson::where('playlist_id',$lesson->playlist_id)->sort()->get();
        $title = trans('learning::local.lessons');   
        $lesson = Lesson::with('divisions','grades','years','files','playlist','admin')->where('id',$lesson->id)->first();          
        return view('learning::lessons.admin.show',
        compact('lesson','title','lessons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        $playlists = Playlist::all();
        $lesson = Lesson::with('divisions','grades','years')->where('id',$lesson->id)->first();        
        $divisions = Division::sort()->get();     
        $grades = Grade::sort()->get();     
        $years = Year::open()->current()->get();  
        $subjects = Subject::sort()->get();   
        $title = trans('learning::local.edit_lesson');

        $arr_lessons = [];
        
        foreach ($lesson->divisions as $division) {
            $arr_divisions []= $division->id;            
        }   
        foreach ($lesson->grades as $grade) {
            $arr_grades []= $grade->id;            
        }    
        foreach ($lesson->years as $year) {
            $arr_years []= $year->id;            
        }         
        return view('learning::lessons.admin.edit',
        compact('title','lesson','subjects','divisions','grades','years','playlists','arr_divisions','arr_grades','arr_years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(LessonRequest $request, Lesson $lesson)
    {
        DB::transaction(function() use($request,$lesson){
            $lesson_ = Lesson::findOrFail($lesson->id);
            if (request()->hasFile('file_name'))
            {     
                $image_path = '';      
                if (!empty($lesson_->file_name)) {
                    $image_path = public_path()."/images/lesson_attachments/".$lesson_->file_name;                                                                        
                }
                
                $this->video_file_name = uploadFileOrImage($image_path,request('file_name'),'images/lesson_attachments');                                                                             
                $lesson->update($request->only($this->attributes())+['file_name' => $this->video_file_name]);
            } else{
                if (request()->has('remove_video')) {                
                    $image_path = public_path()."/images/lesson_attachments/".$lesson_->file_name; 
                    if(\File::exists($image_path)) {
                        \File::delete($image_path);                
                    }  
                    $this->video_file_name = null;
                    $lesson->update($request->only($this->attributes())+['file_name' => $this->video_file_name]);
                } else{

                    $lesson->update($request->only($this->attributes()));
                }
            }                      
            
            $_lessons = Lesson::find($lesson->id);
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
        return redirect()->route('lessons.show',$lesson->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Lesson::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
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
        return redirect()->route('lessons.show',request('lesson_id'));
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
        return redirect()->route('lessons.show',request('lesson_id'));
    }

}
