<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\VacationRequest;
use DateInterval;
use DatePeriod;
use DateTime;

use Staff\Models\Employees\Employee;
use Staff\Models\Employees\Vacation;
use Staff\Models\Employees\VacationPeriod;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\Position;
use Staff\Models\Settings\Section;
use Staff\Models\Settings\Sector;

class VacationController extends Controller
{
    private $file_name;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Vacation::with('employee')->orderBy('id','desc')->get();
            return $this-> dataTableApproval1($data);
        }
        return view('staff::vacations.index',
        ['title'=>trans('staff::local.vacations')]);  
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
        ->addColumn('vacation_period',function($data){
            return '<span class="red"><strong>'.trans('staff::local.from').'</strong></span> '.            
            \Carbon\Carbon::parse( $data->from_date)->format('M d Y, D')
            .'<br><span class="success"><strong>' .trans('staff::local.to') .'</strong></span> ' .
            \Carbon\Carbon::parse( $data->to_date)->format('M d Y, D');
        })                          
        ->addColumn('check', function($data){
               $btnCheck = '<label class="pos-rel">
                            <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
        })
        ->addColumn('attachments',function($data){
            $file =  '<a target="_blank" class="btn btn-success btn-sm" href="'.asset('images/attachments/'.$data->file_name).'">
                        <i class=" la la-download"></i>
                    </a>';
            return empty($data->file_name) ? '' : $file;   
        })
        ->addColumn('employee_image',function($data){
            return $this->employeeImage($data);
        })
        ->rawColumns(['check','employee_name','attendance_id','approval1','vacation_period','attachments','employee_image'])
        ->make(true);
    }

    public function filter()
    {
        if (request()->ajax()) {
            $vacation_type = empty(request('vacation_type'))? ['vacation_type','<>','']:['vacation_type',request('vacation_type')];
            $approval1 = empty(request('approval1'))? ['approval1','<>','']:['approval1',request('approval1')];
            $data = Vacation::with('employee')->orderBy('id','desc')
            ->where([$vacation_type,$approval1])            
            ->get();
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
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::vacations.create',
        ['title'=>trans('staff::local.new_vacation'),'employees'=>$employees]);
    }
    private function attributes()
    {
        return  [
            'date_vacation',
            'from_date',
            'to_date',                                   
            'vacation_type',            
            'substitute_employee_id',
            'admin_id'
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     private function getDaysCount()
     {      
         // get count of days between two dates---
         $datetime1 = new DateTime(request('from_date'));
         $datetime2 = new DateTime(request('to_date'));
         $interval = $datetime1->diff($datetime2);  

         return $interval->invert == 0 ? $interval->format('%a') : 1;//now do whatever you like with $days
     }
    public function store(VacationRequest $request)
    {                
        if ($this-> getDaysCount() == 1 ) {
            toast(trans('staff::local.invalid_vacation_period'),'error');
            return back()->withInput();
        } 

        if (request()->hasFile('file_name')) {
            if (request('employee_id') > 1) {
                toast(trans('staff::local.invalid_number_employees'),'error');
                return back()->withInput();
            }
            $this->file_name = uploadFileOrImage(null,request('file_name'),'images/attachments');             
        }        
        foreach (request('employee_id') as $employee_id) {            
            $vacation = $request->user()->vacations()->create($request->only($this->attributes())+
            [
                'employee_id'   => $employee_id,
                'file_name'     => $this->file_name,
                'count'         => $this-> getDaysCount()+ 1,
            ]);    
            $this->InsertVacationPeriod($vacation,$employee_id);         
        }        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('vacations.index');
    }
    private function InsertVacationPeriod($vacation,$employee_id)
    {
        $to_date = date('Y-m-d', strtotime(request('to_date'). ' + 1 day'));
        
        $period = new DatePeriod(
            new DateTime(request('from_date')),
            new DateInterval('P1D'),
            new DateTime($to_date)
       );

       foreach ($period as $date_vacation) {
           VacationPeriod::firstOrCreate([
            'date_vacation' => $date_vacation,
            'employee_id'   => $employee_id,
            'vacation_id'   => $vacation->id,
            'vacation_type' => request('vacation_type'),
           ]);
       }


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vacation  $vacation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vacation $vacation)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {
                    $Vacation = Vacation::findOrFail($id);
                    $file_path = public_path()."/images/attachments/".$Vacation->file_name;                                                             
                    removeFileOrImage($file_path); // remove file from directory
                    Vacation::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function accept()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Vacation::where('id',$id)->update(['approval1'=>'Accepted']);
            }
        }
        return response(['status'=>true]);
    }
    public function reject()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Vacation::where('id',$id)->update(['approval1'=>'Rejected','approval2'=>'Rejected']);
            }
        }
        return response(['status'=>true]);
    }
    public function cancel()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Vacation::where('id',$id)->update(['approval1'=>'Canceled','approval2'=>'Pending']);
            }
        }
        return response(['status'=>true]);
    }

    public function confirm()
    {
        if (request()->ajax()) {
            $data = Vacation::with('employee')->orderBy('id','desc')->where('approval1','Accepted')->get();
            return $this->dataTableApproval2($data);
        }
        return view('staff::vacations.confirm',
        ['title'=>trans('staff::local.confirm_vacations')]);  
    }

    public function filterConfirm()
    {
        $vacation_type = empty(request('vacation_type'))? ['vacation_type','<>','']:['vacation_type',request('vacation_type')];
        $approval2 = empty(request('approval2'))? ['approval2','<>','']:['approval2',request('approval2')];
        if (request()->ajax()) {
            $data = Vacation::with('employee')->orderBy('id','desc')
            ->where('approval1','Accepted')            
            ->where([$vacation_type,$approval2])            
            ->get();
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
        ->addColumn('vacation_period',function($data){
            return '<span class="red"><strong>'.trans('staff::local.from').'</strong></span> '.            
            \Carbon\Carbon::parse( $data->from_date)->format('M d Y, D')
            .'<br><span class="success"><strong>' .trans('staff::local.to') .'</strong></span> ' .
            \Carbon\Carbon::parse( $data->to_date)->format('M d Y, D');
        })                          
        ->addColumn('check', function($data){
               $btnCheck = '<label class="pos-rel">
                            <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
        })
        ->addColumn('attachments',function($data){
            $file =  '<a target="_blank" class="btn btn-success btn-sm" href="'.asset('images/attachments/'.$data->file_name).'">
                        <i class=" la la-download"></i>
                    </a>';
            return empty($data->file_name) ? '' : $file;   
        })
        ->addColumn('employee_image',function($data){
            return $this->employeeImage($data);
        })
        ->rawColumns(['check','employee_name','attendance_id','approval2','vacation_period','attachments','employee_image'])
        ->make(true);
    }
    private function employeeImage($data)
    {
        $employee_id = isset($data->employee->id) ? $data->employee->id : $data->employee->employee_id;   
        $image_path = $data->employee->gender == 'male' ? 'images/website/male.png' : 'images/website/female.png';     
        return !empty($data->employee->employee_image)?
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset('images/employeesImages/'.$data->employee->employee_image).'" />
            </a>':
            '<a href="'.route('employees.show',$employee_id).'">
                <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                src="'.asset($image_path).'" />
            </a>';
    }

    public function acceptConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Vacation::where('id',$id)->update(['approval2'=>'Accepted']);
            }
        }
        return response(['status'=>true]);
    }
    public function rejectConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                Vacation::where('id',$id)->update(['approval2'=>'Rejected']);
            }
        }
        return response(['status'=>true]);
    }

    public function balance()
    {
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $employee = Employee::work()->get();
        $title = trans('staff::local.vacation_balance');
        return view('staff::vacations.balance',
        compact('sectors','departments','sections','positions','employee','title'));

    }
    public function setBalance()
    {

    }
}
