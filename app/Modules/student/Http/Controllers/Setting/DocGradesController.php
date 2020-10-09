<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Http\Requests\DocumentGradeRequest;
use Student\Models\Settings\DocumentGrade;
use Illuminate\Http\Request;
use Student\Models\Settings\AdmissionDoc;
use Student\Models\Settings\Grade;
use DB;
use Student\Models\Students\Student;

class DocGradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DocumentGrade::with('grades','admissionDocuments')->latest();
        if (request()->ajax()) {
            return $this->dataTable($data);
        }
        $grades = Grade::sort()->get();        
        return view('student::settings.documents-grades.index',
        ['title'=>trans('student::local.documents_grades'),'grades' => $grades]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grades = Grade::sort()->get();        
        $documents = AdmissionDoc::sort()->get();        
        return view('student::settings.documents-grades.create',
        ['title'=>trans('student::local.new_documents_grades'),
        'grades' => $grades , 'documents' => $documents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocumentGradeRequest $request)
    {
        foreach ($request->grade_id as $grade)
        {
            foreach ($request->admission_document_id as $document) {
                $request->user()->documentGrades()->create([
                    'admission_document_id' => $document,
                    'grade_id'              => $grade,
                ]);        
            }
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('documents-grades.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DocumentGrade  $documentGrade
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $documentGrade = DocumentGrade::findOrFail($id);
        $grades = Grade::sort()->get();        
        $documents = AdmissionDoc::sort()->get();        
        return view('student::settings.documents-grades.edit',
        ['title'=>trans('student::local.edit_documents_grades'),
        'documentGrade'=>$documentGrade,'grades' => $grades , 'documents' => $documents]);
    }
    public function attributes() 
    {
        return [
            'admission_document_id',        
            'grade_id'            
        ];
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DocumentGrade  $documentGrade
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentGradeRequest $request, $id)
    {
        $documentGrade = DocumentGrade::findOrFail($id);
        $documentGrade->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('documents-grades.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DocumentGrade  $documentGrade
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentGrade $documentGrade)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    DocumentGrade::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
    public function filterByGrade()
    {                
        $data = DocumentGrade::with('grades','admissionDocuments')
        ->where('grade_id',request('grade_id'))->get();
        if (request()->ajax()) {
            return $this->dataTable($data);
        } 
    }
    private function dataTable($data)
    {
        return datatables($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
               $btn = '<a class="btn btn-warning btn-sm" href="'.route('documents-grades.edit',$data->id).'">
               <i class=" la la-edit"></i>
           </a>';
                return $btn;
        })
        ->addColumn('grade_id',function($data){
            return session('lang') == 'ar' ? 
            $data->grades->ar_grade_name : $data->grades->en_grade_name;
        })
        ->addColumn('admission_document_id',function($data){
            return session('lang') == 'ar' ? 
            $data->admissionDocuments->ar_document_name :$data->admissionDocuments->en_document_name;
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
    public function getDocumentSelected()
    {        
        $id = request()->get('id');      
        $student = Student::findOrFail($id);
        $output = "";
    $reg_type = '';
    switch ($student->reg_type) {
        case 'مستجد':
            $reg_type = 'new';
            break;
        case 'محول':
            $reg_type = 'transfer';
            break; 
        case 'عائد':
            $reg_type = 'return';
            break;                                           
        default:
            $reg_type = 'arrival';                
            break;
    }
        
        $admissionDocuments = AdmissionDoc::with('docsGrade')
        ->whereHas('docsGrade',function($q) use ($student){
            $q->where('grade_id',$student->grade_id);
        })->get();        
        foreach ($admissionDocuments as $document) {
            if (str_contains($document->registration_type,$reg_type)) {
                $document_id = DB::table('student_doc_delivers')->select('admission_document_id')
                ->where('student_id',$id)->where('admission_document_id',$document->id)->first();
                
                $documentValue = !empty($document_id->admission_document_id)?
                $document_id->admission_document_id:0;
                // dd($document_id);
                $checked = $document->id == $documentValue ?"checked":"";
                $documentName = session('lang')== 'ar'?$document->ar_document_name:$document->en_document_name;
                $output .= '<h5><li><label class="pos-rel">
                            <input type="checkbox" class="ace" name="admission_document_id[]" '.$checked.' value="'.$document->id.'" />
                            <span class="lbl"></span> '.$documentName.'
                        </label></li></h5>';                                    
            }
        };         
        // dd( $student->reg_type);      
        return json_encode($output);
    }
}
