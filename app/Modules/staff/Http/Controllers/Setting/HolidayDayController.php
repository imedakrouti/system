<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use DateTime;
use Staff\Models\Settings\Holiday;
use Staff\Models\Settings\HolidayDay;
use Carbon;

class HolidayDayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($holiday_id)
    {
        $holiday = Holiday::findOrFail($holiday_id);
        $title = session('lang') == 'ar' ? $holiday->ar_holiday:$holiday->en_holiday;        
        return view('staff::settings.holidays.days.index',
        compact('title','holiday'));
    }
    public function getAllDays()
    {        
        $data = HolidayDay::orderBy('date_holiday','asc')->where('holiday_id',request('holiday_id'))->get();
        return datatables($data)
                ->addIndexColumn()  
                ->addColumn('check', function($data){
                       $btnCheck = '<label class="pos-rel">
                                    <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                    <span class="lbl"></span>
                                </label>';
                        return $btnCheck;
                })
                ->rawColumns(['check'])
                ->make(true);    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($holiday_id)
    {
        $holiday = Holiday::findOrFail($holiday_id);
        $holiday_name = session('lang') == 'ar' ? $holiday->ar_holiday:$holiday->en_holiday;        
        $title = trans('staff::local.add_days');
        return view('staff::settings.holidays.days.create',
        compact('title','holiday','holiday_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {        
        $days = $this->vacationDays();
        $date = Carbon\Carbon::create(request('from_date'));
        
        for ($i=0;$i<=$days;$i++){
            $date_holiday = $date->format('Y-m-d');
            request()->user()->holidayDays()->create([
                'holiday_id'    => request('holiday_id'),
                'date_holiday'  => $date_holiday,
                'description'   => request('description'),                
            ]);
            $date->addDays(1);
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('holidays-days.index',request('holiday_id'));
    }

    private function vacationDays()
    {
        $datetime1 = new DateTime(request('from_date'));
        $datetime2 = new DateTime(request('to_date'));

        $interval = $datetime1->diff($datetime2);
        return $interval->format('%a');//now do whatever you like with $days
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    HolidayDay::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
