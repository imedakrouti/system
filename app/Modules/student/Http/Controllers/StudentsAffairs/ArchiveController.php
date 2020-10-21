<?php

namespace Student\Http\Controllers\StudentsAffairs;
use App\Http\Controllers\Controller;
use Student\Http\Requests\ArchiveRequest;
use Student\Models\Students\Archive;
use Student\Models\Students\Student;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Archive::with('students')->orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('archives.edit',$data->id).'">
                           <i class=" la la-edit"></i>
                       </a>';
                            return $btn;
                    })
                    ->addColumn('file_name',function($data){
                        $file =  '<a target="blank" class="btn btn-success btn-sm" href="'.asset('images/attachments/'.$data->file_name).'">
                                    <i class=" la la-download"></i>
                                </a>';
                        return empty($data->file_name) ? '' : $file;                                
                    }) 
                    ->addColumn('student_number',function($data){
                        $data->students->grade->student_number;
                    })
                    ->addColumn('student_name',function($data){
                        return $this->getStudentName($data);
                    })                    
                    ->addColumn('grade',function($data){
                        return session('lang') == 'ar' ? $data->students->grade->ar_grade_name:
                        $data->students->grade->en_grade_name;
                    }) 
                    ->addColumn('division',function($data){
                        return session('lang') == 'ar' ? $data->students->division->ar_division_name:
                        $data->students->division->en_division_name;
                    })                     
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','student_name','student_number','grade','division','file_name'])
                    ->make(true);
        }
        return view('student::students-affairs.archive.index',
        ['title'=>trans('student::local.archive')]);  
    }

    private function getStudentName($data)
    {        
        return session('lang') == 'ar' ?
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->ar_student_name.' '. $data->students->father->ar_st_name .' '.$data->students->father->ar_nd_name .' '.$data->students->father->ar_rd_name .' '.$data->students->father->ar_th_name .'</a>':
        
        '<a href="'.route('students.show',$data->students->id).'">'. $data->students->en_student_name.' '.$data->students->father->en_st_name .' '.$data->students->father->en_nd_name .' '.$data->students->father->en_rd_name .' '.$data->students->father->en_th_name .'</a>';  
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $students = Student::orderBy('ar_student_name')->get();
        return view('student::students-affairs.archive.create',
        ['title'=>trans('student::local.add_to_archive'),'students'=>$students]);
    }
    private function attributes()
    {
        return  [
            'document_name',           
            'student_id'   
        ];
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArchiveRequest $request)
    {        
        $this->file_name = uploadFileOrImage(null,request('file_name'),'images/attachments'); 
        $request->user()->archives()->create($request->only($this->attributes())+
        [ 'file_name' => $this->file_name]);        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('archives.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function studentFiles($student_id)
    {        
        $student = Student::findOrFail($student_id);
        $archives = Archive::where('student_id',$student_id)->orderBy('created_at','asc')->get();
        $title = trans('student::local.view_files');

        return view('student::students-affairs.archive.student-profile.student-files',
        compact('archives','student','title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function edit(Archive $archive)
    {
        $students = Student::orderBy('ar_student_name')->get();
        $title = trans('student::local.edit_to_archive');

        return view('student::students-affairs.archive.edit',
        compact('archive','students','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function update(ArchiveRequest $request, Archive $archive)
    {
        if (request()->hasFile('file_name')) {   
            $file_path = public_path()."/images/attachments/".$archive->file_name;                                                             
            $this->file_name = uploadFileOrImage( $file_path,request('file_name'),'images/attachments'); 
            $archive->update($request->only($this->attributes())+
            [ 'file_name' => $this->file_name]);   
        }else{
            $archive->update($request->only($this->attributes()));   
        }
        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('archives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    $archive = Archive::findOrFail($id);
                    $file_path = public_path()."/images/attachments/".$archive->file_name;                                                             
                    removeFileOrImage($file_path); // remove file from directory
                    Archive::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
