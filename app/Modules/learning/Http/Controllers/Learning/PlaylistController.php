<?php

namespace Learning\Http\Controllers\Learning;

use App\Http\Controllers\Controller;

use Learning\Models\Learning\Playlist;
use Learning\Models\Learning\Lesson;
use Staff\Models\Employees\Employee;
use Student\Models\Settings\Classroom;

use DB;
use Learning\Http\Requests\PlaylistRequest;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('learning::local.playlists');
        $data = Playlist::with('subjects', 'employees')->orderBy('id', 'desc')->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view(
            'learning::playlists.index',
            compact('title')
        );
    }

    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('playlist_name', function ($data) {
                return '<a href="' . route('playlists.show', $data->id) . '"><span><strong>' . $data->playlist_name . '</strong></span></a> </br>' .
                    '<span class="primary small">' . $data->description . '</span>';
            })
            ->addColumn('attendance_id', function ($data) {
                return $data->employees->attendance_id;
            })
            ->addColumn('employee_name', function ($data) {
                return $this->getFullEmployeeName($data->employees);
            })
            ->addColumn('working_data', function ($data) {
                return $this->workingData($data->employees);
            })
            ->addColumn('subjects', function ($data) {
                return session('lang') == 'ar' ? $data->subjects->ar_name : $data->subjects->en_name;
            })
            ->addColumn('check', function ($data) {
                $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="' . $data->id . '" />
                                        <span class="lbl"></span>
                                    </label>';
                return $btnCheck;
            })


            ->rawColumns(['check', 'subjects', 'attendance_id', 'employee_name', 'working_data', 'playlist_name'])
            ->make(true);
    }

    private function getFullEmployeeName($data)
    {
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a href="' . route('playlists.employee', $data->id) . '">' . $data->ar_st_name . ' ' . $data->ar_nd_name .
                ' ' . $data->ar_rd_name . ' ' . $data->ar_th_name . '</a>';
        } else {
            $employee_name = '<a href="' . route('employees.show', $data->id) . '">' . $data->en_st_name . ' ' . $data->en_nd_name .
                ' ' . $data->th_rd_name . ' ' . $data->th_th_name . '</a>';
        }
        return $employee_name;
    }

    private function workingData($data)
    {
        $sector = '';
        if (!empty($data->sector->ar_sector)) {
            $sector = session('lang') == 'ar' ?  '<span class="primary">' . $data->sector->ar_sector . '</span>' : '<span class="primary">' . $data->sector->en_sector . '</span>';
        }
        $department = '';
        if (!empty($data->department->ar_department)) {
            $department = session('lang') == 'ar' ?  '<span class="purple">' . $data->department->ar_department . '</span>' : '<span class="purple">' . $data->department->en_department . '</span>';
        }
        $section = '';
        if (!empty($data->section->ar_section)) {
            $section = session('lang') == 'ar' ?  '<span class="red">' . $data->section->ar_section . '</span>' : '<span class="red">' . $data->section->en_section . '</span>';
        }
        return $sector . ' ' . $department . '<br>' .  $section;
    }

    public function show(Playlist $playlist)
    {
        $lessons = Lesson::where('playlist_id', $playlist->id)->sort()->paginate(10);
        $title = trans('learning::local.playlists');
        return view(
            'learning::playlists.show',
            compact('title', 'playlist', 'lessons')
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id')) {
                foreach (request('id') as $id) {
                    Playlist::destroy($id);
                }
            }
        }
        return response(['status' => true]);
    }

    public function employee($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee_name = $this->getFullEmployeeName($employee);
        $playlists = Playlist::where('employee_id', $employee_id)->paginate(10);
        $title = trans('learning::local.playlists');
        return view(
            'learning::playlists.employee-playlists',
            compact('title', 'playlists', 'employee_name')
        );
    }

    // for teachers

    public function playlists()
    {
        $playlists = Playlist::with('lessons', 'classes')->orderBy('id', 'desc')
            ->where('employee_id', employee_id())
            ->get();

        $title = trans('learning::local.playlists');
        return view(
            'learning::teacher.playlists.index',
            compact('title', 'playlists')
        );
    }

    public function storePlaylist(PlaylistRequest $request)
    {
        $playlist = $request->user()->playlists()->firstOrCreate([
            'playlist_name'     => $request->playlist_name,
            'subject_id'        => $request->subject_id,
            'sort'              => $request->sort,
            'employee_id'       => employee_id(),
        ]);
        toast(trans('msg.stored_successfully'), 'success');
        return redirect()->route('teacher.show-lessons', $playlist->id);
    }

    public function editPlaylist($playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $title = trans('learning::local.edit_playlist');
        return view(
            'learning::teacher.playlists.edit-playlist',
            compact('title', 'playlist')
        );
    }

    public function updatePlaylist(PlaylistRequest $request, $playlist_id)
    {
        $playlist = Playlist::findOrFail($playlist_id);
        $playlist->update([
            'playlist_name'     => $request->playlist_name,
            'subject_id'        => $request->subject_id,
            'sort'              => $request->sort,
            'employee_id'       => employee_id(),
        ]);
        toast(trans('msg.updated_successfully'), 'success');
        return redirect()->route('teacher.show-lessons', $playlist_id);
    }

    public function destroyPlaylist()
    {
        if (request()->ajax()) {
            Playlist::destroy(request('playlist_id'));
        }
        return response(['status' => true]);
    }

    public function showLessons($playlist_id)
    {
        $lessons = Lesson::where('playlist_id', $playlist_id)->paginate(10);
        $playlist = Playlist::findOrFail($playlist_id);
        $classes = Classroom::with('employees')->whereHas('employees', function ($q) {
            $q->where('employee_id', employee_id());
        })->get();
        // all classes related to teacher - get through playlist that related to teacher
        $arr_classes = [];
        foreach ($playlist->classes as $class) {
            $arr_classes[] = $class->id;
        }

        $title = $playlist->playlist_name;
        $n = 1;
        return view(
            'learning::teacher.playlists.show-lessons',
            compact('playlist', 'title', 'lessons', 'n', 'classes', 'arr_classes')
        );
    }



    public function setClasses()
    {
        $playlist = Playlist::find(request('playlist_id'));
        DB::table('playlist_classroom')->where('playlist_id', $playlist->id)->delete();
        foreach (request('classroom_id') as $classroom_id) {
            $playlist->classes()->attach($classroom_id);
        }
        toast(trans('learning::local.set_classes_successfully'), 'success');
        return redirect()->route('teacher.show-lessons', request('playlist_id'));
    }
}
