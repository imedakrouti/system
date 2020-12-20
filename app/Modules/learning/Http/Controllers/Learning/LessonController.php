<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use Learning\Models\Learning\Lesson;
use DB;
use Learning\Http\Requests\LessonRequest;
use Learning\Models\Learning\LessonUser;
use Learning\Models\Learning\Playlist;
use Student\Models\Settings\Division;
use Student\Models\Settings\Grade;
use Student\Models\Settings\Year;
use Student\Models\Students\Student;

class LessonController extends Controller
{
    private $video_file_name;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('learning::local.lessons');
        $data = Lesson::with('subject', 'admin')->sort()->get();
        if (request()->ajax()) {
            return $this->dataTables($data);
        }
        return view(
            'learning::lessons.admin.index',
            compact('title')
        );
    }

    private function dataTables($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('lesson_title', function ($data) {
                $division_name = '';
                foreach ($data->divisions as $division) {
                    $sub = session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name;
                    $division_name .= '<div class="badge badge-primary mt-1">
                                            <span>' . $sub . '</span>
                                            <i class="la la-folder-o font-medium-3"></i>
                                        </div> ';
                }
                $grade_name = '';
                foreach ($data->grades as $grade) {
                    $sub = session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name;
                    $grade_name .= '<div class="badge badge-danger">
                                        <span>' . $sub . '</span>
                                        <i class="la la-folder-o font-medium-3"></i>
                                    </div> ';
                }
                $arabic_name = $data->admin->employeeUser->ar_st_name .  ' ' . $data->admin->employeeUser->ar_nd_name . ' ' . $data->admin->employeeUser->ar_rd_name;
                $english_name = $data->admin->employeeUser->en_st_name .  ' ' . $data->admin->employeeUser->en_nd_name . ' ' . $data->admin->employeeUser->en_rd_name;

                $teacher_name = '(<span class="small">' . trans('learning::local.created_by') . ' ';
                $teacher_name .= session('lang') == 'ar' ? $arabic_name : $english_name . '</span>)';
                return '<a href="' . route('lessons.show', $data->id) . '"><span><strong>' . $data->lesson_title . '</strong>  </span></a> ' . $teacher_name . ' </br>' .
                    '<span class="small">' . $data->description . '</span><br>' . $division_name . $grade_name;
            })
            ->addColumn('visibility', function ($data) {
                return $data->visibility == 'show' ? '<a class="la la-eye btn btn-success white"></a>' : '<a class="la la-eye-slash btn btn-primary white"></a>';
            })
            ->addColumn('subject', function ($data) {
                return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
            })

            ->addColumn('check', function ($data) {
                $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                <span class="lbl"></span>
                            </label>';
                return $btnCheck;
            })
            ->rawColumns(['check', 'lesson_title', 'subject', 'visibility'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Learning\Models\Learning\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson)
    {
        $lessons = Lesson::where('playlist_id', $lesson->playlist_id)->sort()->get();
        $title = trans('learning::local.lessons');
        $lesson = Lesson::with('divisions', 'grades', 'years', 'files', 'playlist', 'admin')->where('id', $lesson->id)->first();
        return view(
            'learning::lessons.admin.show',
            compact('lesson', 'title', 'lessons')
        );
    }

    public function destroy(Lesson $lesson)
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {
                    Lesson::destroy($id);
                }
            }
        }
        return response(['status' => true]);
    }

    public function newLesson($playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $title = $playlist->playlist_name;
        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        return view(
            'learning::teacher.lessons.new-lesson',
            compact('playlist', 'title', 'divisions', 'grades')
        );
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
        DB::transaction(function () use ($request) {

            if (request()->hasFile('file_name')) {
                $image_path = '';
                $this->video_file_name = uploadFileOrImage($image_path, request('file_name'), 'images/lesson_attachments');
            }

            $this->lesson = $request->user()->lessons()->firstOrCreate($request->only($this->attributes()) +
                ['file_name' => $this->video_file_name]);
                
            $this->lesson->divisions()->attach(request('division_id'));
            $this->lesson->grades()->attach(request('grade_id'));        
            $this->lesson->years()->attach(currentYear());
        });
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('teacher.view-lesson', ['id' => $this->lesson->id, 'playlist_id' => request('playlist_id')]);
    }

    public function viewLesson($lesson_id, $playlist_id)
    {
        $lessons = Lesson::where('playlist_id', $playlist_id)->sort()->get();
        $lesson = Lesson::with('divisions', 'grades', 'years', 'files', 'playlist', 'admin')->where('id', $lesson_id)->first();
        $title = $lesson->lesson_title;
        return view(
            'learning::teacher.lessons.view-lesson',
            compact('lessons', 'lesson', 'title')
        );
    }

    public function editLesson($lesson_id)
    {
        $lesson = Lesson::with('divisions', 'grades', 'years', 'files', 'playlist', 'admin')->where('id', $lesson_id)->first();
        $title = trans('learning::local.edit_lesson');
        $playlists = Playlist::with('lessons')->orderBy('id', 'desc')
            ->where('employee_id', employee_id())
            ->get();

        $divisions = Division::sort()->get();
        $grades = Grade::sort()->get();
        $years = Year::open()->current()->get();

        return view(
            'learning::teacher.lessons.edit-lesson',
            compact('playlists', 'title', 'divisions', 'grades', 'years', 'lesson')
        );
    }

    public function updateLesson(LessonRequest $request, $lesson_id)
    {
        $lesson_ = Lesson::findOrFail($lesson_id);
        DB::transaction(function () use ($request, $lesson_id, $lesson_) {

            if (request()->hasFile('file_name')) {
                $image_path = '';
                if (!empty($lesson_->file_name)) {
                    $image_path = public_path() . "/images/lesson_attachments/" . $lesson_->file_name;
                }

                $this->video_file_name = uploadFileOrImage($image_path, request('file_name'), 'images/lesson_attachments');
                $lesson_->update($request->only($this->attributes()) + ['file_name' => $this->video_file_name]);
            } else {
                if (request()->has('remove_video')) {
                    $image_path = public_path() . "/images/lesson_attachments/" . $lesson_->file_name;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    $this->video_file_name = null;
                    $lesson_->update($request->only($this->attributes()) + ['file_name' => $this->video_file_name]);
                } else {

                    $lesson_->update($request->only($this->attributes()));
                }
            }

            $lesson_->divisions()->sync(request('division_id'));
            $lesson_->grades()->sync(request('grade_id'));      
        });
        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('teacher.view-lesson', ['id' => $lesson_->id, 'playlist_id' => $lesson_->playlist_id]);
    }

    public function attachment()
    {
        if (request()->hasFile('file_name')) {
            $image_path = '';
            $file_name = uploadFileOrImage($image_path, request('file_name'), 'images/lesson_attachments');
            request()->user()->lessonFiles()->firstOrCreate([
                'lesson_id'     => request('lesson_id'),
                'title'         => request('title'),
                'file_name'     => $file_name
            ]);
            toast(trans('msg.stored_successfully'), 'success');
        }
        return redirect()->route('teacher.view-lesson', ['id' => request('lesson_id'), 'playlist_id' => request('playlist_id')]);
    }
    public function attachmentDestroy()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {
                    $lesson = LessonFile::findOrFail($id);
                    $image_path = public_path() . "/images/lesson_attachments/" . $lesson->file_name;
                    if (\File::exists($image_path)) {
                        \File::delete($image_path);
                    }
                    LessonFile::destroy($id);
                }
            }
        }
        return response(['status' => true]);
    }

    public function approval()
    {
        $msg = '';
        $lesson = Lesson::findOrFail(request('lesson_id'));
        $lesson->update([
            'approval' => request('approval')
        ]);

        $msg = trans('learning::local.pending_mode');
        if (request('approval') == 'accepted') {
            // publish
            $url = $lesson->id . "," . $lesson->playlist_id;
            foreach ($lesson->playlist->classes as $classroom) {

                request()->user()->posts()->create(
                    [
                        'post_type'     => 'lesson',
                        'url'           => $url,
                        'classroom_id'  => $classroom->id,
                        'post_text'     => $lesson->lesson_title,
                        'youtube_url'   => $lesson->video_url,
                        'description'   => $lesson->description,
                    ]
                );
            }
            $msg = trans('learning::local.published_successfully');
        }
        toast($msg, 'success');
        return redirect()->route('teacher.view-lesson', ['id' => request('lesson_id'), 'playlist_id' => request('playlist_id')]);
    }

    public function viewLessons()
    {
        $title = trans('learning::local.lessons');
        $data = Lesson::with('subject')->sort()->where('admin_id', authInfo()->id)->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view(
            'learning::teacher.lessons.view-lessons',
            compact('title')
        );
    }
    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('lesson_title', function ($data) {
                return '<a href="' . route('teacher.view-lesson', ['id' => $data->id, 'playlist_id' => $data->playlist_id]) . '"><span><strong>' . $data->lesson_title . '</strong></span></a> </br>' .
                    '<span class="">' . $data->description . '</span>';
            })
            ->addColumn('visibility', function ($data) {
                return $data->visibility == 'show' ? '<a class="la la-eye btn-sm btn btn-success white"></a>' : '<a class="la la-eye-slash btn-sm btn btn-danger white"></a>';
            })
            ->addColumn('approval', function ($data) {
                return $data->approval == 'pending' ? '<a class="la la-hourglass btn-sm btn btn-danger white"></a>' : '<a class="la la-check btn-sm btn btn-success white"></a>';
            })
            ->addColumn('subject', function ($data) {
                return session('lang') == 'ar' ? $data->subject->ar_name : $data->subject->en_name;
            })
            ->addColumn('action', function ($data) {
                $btn = '<a class="btn btn-warning btn-sm" href="' . route('teacher.edit-lessons', $data->id) . '">
                           <i class=" la la-edit"></i>
                       </a>';
                return $btn;
            })
            ->addColumn('check', function ($data) {
                $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                        <span class="lbl"></span>
                                    </label>';
                return $btnCheck;
            })
            ->rawColumns(['action', 'check', 'lesson_title', 'subject', 'visibility', 'approval'])
            ->make(true);
    }
    public function studentViews($lesson_id)
    {
        $lesson = Lesson::findOrFail($lesson_id);
        // students seen lesson
        $students_seen = LessonUser::where('lesson_id', $lesson_id)->orderBy('created_at', 'desc')->get();
        $users = [];
        foreach ($students_seen as $student) {
            $users[] = $student->user_id;
        }
        $seen = Student::whereIn('user_id', $users)->get();

        // students not seen lesson
        $classrooms = [];
        foreach ($lesson->playlist->classes as $classroom) {
            $classrooms[] = $classroom->id;
        }
        $not_seen = Student::with('rooms')->whereNotIn('user_id', $users)
            ->whereHas('rooms', function ($query) use ($classrooms) {
                $query->whereIn('classroom_id', $classrooms);
            })
            ->orderBy('ar_student_name')
            ->get();

        $title  = trans('learning::local.views');

        return view(
            'learning::teacher.lessons.student-views',
            compact('title', 'lesson', 'seen', 'not_seen')
        );
    }
}
