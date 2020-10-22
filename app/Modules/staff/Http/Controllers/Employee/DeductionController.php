<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeductionRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Employees\Deduction;

class DeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Deduction::with('employee')->orderBy('id','desc')->get();
            return $this-> dataTableApproval1($data);
        }
        return view('staff::deductions.index',
        ['title'=>trans('staff::local.deductions')]);  
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
    private function workingData($data)
    {
        $sector = '';
        if (!empty($data->employee->sector->ar_sector)) {
            $sector = session('lang') == 'ar' ?  '<span class="blue">'.$data->employee->sector->ar_sector . '</span>': '<span class="blue">'.$data->employee->sector->en_sector . '</span>';            
        }
        $department = '';
        if (!empty($data->employee->department->ar_department)) {
            $department = session('lang') == 'ar' ?  '<span class="purple">'.$data->employee->department->ar_department . '</span>': '<span class="blue">'.$data->employee->department->en_department . '</span>';            
        }
        $section = '';
        if (!empty($data->employee->section->ar_section)) {
            $section = session('lang') == 'ar' ?  '<span class="red">'.$data->employee->section->ar_section . '</span>': '<span class="blue">'.$data->employee->section->en_section . '</span>';            
        }
        return $sector . ' '. $department . '<br>' .  $section ;
    }
    private function dataTableApproval1($data)
    {
        return datatables($data)
        ->addIndexColumn()                                 
        ->addColumn('attendance_id',function($data){
            return $data->employee->attendance_id;
        })
        ->addColumn('employee_name',function($data){
            return $this->getFullEmployeeName($data);
        }) 
        ->addColumn('approval1',function($data){
            switch ($data->approval1) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-primary round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>';
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-warning round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>';
                case trans('staff::local.canceled'):                                 
                    return '<div class="badge badge-info round">
                                <span>'.trans('staff::local.canceled_done').'</span>
                                <i class="la la-hand-paper-o font-medium-2"></i>
                            </div>';
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>';                         
            }
            
        })                     
        ->addColumn('workingData',function($data){
            return $this->workingData($data);
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
        ->rawColumns(['check','employee_name','attendance_id','workingData','approval1'])
        ->make(true);
    }

    public function filter()
    {
        if (request()->ajax()) {
            $data = Deduction::with('employee')->orderBy('id','desc')->where('approval1',request('approval1'))->get();
            return $this-> dataTableApproval1($data);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::orderBy('attendance_id')->get();
        return view('staff::deductions.create',
        ['title'=>trans('staff::local.new_deduction'),'employees'=>$employees]);
    }
    private function attributes()
    {
        return  [                        
            'date_deduction',           
            'reason',           
            'approval1',           
            'approval2',                       
            'admin_id'   
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeductionRequest $request)
    {

        foreach (request('employee_id') as $employee_id) {            
            $request->user()->deductions()->create($request->only($this->attributes())+
            ['employee_id'   => $employee_id,'amount' => request('amount') * $this->salaryPerDay($employee_id)]);             
        }        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('deductions.index');
    }
    private function salaryPerDay($employee_id)
    {
        return Employee::findOrFail($employee_id)->salary / 30;
    }

    public function edit(Deduction $deduction)
    {

    }

    public function update(DeductionRequest $request , Deduction $deduction)
    {

    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Deduction  $deduction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Deduction $deduction)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    Deduction::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function accept()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Deduction::where('id',$id)->update(['approval1'=>'Accepted']);
            }
        }
        return response(['status'=>true]);
    }
    public function reject()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Deduction::where('id',$id)->update(['approval1'=>'Rejected','approval2'=>'Rejected']);
            }
        }
        return response(['status'=>true]);
    }
    public function cancel()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Deduction::where('id',$id)->update(['approval1'=>'Canceled','approval2'=>'Pending']);
            }
        }
        return response(['status'=>true]);
    }

    public function confirm()
    {
        if (request()->ajax()) {
            $data = Deduction::with('employee')->orderBy('id','desc')->where('approval1','Accepted')->get();
            return $this->dataTableApproval2($data);
        }
        return view('staff::deductions.confirm.index',
        ['title'=>trans('staff::local.confirm_deductions')]);  
    }

    public function filterConfirm()
    {
        if (request()->ajax()) {
            $data = Deduction::with('employee')->orderBy('id','desc')
            ->where('approval1','Accepted')
            ->where('approval2',request('approval2'))->get();
            return $this-> dataTableApproval2($data);
        }
    }

    private function dataTableApproval2($data)
    {
        return datatables($data)
        ->addIndexColumn()                                 
        ->addColumn('attendance_id',function($data){
            return $data->employee->attendance_id;
        })
        ->addColumn('employee_name',function($data){
            return $this->getFullEmployeeName($data);
        }) 
        ->addColumn('approval1',function($data){
            switch ($data->approval1) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-primary round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>';
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-warning round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>';
                case trans('staff::local.canceled'):                                 
                    return '<div class="badge badge-info round">
                                <span>'.trans('staff::local.canceled_done').'</span>
                                <i class="la la-hand-paper-o font-medium-2"></i>
                            </div>';
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>';                         
            }
            
        })    
        ->addColumn('approval2',function($data){
            switch ($data->approval2) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-success round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>';
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-danger round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>';
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>';                         
            }
            
        })                   
        ->addColumn('workingData',function($data){
            return $this->workingData($data);
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
        ->rawColumns(['check','employee_name','attendance_id','workingData','approval1','approval2'])
        ->make(true);
    }

    public function acceptConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Deduction::where('id',$id)->update(['approval2'=>'Accepted']);
            }
        }
        return response(['status'=>true]);
    }
    public function rejectConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Deduction::where('id',$id)->update(['approval2'=>'Rejected']);
            }
        }
        return response(['status'=>true]);
    }



}
