<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Staff\Http\Requests\PositionRequest;
use Staff\Models\Settings\Position;

class positionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Position::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('positions.edit',$data->id).'">
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
        return view('staff::settings.positions.index',
        ['title'=>trans('staff::local.positions')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.positions.create',
        ['title'=>trans('staff::local.new_position')]);
    }
    private function attributes()
    {
        return ['ar_position','en_position','sort','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PositionRequest $request)
    {
        $request->user()->positions()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('positions.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(Position $position)
    {
        return view('staff::settings.positions.edit',
        ['title'=>trans('staff::local.edit_position'),'position'=>$position]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function update(PositionRequest $request, position $position)
    {
        $position->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('positions.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Position $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Position::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
