<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Staff\Http\Requests\HolidayRequest;
use Staff\Models\Settings\Document;
use Staff\Models\Settings\Holiday;
use DB;
class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Holiday::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('holidays.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('holiday_days',function($data){
                        return '<a class="btn btn-primary btn-sm" href="'.route('holidays-days.index',$data->id).'">
                                '.trans('staff::local.days').'
                            </a>';
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','holiday_days'])
                    ->make(true);
        }
        return view('staff::settings.holidays.index',
        ['title'=>trans('staff::local.holidays')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.holidays.create',
        ['title'=>trans('staff::local.new_holiday')]);
    }
    private function attributes()
    {
        return ['ar_holiday','en_holiday','description','sort','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HolidayRequest $request)
    {
        $request->user()->holidays()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('holidays.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('staff::settings.holidays.edit',
        ['title'=>trans('staff::local.edit_holiday'),'holiday'=>$holiday]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(HolidayRequest $request, Holiday  $holiday)
    {
        $holiday->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('holidays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday  $holiday)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Holiday::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function getHolidaysSelected()
    {        
        $employee_id = request()->get('employee_id');        
        $output = "";
        
        $holidays = Holiday::sort()->get();
        foreach ($holidays as $holiday) {
            
            $holiday_id = DB::table('employee_holidays')->select('holiday_id')
            ->where('employee_id',$employee_id)->where('holiday_id',$holiday->id)->first();
            
            $holidayValue = !empty($holiday_id->holiday_id)?$holiday_id->holiday_id:0;
            
            $checked = $holiday->id == $holidayValue ?"checked":"";
            $holidayName = session('lang')== 'ar'?$holiday->ar_holiday:$holiday->en_holiday;
            $output .= '<h5><li><label class="pos-rel">
                        <input type="checkbox" class="ace" name="holiday_id[]" '.$checked.' value="'.$holiday->id.'" />
                        <span class="lbl"></span> '.$holidayName.'
                    </label></li></h5>';
        };
        
        return json_encode($output);
    }
}
