<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Http\Requests\AdmissionDocRequest;
use Student\Models\Settings\AdmissionDoc;
use Illuminate\Http\Request;

class AdmissionDocController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = AdmissionDoc::sort();
            return datatables($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<a class="btn btn-warning btn-sm" href="'.route('admission-documents.edit',$data->id).'">
                    <i class=" la la-edit"></i>
                </a>';
                        return $btn;
                })
                ->addColumn('registration_type',function($data){
                    $registration_type = '';
                    $type = explode(',',$data->registration_type);            
                    for ($i=0; $i < count($type) ; $i++) { 
                        // dd($type[$i]);
                        $registration_type .= preg_match('/\bnew\b/', $type[$i]) != 0 ? "<span class='btn btn-info'>".trans('student::local.new')."</span>" .' ':'';
                        $registration_type .= preg_match('/\btransfer\b/', $type[$i]) != 0 ? "<span class='btn btn-info'>".trans('student::local.transfer')."</span>" .' ':'';
                        $registration_type .= preg_match('/\breturning\b/', $type[$i])  != 0 ? "<span class='btn btn-info'>".trans('student::local.returning')."</span>" .' ':'';
                        $registration_type .= preg_match('/\barrival\b/', $type[$i]) != 0 ? "<span class='btn btn-info'>".trans('student::local.arrival')."</span>" :'';
                    }
                    return  $registration_type;
                })  
                ->addColumn('check', function($data){
                    $btnCheck = '<label class="pos-rel">
                                    <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                    <span class="lbl"></span>
                                </label>';
                        return $btnCheck;
                })
                ->rawColumns(['action','check','registration_type'])
                ->make(true);
        }
        return view('student::settings.admission-documents.index',['title'=>trans('student::local.admission_documents')]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('student::settings.admission-documents.create',
        ['title'=>trans('student::local.new_admission_documents')]);
    }
    private function attributes()
    {
        return [
            'ar_document_name',
            'en_document_name',
            'notes',            
            'sort'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdmissionDocRequest $request)
    {      
        $request->user()->admissionDocuments()->create($request->only($this->attributes())
        + ['registration_type' =>  implode(",",request('registration_type'))]);   
           
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('admission-documents.index');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AdmissionDoc  $admissionDoc
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $admissionDoc = AdmissionDoc::findOrFail($id);
        return view('student::settings.admission-documents.edit',
        ['title'=>trans('student::local.edit_admission_documents'),'admissionDoc'=>$admissionDoc]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AdmissionDoc  $admissionDoc
     * @return \Illuminate\Http\Response
     */
    public function update(AdmissionDocRequest $request,$id)
    {        
        $admissionDoc = AdmissionDoc::findOrFail($id);
        $admissionDoc->update($request->only($this->attributes())
        + ['registration_type' =>  implode(",",request('registration_type'))]);  
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('admission-documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdmissionDoc  $admissionDoc
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdmissionDoc $admissionDoc)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    AdmissionDoc::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

}
