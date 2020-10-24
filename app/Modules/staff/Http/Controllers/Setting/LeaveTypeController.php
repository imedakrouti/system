<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
use Staff\Http\Requests\LeaveTypeRequest;
use Staff\Models\Employees\ActiveDayRequest;
use Staff\Models\Settings\Day;
use Staff\Models\Settings\LeaveType;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = LeaveType::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('leave-types.edit',$data->id).'">
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
        return view('staff::settings.leave-types.index',
        ['title'=>trans('staff::local.leave_types')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $days = Day::sort()->get();
        return view('staff::settings.leave-types.create',
        ['title'=>trans('staff::local.new_leave_type'),'days' => $days]);
    }
    private function attributes()
    {
        return [
            'ar_leave',
            'en_leave',
            'have_balance',
            'activation',
            'target',
            'deduction',
            'deduction_allocated',
            'from_day',
            'to_day',
            'period',
            'sort'            
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeaveTypeRequest $request)
    {
        DB::transaction(function() use ($request){
            $leave_type = $request->user()->leaveTypes()->create($request->only($this->attributes()));        
            $this->insertActiveDays($leave_type);
        });
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('leave-types.index');
    }
    private function insertActiveDays($leave_type)
    {        
        if (request()->has('days')) {
            ActiveDayRequest::where('leave_type_id',$leave_type->id)->delete();        
            foreach (request('days') as $day) {
                ActiveDayRequest::create([
                    'working_day'   => $day,
                    'leave_type_id' => $leave_type->id,
                ]);
            }            
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $days = Day::sort()->get();
        $leave_type = LeaveType::findOrFail($id);
        return view('staff::settings.leave-types.edit',
        ['title'=>trans('staff::local.edit_leave_type'),'leave_type'=>$leave_type,'days' => $days]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LeaveTypeRequest $request, $id)
    {
        DB::transaction(function() use ($id, $request){
            $leave_type = LeaveType::findOrFail($id);
            $leave_type->update($request->only($this->attributes()));
            $this->insertActiveDays($leave_type);
        });

        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('leave-types.index');
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
                    LeaveType::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function getDaysSelected()
    {        
        $output = "";
        $leave_type = request()->get('leave_type');        
               
        $workingDays = Day::sort()->get();
        foreach ($workingDays as $day) {
            $leave_type_id = ActiveDayRequest::where('leave_type_id',request('leave_type'))->select('working_day')
            ->where('working_day',$day->id)->first();
            
            $leave_request_value = !empty($leave_type_id->working_day)?$leave_type_id->working_day:0;

            $checked = $day->id == $leave_request_value ?"checked":"";
            $day_name = session('lang')=='ar'?$day->ar_day:$day->en_day;
            $output .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <label class="pos-rel">
                            <input type="checkbox" class="ace" name="days[]" '.$checked.' value="'.$day->id.'" />
                            <span class="lbl"></span> '.$day_name.'
                        </label>
                    ';
        };        
        return json_encode($output);
    }
}
