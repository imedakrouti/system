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
        $data = Lesson::with('subject','admin')->sort()->get();
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
                $division_name = '';
                foreach ($data->divisions as $division) {     
                    $sub = session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name;
                    $division_name .= '<div class="badge badge-primary mt-1">
                                            <span>'. $sub.'</span>
                                            <i class="la la-folder-o font-medium-3"></i>
                                        </div> ' ;
                }
                $grade_name = '';
                foreach ($data->grades as $grade) {     
                    $sub = session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name;
                    $grade_name .= '<div class="badge badge-danger">
                                        <span>'. $sub.'</span>
                                        <i class="la la-folder-o font-medium-3"></i>
                                    </div> ' ;
                }
                $arabic_name = $data->admin->employeeUser->ar_st_name .  ' ' .$data->admin->employeeUser->ar_nd_name .' '. $data->admin->employeeUser->ar_rd_name;
                $english_name = $data->admin->employeeUser->en_st_name .  ' ' .$data->admin->employeeUser->en_nd_name .' '. $data->admin->employeeUser->en_rd_name;

                $teacher_name = '(<span class="small">'.trans('learning::local.created_by').' ';
                $teacher_name .= session('lang') == 'ar' ? $arabic_name : $english_name .'</span>)';
                return '<a href="'.route('lessons.show',$data->id).'"><span><strong>'.$data->lesson_title.'</strong>  </span></a> '.$teacher_name.' </br>' .
                '<span class="small">'.$data->description.'</span><br>' . $division_name .$grade_name;
            })
            ->addColumn('visibility',function($data){
                return $data->visibility == 'show' ? '<a class="la la-eye btn btn-success white"></a>' : '<a class="la la-eye-slash btn btn-primary white"></a>';
            })
            ->addColumn('subject',function($data){
                return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
            })
                    
            ->addColumn('check', function($data){
                    $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->rawColumns(['check','lesson_title','subject','visibility'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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


}
