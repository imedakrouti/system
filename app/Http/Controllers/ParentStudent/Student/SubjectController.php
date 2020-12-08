<?php
namespace App\Http\Controllers\ParentStudent\Student;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\Lesson;
use Learning\Models\Learning\LessonUser;
use Learning\Models\Learning\Playlist;
use Staff\Models\Employees\Employee;
use DB;

class SubjectController extends Controller
{
    public function viewLesson($lesson_id, $playlist_id)
    {
        $lessons = Lesson::where('playlist_id',$playlist_id)->sort()->get();        
        $lesson = Lesson::with('divisions','grades','years','files','playlist','admin')
        ->where('id',$lesson_id)->first();          
        $title = $lesson->lesson_title;
        // set view count
        $this->lessonViews($lesson, $lesson->views);
        return view('layouts.front-end.student.view-lesson',
        compact('lessons','lesson','title'));
    }

    private function lessonViews($lesson, $views)
    {
        DB::transaction(function() use($lesson, $views){
            $checkView = LessonUser::where('lesson_id',$lesson->id)
            ->where('user_id',userAuthInfo()->id)->first();
            if (empty($checkView)) {
                $lesson->update(['views'=>$views+1]);
            }
            request()->user()->lessonUser()->firstOrCreate(['lesson_id'=>$lesson->id]);
        });
    }

    public function subjects()
    {
        $title = trans('student.subjects');
        $subjects = studentSubjects();          
        return view('layouts.front-end.student.subjects.view-subjects',
        compact('subjects','title'));
    }

    public function playlists($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $playlists = Playlist::where('employee_id',$employee_id)->sort()->get();        
        $title = trans('student.playlists');
        return view('layouts.front-end.student.subjects.view-playlists',
        compact('playlists','title','employee'));
    }

    public function showLessons($playlist_id)
    {
        $lessons = Lesson::where('playlist_id',$playlist_id)->paginate(10);
        $playlist = Playlist::findOrFail($playlist_id);
        
        $title = $playlist->playlist_name;
        $n = 1;
        return view('layouts.front-end.student.subjects.show-lessons',
        compact('playlist','title','lessons','n'));
    }    
}
