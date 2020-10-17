<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Staff\Http\Requests\LeaveTypeRequest;
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
        return view('staff::settings.leave-types.create',
        ['title'=>trans('staff::local.new_leave_type')]);
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
        $request->user()->leaveTypes()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('leave-types.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $leave_type = LeaveType::findOrFail($id);
        return view('staff::settings.leave-types.edit',
        ['title'=>trans('staff::local.edit_leave_type'),'leave_type'=>$leave_type]);
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
        $leave_type = LeaveType::findOrFail($id);
        $leave_type->update($request->only($this->attributes()));
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
}
