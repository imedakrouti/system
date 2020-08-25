<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Http\Requests\RegistrationStatusRequest;
use Student\Models\Settings\RegistrationStatus;
use Illuminate\Http\Request;

class RegistrationStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = RegistrationStatus::sort();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('registration-status.edit',$data->id).'">
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
        return view('student::settings.registration-status.index',
        ['title'=>trans('student::local.registration_status')]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.registration-status.create',
        ['title'=>trans('student::local.new_registration_status')]);
    }
    private function attributes()
    {
        return [
            'ar_name_status',
            'en_name_status',
            'description',
            'shown',
            'sort',
            ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegistrationStatusRequest $request)
    {
        $request->user()->registrationStatus()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('registration-status.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegistrationStatus  $RegistrationStatus
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $registrationStatus = RegistrationStatus::findOrFail($id);
        return view('student::settings.registration-status.edit',
        ['title'=>trans('student::local.edit_registration_status'),'registrationStatus'=>$registrationStatus]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegistrationStatus  $RegistrationStatus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $registrationStatus = RegistrationStatus::findOrFail($id);
        $registrationStatus->update($request->only($this->attributes()));  
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('registration-status.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegistrationStatus  $RegistrationStatus
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegistrationStatus $RegistrationStatus)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    RegistrationStatus::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
