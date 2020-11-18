<?php

namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller; 

use Learning\Models\Learning\Playlist;
use Illuminate\Http\Request;
use Learning\Models\Learning\Lesson;
use Learning\Models\Settings\Subject;
use Staff\Models\Employees\Employee;

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
        $data = Playlist::with('subjects','employees')->orderBy('id','desc')->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::playlists.index',
        compact('title'));
    }
    private function dataTable($data)
    {
        return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('playlist_name',function($data){
                        return '<a href="'.route('playlists.show',$data->id).'"><span><strong>'.$data->playlist_name.'</strong></span></a> </br>' .
                        '<span class="primary small">'.$data->description.'</span>';
                    })
                    ->addColumn('attendance_id',function($data){
                        return $data->employees->attendance_id;
                    })
                    ->addColumn('employee_name',function($data){
                        return $this->getFullEmployeeName($data->employees);
                    }) 
                    ->addColumn('working_data',function($data){
                        return $this->workingData($data->employees);
                    }) 
                    ->addColumn('subjects',function($data){
                        return session('lang') == 'ar' ? $data->subjects->ar_name : $data->subjects->en_name;
                    })
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('playlists.edit',$data->id).'">
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


                    ->rawColumns(['action','check','subjects','attendance_id','employee_name','working_data','playlist_name'])
                    ->make(true);
    }
    private function getFullEmployeeName($data)
    {
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a href="'.route('playlists.employee',$data->id).'">' .$data->ar_st_name . ' ' . $data->ar_nd_name.
            ' ' . $data->ar_rd_name.' ' . $data->ar_th_name.'</a>';
        }else{
            $employee_name = '<a href="'.route('employees.show',$data->id).'">' .$data->en_st_name . ' ' . $data->en_nd_name.
            ' ' . $data->th_rd_name.' ' . $data->th_th_name.'</a>';
        }
        return $employee_name;
    }
    private function workingData($data)
    {
        $sector = '';
        if (!empty($data->sector->ar_sector)) {
            $sector = session('lang') == 'ar' ?  '<span class="blue">'.$data->sector->ar_sector . '</span>': '<span class="blue">'.$data->sector->en_sector . '</span>';            
        }
        $department = '';
        if (!empty($data->department->ar_department)) {
            $department = session('lang') == 'ar' ?  '<span class="purple">'.$data->department->ar_department . '</span>': '<span class="blue">'.$data->department->en_department . '</span>';            
        }
        $section = '';
        if (!empty($data->section->ar_section)) {
            $section = session('lang') == 'ar' ?  '<span class="red">'.$data->section->ar_section . '</span>': '<span class="blue">'.$data->section->en_section . '</span>';            
        }
        return $sector . ' '. $department . '<br>' .  $section ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $subjects = Subject::sort()->get();   
        $title = trans('learning::local.new_playlist');
        return view('learning::playlists.create',
        compact('title','subjects','employees'));
    }

    private function attributes()
    {
        return [
            'playlist_name',
            'subject_id',
            'employee_id',        
            'sort',                       
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
        request()->user()->playlists()->firstOrCreate(request()->only($this->attributes()));
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('playlists.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \Learning\Models\Learning\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        $lessons = Lesson::where('playlist_id',$playlist->id)->sort()->get();
        $title = trans('learning::local.playlists');
        return view('learning::playlists.show',
        compact('title','playlist','lessons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $subjects = Subject::sort()->get();   
        $title = trans('learning::local.edit_playlist');
        return view('learning::playlists.edit',
        compact('title','subjects','employees','playlist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\Playlist  $playlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $playlist->update(request()->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('playlists.index');
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
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Playlist::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function employee($employee_id)
    {
        $employee = Employee::findOrFail($employee_id);
        $employee_name = $this->getFullEmployeeName($employee);
        $playlists = Playlist::where('employee_id',$employee_id)->paginate(10);        
        $title = trans('learning::local.playlists');
        return view('learning::playlists.employee-playlists',
        compact('title','playlists','employee_name'));
    }
}
