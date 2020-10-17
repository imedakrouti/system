<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Staff\Http\Requests\SectorRequest;
use Staff\Models\Settings\Sector;

class SectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Sector::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('sectors.edit',$data->id).'">
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
        return view('staff::settings.sectors.index',
        ['title'=>trans('staff::local.sectors')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.sectors.create',
        ['title'=>trans('staff::local.new_sector')]);
    }
    private function attributes()
    {
        return ['ar_sector','en_sector','sort','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorRequest $request)
    {
        $request->user()->sectors()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('sectors.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function edit(Sector $sector)
    {
        return view('staff::settings.sectors.edit',
        ['title'=>trans('staff::local.edit_sector'),'sector'=>$sector]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(SectorRequest $request, Sector $sector)
    {
        $sector->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('sectors.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sector $sector)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Sector::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
