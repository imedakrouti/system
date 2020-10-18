<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Staff\Http\Requests\TimetableRequest;
use Staff\Models\Settings\Timetable;

class TimetableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Timetable::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('timetables.edit',$data->id).'">
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
                    ->rawColumns(['action','check'])
                    ->make(true);
        }
        return view('staff::settings.timetables.index',
        ['title'=>trans('staff::local.timetables')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.timetables.create',
        ['title'=>trans('staff::local.new_timetable')]);
    }
    private function attributes()
    {
        return [
            'ar_timetable',
            'en_timetable',
            'description',
            'on_duty_time',
            'off_duty_time',
            'beginning_in',
            'ending_in',
            'beginning_out',
            'ending_out',            
            'saturday_value',
            'sunday_value',
            'monday_value',
            'tuesday_value',
            'wednesday_value',
            'thursday_value',
            'friday_value',
            'daily_late_minutes',
            'day_absent_value',
            'no_attend',
            'no_leave',
            'check_in_before_leave',
            'admin_id',    
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TimetableRequest $request)
    {
        $request->user()->timetables()->create($request->only($this->attributes())+
    [
            'saturday'  => request('saturday') == 'Enable' ? 'Enable':'',
            'sunday'    => request('sunday') == 'Enable' ? 'Enable':'',
            'monday'    => request('monday') == 'Enable' ? 'Enable':'',
            'tuesday'   => request('tuesday') == 'Enable' ? 'Enable':'',
            'wednesday' => request('wednesday') == 'Enable' ? 'Enable':'',
            'thursday'  => request('thursday') == 'Enable' ? 'Enable':'',
            'friday'    => request('friday') == 'Enable' ? 'Enable':'',
    ]);        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('timetables.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function edit(Timetable $timetable)
    {
        return view('staff::settings.timetables.edit',
        ['title'=>trans('staff::local.edit_timetable'),'timetable'=>$timetable]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function update(TimetableRequest $request, Timetable $timetable)
    {
        $timetable->update($request->only($this->attributes())+
        [
                'saturday'  => request('saturday') == 'Enable' ? 'Enable':'',
                'sunday'    => request('sunday') == 'Enable' ? 'Enable':'',
                'monday'    => request('monday') == 'Enable' ? 'Enable':'',
                'tuesday'   => request('tuesday') == 'Enable' ? 'Enable':'',
                'wednesday' => request('wednesday') == 'Enable' ? 'Enable':'',
                'thursday'  => request('thursday') == 'Enable' ? 'Enable':'',
                'friday'    => request('friday') == 'Enable' ? 'Enable':'',
        ]);
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('timetables.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Timetable  $timetable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Timetable $timetable)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Timetable::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
