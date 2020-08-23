<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use App\Http\Requests\YearRequest;
use Student\Models\Settings\Year;

use Illuminate\Http\Request;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Year::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('years.edit',$data->id).'">
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
        return view('student::settings.years.index',['title'=>trans('student::local.academic_years')]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.years.create',
        ['title'=>trans('student::local.new_academic_years')]);
    }
    private function attributes()
    {
        return [
            'name',
            'start_from',
            'end_from'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(YearRequest $request)
    {                
        $request->user()->years()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('years.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function edit(Year $year)
    {
        return view('student::settings.years.edit',
        ['title'=>trans('student::local.edit_academic_years'),'year'=>$year]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function update(YearRequest $request, Year $year)
    {
        $year->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('years.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function destroy(Year $year)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Year::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function getYears()
    {
        $years = Year::all();
        $output = "";
        $output .='<option value="">'.trans('admin.select').'</option>';
        foreach ($years as $year) {
            $output .= ' <option value="'.$year->id.'">'.$year->name.'</option>';
        };
        return json_encode($output);
    }

    public function getYearSelected()
    {
        $id = request()->get('year_id');
        $years = Year::all();
        $output = "";
        $output .='<option value="">'.trans('admin.select').'</option>';
        foreach ($years as $year) {
            $selected = $year->id == $id?"selected":"";
            $output .= ' <option '.$selected.' value="'.$year->id.'">'.$year->name.'</option>';
        };
        return json_encode($output);
    }
}
