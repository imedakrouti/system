<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;

use Student\Models\Settings\Nationality;
use Illuminate\Http\Request;
use Student\Http\Requests\NationalityRequest;

class NationalityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Nationality::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('nationalities.edit',$data->id).'">
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
        return view('student::settings.nationalities.index',
        ['title'=>trans('student::local.nationalities')]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.nationalities.create',
        ['title'=>trans('student::local.new_nationality')]);
    }
    private function attributes()
    {
        return [            
            'ar_name_nat_male',
            'ar_name_nat_female',
            'en_name_nationality',
            'sort'
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NationalityRequest $request)
    {
        $request->user()->nationalities()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('nationalities.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nationality  $Nationality
     * @return \Illuminate\Http\Response
     */
    public function edit(Nationality $nationality)
    {
        return view('student::settings.nationalities.edit',
        ['title'=>trans('student::local.edit_nationality'),'nationality'=>$nationality]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nationality  $Nationality
     * @return \Illuminate\Http\Response
     */
    public function update(NationalityRequest $request, Nationality $nationality)
    {
        $nationality->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('nationalities.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nationality  $Nationality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nationality $Nationality)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Nationality::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
