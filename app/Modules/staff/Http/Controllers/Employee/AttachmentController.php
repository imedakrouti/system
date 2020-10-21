<?php


namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Staff\Models\Employees\Attachment;
use Staff\Models\Employees\Employee;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Attachment::with('employee')->orderBy('id','desc')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($data){
                           $btn = '<a class="btn btn-warning btn-sm" href="'.route('attachments.edit',$data->id).'">
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
                    ->addColumn('attendance_id',function($data){
                        return $data->employee->attendance_id;
                    })
                    ->addColumn('employee_name',function($data){
                        return $this->getFullEmployeeName($data);
                    })                    
                    ->addColumn('sector',function($data){
                        return !empty($data->employee->sector) ?(session('lang') == 'ar' ? $data->employee->sector->ar_sector:
                        $data->employee->sector->en_sector) :'';
                    }) 
                    ->addColumn('department',function($data){
                        return !empty($data->employee->department) ?(session('lang') == 'ar' ? $data->employee->department->ar_department:
                        $data->employee->department->en_department) :'';
                    })   
                    ->addColumn('section',function($data){
                        return !empty($data->employee->section) ?(session('lang') == 'ar' ? $data->employee->section->ar_section:
                        $data->employee->section->en_section) :'';
                        
                    })  
                    ->addColumn('position',function($data){
                        return !empty($data->employee->position) ?(session('lang') == 'ar' ? $data->employee->position->ar_position:
                        $data->employee->position->en_position) :'';
                    })                   
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->rawColumns(['action','check','employee_name','attendance_id','sector','department','section','position','file_name'])
                    ->make(true);
        }
        return view('staff::attachments.index',
        ['title'=>trans('staff::local.attachments')]);  
    }

    private function getFullEmployeeName($data)
    {
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a href="'.route('employees.show',$data->employee->id).'">' .$data->employee->ar_st_name . ' ' . $data->employee->ar_nd_name.
            ' ' . $data->employee->ar_rd_name.' ' . $data->employee->ar_th_name.'</a>';
        }else{
            $employee_name = '<a href="'.route('employees.show',$data->employee->id).'">' .$data->employee->en_st_name . ' ' . $data->employee->en_nd_name.
            ' ' . $data->employee->th_rd_name.' ' . $data->employee->th_th_name.'</a>';
        }
        return $employee_name;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::orderBy('attendance_id')->get();
        return view('staff::attachments.create',
        ['title'=>trans('staff::local.add_to_attachment'),'employees'=>$employees]);
    }
    private function attributes()
    {
        return  [
            'document_name',           
            'employee_id'   
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $this->file_name = uploadFileOrImage(null,request('file_name'),'images/attachments'); 
        $request->user()->attachments()->create($request->only($this->attributes())+
        [ 'file_name' => $this->file_name]);        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('attachments.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        $employees = Employee::orderBy('attendance_id')->get();
        $title = trans('staff::local.edit_to_attachment');

        return view('staff::attachments.edit',
        compact('attachment','employees','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        if (request()->hasFile('file_name')) {   
            $file_path = public_path()."/images/attachments/".$attachment->file_name;                                                             
            $this->file_name = uploadFileOrImage( $file_path,request('file_name'),'images/attachments'); 
            $attachment->update($request->only($this->attributes())+
            [ 'file_name' => $this->file_name]);   
        }else{
            $attachment->update($request->only($this->attributes()));   
        }
        
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('attachments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attachment $attachment)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    $attachment = Attachment::findOrFail($id);
                    $file_path = public_path()."/images/attachments/".$attachment->file_name;                                                             
                    removeFileOrImage($file_path); // remove file from directory
                    Attachment::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
