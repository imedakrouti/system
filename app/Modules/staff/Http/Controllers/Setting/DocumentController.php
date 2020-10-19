<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Staff\Http\Requests\DocumentRequest;
use Staff\Models\Settings\Document;
use DB;
class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Document::sort()->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('documents.edit',$data->id).'">
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
        return view('staff::settings.documents.index',
        ['title'=>trans('staff::local.required_documents')]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff::settings.documents.create',
        ['title'=>trans('staff::local.new_document')]);
    }
    private function attributes()
    {
        return ['ar_document','en_document','sort','admin_id'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(documentRequest $request)
    {
        $request->user()->documents()->create($request->only($this->attributes()));        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('documents.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        return view('staff::settings.documents.edit',
        ['title'=>trans('staff::local.edit_document'),'document'=>$document]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document $document
     * @return \Illuminate\Http\Response
     */
    public function update(documentRequest $request, Document $document)
    {
        $document->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('documents.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    Document::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function getDocumentsSelected()
    {        
        $employee_id = request()->get('employee_id');        
        $output = "";
        
        $documents = Document::sort()->get();
        foreach ($documents as $document) {
            
            $document_id = DB::table('employee_documents')->select('document_id')
            ->where('employee_id',$employee_id)->where('document_id',$document->id)->first();
            
            $documentValue = !empty($document_id->document_id)?$document_id->document_id:0;
            
            $checked = $document->id == $documentValue ?"checked":"";
            $documentName = session('lang')== 'ar'?$document->ar_document:$document->en_document;
            $output .= '<h5><li><label class="pos-rel">
                        <input type="checkbox" class="ace" name="document_id[]" '.$checked.' value="'.$document->id.'" />
                        <span class="lbl"></span> '.$documentName.'
                    </label></li></h5>';
        };
        
        return json_encode($output);
    }
}
