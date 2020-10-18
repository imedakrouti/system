<?php
namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Staff\Http\Requests\ExternalCodeRequest;
use Staff\Models\Settings\ExternalCode;

class ExternalCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = ExternalCode::latest();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('external-codes.edit',$data->id).'">
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
        return view('staff::settings.external-codes.index',
        ['title'=>trans('staff::local.external_codes')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.external-codes.create',
        ['title'=>trans('staff::local.new_external_code')]);
    }
    private function attributes()
    {
        return ['pattern','replacement','description'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ExternalCodeRequest $request)
    {
        $request->user()->externalCodes()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('external-codes.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ExternalCode  $externalCode
     * @return \Illuminate\Http\Response
     */
    public function edit(ExternalCode $externalCode)
    {
        return view('staff::settings.external-codes.edit',
        ['title'=>trans('staff::local.edit_external_code'),'externalCode'=>$externalCode]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ExternalCode  $externalCode
     * @return \Illuminate\Http\Response
     */
    public function update(ExternalCodeRequest $request, ExternalCode $externalCode)
    {
        $externalCode->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('external-codes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ExternalCode  $externalCode
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExternalCode $externalCode)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    ExternalCode::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
