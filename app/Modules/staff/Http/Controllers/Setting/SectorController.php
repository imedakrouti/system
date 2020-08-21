<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
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
            $data = Sector::orderBy('sort','asc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('sector.edit',$data->id).'">
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
        return view('staff::settings.sector.index',['title'=>trans('staff::admin.sectors')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.sector.create',['title'=>trans('staff::admin.new_sector')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectorRequest $request)
    {
        $request->user()->sectors()->create($request->only('arabicSector','englishSector','sort'));
        alert()->success(trans('msg.stored_successfully'), trans('staff::admin.new_sector'));
        return redirect()->route('sector.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sector = Sector::findOrFail($id);
        return view('staff::settings.sector.edit',['title'=>trans('staff::admin.edit_sector'),'sector'=>$sector]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SectorRequest $request, Sector $sector)
    {
        $sector->update($request->only('arabicSector','englishSector','sort'));
        alert()->success(trans('msg.updated_successfully'), trans('staff::admin.edit_sector'));
        return redirect()->route('sector.index');
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
                    Sector::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    private function sectors()
    {
        $sectors = Sector::all();
        foreach ($sectors as $sector) {
            $sector->setAttribute('sectorName',session('lang')!='en'?$sector->englishSector:$sector->arabicSector);
        }
        return $sectors;
    }
    public function getSectors()
    {
        $output = "";
        $output .='<option value="">'.trans('staff::admin.select').'</option>';
        foreach ($this->sectors() as $sector) {
            $output .= ' <option value="'.$sector->id.'">'.$sector->sectorName.'</option>';
        };
        return json_encode($output);
    }

    public function getSectorsWithNull()
    {
        $output = "";
        $output .='<option value="">'.trans('staff::admin.select').'</option>';
        foreach ($this->sectors() as $sector) {
            $output .= ' <option value="'.$sector->id.'">'.$sector->sectorName.'</option>';
        };
        $output .='<option value="Null">'.trans('staff::admin.null').'</option>';
        return json_encode($output);
    }

    public function getSectorsSelected()
    {
        $id = request()->get('sectorId');
        $output = "";
        $output .='<option value="">'.trans('staff::admin.select').'</option>';
        foreach ($this->sectors() as $sector) {
            $selected = $sector->id == $id?"selected":"";
            $output .= ' <option '.$selected.' value="'.$sector->id.'">'.$sector->sectorName.'</option>';
        };
        $output .='<option value="Null">'.trans('staff::admin.null').'</option>';
        return json_encode($output);
    }
}
