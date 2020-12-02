<?php
namespace Learning\Http\Controllers\Learning;
use App\Http\Controllers\Controller;
use Learning\Models\Learning\ZoomSchedule;
use Carbon\Carbon;

class ZoomScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(date_format(\Carbon\Carbon::now(),"Y/m/d"));
        // dd(date_format(\Carbon\Carbon::now(),"h:i a"));
        $title = trans('learning::local.manage_zoom_schedule');
        $data = ZoomSchedule::with('classroom')->orderBy('start_date','desc')->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        return view('learning::teacher.virtual-classrooms.zoom-schedules.index',
        compact('title'));
    }

    private function dataTable($data)
    {
        return datatables($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                    $btn = '<a class="btn btn-warning btn-sm" href="'.route('zoom-schedules.edit',$data->id).'">
                    <i class=" la la-edit"></i>
                </a>';
                    return $btn;
            })  
            ->addColumn('start_class', function($data){
                $time = new Carbon( $data->start_time);
                // dd( date_format($time,"H:i") > date_format(\Carbon\Carbon::now(),"H:i"));
                $btn = '';

                // hidden before date & time
                if($data->start_date >= date_format(\Carbon\Carbon::now(),"Y-m-d")){
                        $btn = '<span class="blue"><strong>'.trans('learning::local.not_yet').'</strong></span>';
                }    

                // today
                if ($data->start_date <= date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                    date_format($time->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")) {
                    $btn = '<a target="_blank" href="'.route('zoom.live').'" class="btn btn-primary btn-sm" href="'.route('teacher.show-exam',$data->id).'">
                                <i class=" la la-video-camera"></i>   
                            </a>';
                }
                if($data->start_date < date_format(\Carbon\Carbon::now(),"Y-m-d")){
                    $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
                }
                            
                // hidden after date & time
                
                $time = $time->addMinutes(45);
                
                if($data->start_date == date_format(\Carbon\Carbon::now(),"Y-m-d") && 
                    date_format($time,"H:i") < date_format(\Carbon\Carbon::now(),"H:i")){
                    $btn = '<span class="red"><strong>'.trans('learning::local.finished').'</strong></span>';
                } 
                
                return $btn;
            }) 
            ->addColumn('start_date',function($data){
                return '<span class="blue">'.\Carbon\Carbon::parse( $data->start_date)->format('M d Y').'<br>
                '.\Carbon\Carbon::parse( $data->start_time)->format('h:i a').'
                </span>';
            })  
            ->addColumn('classroom',function($data){
                return session('lang') == 'ar' ? $data->classroom->ar_name_classroom : $data->classroom->en_name_classroom;
            })                                     
            ->addColumn('check', function($data){
                    $btnCheck = '<label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                <span class="lbl"></span>
                            </label>';
                    return $btnCheck;
            })
            ->rawColumns(['action','check','start_date','start_class','classroom'])
            ->make(true);
    }

    public function viewZoomSchedule()
    {
        if (request()->ajax()) {
            $classrooms = [];
            foreach (employeeClassrooms() as $classroom) {
                $classrooms[] = $classroom->id;
            }
            $data = [];
            $schedule = ZoomSchedule::with('classroom')
            ->whereHas('classroom',function($q) use ($classrooms){
                $q->whereIn('classroom_id',$classrooms);
            })
            ->get();

            foreach ($schedule as  $day) {
        
                $date = Carbon::parse($day->start_date)->format('Y-m-d');
                $time = Carbon::parse($day->start_time)->format('H:i:s');
                $startDateTime = $date.'T'.$time.'Z';
     
                $data[] = array(
                    'id'        => $day->id,
                    'title'     => $day->classroom->en_name_classroom,
                    'start'     => $startDateTime,
                    'end'       => $startDateTime,
                    'color'     => $this->color($day->start_date,$day->start_time)
                   );
            }
            return json_encode($data);
        }
        return view('learning::teacher.virtual-classrooms.zoom-schedules.view-schedule',
        ['title'=>trans('learning::local.view_zoom_schedule')]);
    }

    private function color($date, $time)
    {
        $time = new Carbon( $time);
                
        $color = '';
        // today
        // hidden before date & time
        if($date >= date_format(\Carbon\Carbon::now(),"Y-m-d")){
                $color = 'blue';
        }    

        // today
        if ($date <= date_format(\Carbon\Carbon::now(),"Y-m-d") && 
            date_format($time->subMinutes(1),"H:i") < date_format(\Carbon\Carbon::now(),"H:i")) {
            $color = 'green';
        }
        if($date < date_format(\Carbon\Carbon::now(),"Y-m-d")){
            $color = 'red';
        }
                    
        // hidden after date & time
        
        $time = $time->addMinutes(45);
        
        if($date == date_format(\Carbon\Carbon::now(),"Y-m-d") && 
            date_format($time,"H:i") < date_format(\Carbon\Carbon::now(),"H:i")){
            $color = 'red';
        } 

        return $color;        
    }

    public function zoomLive()
    {
        $title = "";
        return view('learning::teacher.virtual-classrooms.zoom-live',
        compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('learning::local.add_zoom_schedule');
        return view('learning::teacher.virtual-classrooms.zoom-schedules.create',
        compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function attributes()
    {
        return [        
            'topic',                
            'start_date',  
            'admin_id',  
            'start_time',    
            'classroom_id',               
            'notes'      
        ];
    }
    public function store()
    {        
        request()->user()->zoomSchedules()->firstOrCreate(request()->only($this->attributes()));
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('zoom-schedules.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Learning\Models\Learning\ZoomSchedule  $zoomSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(ZoomSchedule $zoomSchedule)
    {
        $title = trans('learning::local.edit_zoom_schedule');
        return view('learning::teacher.virtual-classrooms.zoom-schedules.edit',
        compact('title','zoomSchedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Learning\Models\Learning\ZoomSchedule  $zoomSchedule
     * @return \Illuminate\Http\Response
     */
    public function update( ZoomSchedule $zoomSchedule)
    {
        $zoomSchedule->update(request()->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('zoom-schedules.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Learning\Models\Learning\ZoomSchedule  $zoomSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZoomSchedule $zoomSchedule)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    ZoomSchedule::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
