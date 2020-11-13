<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\LeavePermissionRequest;
use App\Models\Admin;
use Staff\Models\Employees\Employee;
use Staff\Models\Employees\LeavePermission;
use Staff\Models\Settings\LeaveType;
use Carbon;
use DateTime;
use Staff\Models\Employees\ActiveDayRequest;
use Staff\Models\Employees\Deduction;
use Staff\Models\Settings\Day;
use Staff\Models\Settings\Department;
use Staff\Models\Settings\Timetable;
use DB;
class LeavePermissionController extends Controller
{
    private $from_date;
    private $to_date;
    private $department_name ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = LeavePermission::with('employee','leaveType','admin')->orderBy('id','desc')
            ->where('approval2','<>','Accepted')->where('approval2','<>','Rejected')->get();
            return $this-> dataTableApproval1($data);
        }
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::leave-permissions.index',
        ['title'=>trans('staff::local.leave_permissions'),'employees' => $employees]);  
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
            $username = empty($data->approvalOne->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalOne->username;
            switch ($data->approval1) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-primary round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-warning round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.canceled'):                                 
                    return '<div class="badge badge-info round">
                                <span>'.trans('staff::local.canceled_done').'</span>
                                <i class="la la-hand-paper-o font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>' .$username;                         
            }
            
        })                     
        ->addColumn('workingData',function($data){
            return $this->workingData($data);
        })    
        ->addColumn('created_at',function($data){
            return '<div class="badge badge-info round">
                        <span>'.$data->admin->username.'</span>
                        <i class="la la-check font-medium-2"></i>
                    </div> <br>'. \Carbon\Carbon::parse( $data->created_at)->format('M d Y, D h:m ');
            return $data->admin->username .'<br>'. \Carbon\Carbon::parse( $data->created_at)->format('M d Y, D h:m ');
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
        ->addColumn('leave_permission_id',function($data){
            return session('lang') == 'ar' ? $data->leaveType->ar_leave:$data->leaveType->ar_leave ;
        })
        ->rawColumns(['check','employee_name','attendance_id','workingData','approval1','leave_permission_id','created_at'])
        ->make(true);
    }
    public function filter()
    {
        if (request()->ajax()) {
            $data = LeavePermission::with('employee')->orderBy('id','desc')
            ->where('approval1',request('approval1'))->get();
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
        $leave_types = LeaveType::sort()->get();
        return view('staff::leave-permissions.create',
        ['title'=>trans('staff::local.new_leave_permission'),
        'employees'=>$employees,'leave_types' => $leave_types]);
    }
    private function attributes()
    {
        return   [
            'date_leave',
            'time_leave',
            'approval_one_user',
            'approval_two_user',
            'approval1',
            'approval2',
            'leave_type_id',            
            'admin_id',
             
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LeavePermissionRequest $request)
    {
      
        if (!$this->checkDateRequest()) {                
            toast(trans('staff::local.invalid_date_leave'),'error');
            return back()->withInput();
        }

        if (!$this->checkAvailableDay()) {                
            toast(trans('staff::local.deny_day_leave'),'error');
            return back()->withInput();
        }
       
        $employee_no_balance = '';
        $employee_no_department = '';
        $department_no_balance = '';
        $employee_has_current_permission = '';
        $available_time = '';

        foreach (request('employee_id') as $employee_id) {                  
                if (!$this->haveBalance($employee_id)){
                    $employee_no_balance .= ' ['.$this->getAttendanceId($employee_id).'] ';                    
                }
                
                if (!$this->hasDepartment($employee_id)){
                    $employee_no_department .= ' ['.$this->getAttendanceId($employee_id).'] ';                    
                }
              
                if (!$this->departmentHasBalance($employee_id)){
                    $department_no_balance .= ' ['.$this->department_name.'] ';                    
                }
               
                if (!$this->employeeHasTodayPermission($employee_id)) {
                    $employee_has_current_permission .= ' ['.$this->getAttendanceId($employee_id).'] ';                    
                }
               
                if (!$this->availableTimeLeave($employee_id)) {
                    $available_time .= ' ['.$this->getAttendanceId($employee_id).'] ';                    
                }
                
        }

        if (!empty($employee_no_balance)) {
            toast(trans('staff::local.no_enough_balance').' '.trans('staff::local.attendance_id').' '.$employee_no_balance,'error');
            return back()->withInput();
        }

        if (!empty($employee_no_department)) {
            toast(trans('staff::local.no_department_found').' '.trans('staff::local.attendance_id').' '.$employee_no_department,'error');
            return back()->withInput();
        }

        if (!empty($department_no_balance)) {
            toast(trans('staff::local.no_balance_department').' '.$department_no_balance,'error');
            return back()->withInput();
        }

        if (!empty($employee_has_current_permission)) {
            toast(trans('staff::local.employee_has_current_permission').'</br>['.request('date_leave').']'.' '.trans('staff::local.attendance_id').' '.$employee_has_current_permission,'error');
            return back()->withInput();
        }

        if (!empty($available_time)) {
            toast(trans('staff::local.available_time').' '.trans('staff::local.attendance_id').' '.$available_time,'error');
            return back()->withInput();
        }

        $leave_type = LeaveType::findOrFail(request('leave_type_id'));            
        $reason = $leave_type->ar_leave .' - '. $leave_type->en_leave;
           
        foreach (request('employee_id') as $employee_id) {  
            DB::transaction(function() use ($employee_id, $request, $reason){
                $leave_permission_id = $request->user()->leavePermissions()->create($request->only($this->attributes())+
                [
                    'employee_id'   => $employee_id,
                ]);  
                $this->hasDeduction($employee_id,$leave_permission_id, $reason);          
            });
        }        
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('leave-permissions.index');
    }
    // requirements

    private function hasDeduction($employee_id,$leave_permission_id, $reason)
    {
        $deduction = LeaveType::findOrFail(request('leave_type_id'));
        $salaryPerDay = Employee::findOrFail($employee_id)->salary / 30;
        if ($deduction->deduction == 'yes') {

            request()->user()->deductions()->create(
            [
                'date_deduction'        => request('date_leave'),
                'leave_permission_id'   => $leave_permission_id->id,
                'reason'                => $reason,
                'employee_id'           => $employee_id,
                'days'                  => $deduction->deduction_allocated,
                'amount'                => $deduction->deduction_allocated *$salaryPerDay
            ]);   
        }        
    }

    private function availableTimeLeave($employee_id)
    {        
        $timetable_id = Employee::findOrFail($employee_id)->timetable_id;
        if (empty($timetable_id)) {
            return false;
        }
        $timetable = Timetable::findOrFail($timetable_id);
        if ($timetable->off_duty_time <= request('time_leave')) {            
            return false;
        }
        $time_leave = date("H:i", strtotime("+1 minutes", strtotime(request('time_leave'))));
        
        if ($timetable->on_duty_time > $time_leave ) {            
            return false;
        }
        return true;
    }

    private function checkAvailableDay()
    {
        
        $today_name = date('l', strtotime(request('date_leave')));
        
        $day_id = Day::where('en_day',$today_name)->first()->id;
        $where = [
            ['working_day',$day_id],
            ['leave_type_id',request('leave_type_id')],
        ];
        $active_day = ActiveDayRequest::where($where)->count();
        if ($active_day == 0) {
            return false;
        }
        return true;
    }

    private function employeeHasTodayPermission($employee_id)
    {
        $where = [
            ['employee_id',$employee_id],
            ['approval1','<>','Rejected'],
            ['approval1','<>','Canceled'],            
            ['approval2','<>','Rejected'],            
            ['date_leave',request('date_leave')],
        ];
        
        $count =  LeavePermission::where($where)->count();
        
        if ($count >= 1) {
            return false;
        }
        return true;
    }
    private function checkDateRequest()
    {
        // if (request('dateLeave') > Carbon\Carbon::now()->addDays(7) ||request('date_leave') < Carbon\Carbon::now()->subDays(25)) {
        //     return false;
        // }
        return true;
    }

    private function haveBalance($employee_id)
    {
        $balance =  LeaveType::findOrFail(request('leave_type_id'))->have_balance;
        
        if ($balance == trans('staff::local.yes')) {
            $current = $this->getNumberRequestsInMonth($employee_id);
            
            $leave_balance = Employee::findOrFail($employee_id)->leave_balance;
            if (empty($leave_balance)) {
                return false;
            }
            if ($leave_balance <= $current) {
                return false;
            }            
        }
        return true;
    }

    private function hasDepartment($employee_id)
    {
        $department = Employee::findOrFail($employee_id)->department_id;
        if (empty($department)) {
            return false;
        }
        return true;
    }

    private function departmentHasBalance($employee_id)
    {
        $department_id = Employee::findOrFail($employee_id)->department_id;
        if (empty($department_id)) {
            return false;            
        }
        $leave_allocate = Department::findOrFail($department_id)->leave_allocate;
 
        $count = LeavePermission::whereHas('employee',function($q) use ($department_id){
            $q->where('department_id',$department_id);   
        })
        ->where('date_leave',request('date_leave'))
        ->where('approval2','Accepted')
        ->count();                         

        if ($leave_allocate <= $count ) {
            $this->department_name = $this->getDepartmentName($department_id);
            return false;
        }
        return true;
    }

    private function getAttendanceId($employee_id)
    {
        return Employee::findOrFail($employee_id)->attendance_id;
    }

    private function getNumberRequestsInMonth($employee_id)
    {
        $leave_type =  LeaveType::findOrFail(request('leave_type_id'));

        if (empty($leave_type)) {
            return false;            
        }
        
        // convert date leave from string to date
        $date_leave     = new DateTime(request('date_leave'));
        $day_leave      = $date_leave->format('d');
        $month_leave    = $date_leave->format('m');
        $now            = Carbon\Carbon::now();
        $this_month     = $now->month;
        $thisYear       = $now->year;
        $last_day_month = $now->endOfMonth()->isoFormat('Do');

        $from_day    = $leave_type->from_day;
        $to_day      = $leave_type->to_day;
        $period      = $leave_type->period;

        if ($period == 'Next Month')
        {
            if ($day_leave >= $from_day)
            {
                $this_month = $month_leave;
            }elseif ($day_leave < $from_day && $day_leave <= $to_day)
            {
                $this_month = $month_leave-1;
            }

            if ($this_month == 12) {
                $now->addYear();
                $thisYear =  $now->year;
            }else{
                $thisYear = $now->year;
            }

            $this->from_date = Carbon\Carbon::create( $thisYear, $this_month, $from_day , 0, 0, 0);
            $this->to_date = Carbon\Carbon::create( $thisYear, $this_month+1, $to_day , 0, 0, 0);
        }else{
            $this->from_date = Carbon\Carbon::create( $thisYear, $this_month, 1 , 0, 0, 0);
            $this->to_date = Carbon\Carbon::create( $thisYear, $this_month, $last_day_month , 0, 0, 0);
        }

        $where = [
            ['employee_id',$employee_id],
            ['approval1','Accepted'],
            ['approval2','Accepted'],
        ];
        return LeavePermission::where($where)
        ->whereBetween('date_leave', [$this->from_date->toDateString(), $this->to_date->toDateString()])
        ->count();        
    }

    private function getDepartmentName($department_id)
    {
        $department = Department::findOrFail($department_id);
        return session('lang') == 'ar'? $department->ar_department:$department->en_department ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LeavePermission  $leavePermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(LeavePermission $leavePermission)
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    LeavePermission::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function accept()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    LeavePermission::where('id',$id)->
                    update(['approval1'=>'Accepted','approval_one_user' => authInfo()->id]);
    
                    Deduction::where('leave_permission_id',$id)->
                    update(['approval1'=>'Accepted','approval_one_user' => authInfo()->id]);
                });
            }
        }
        return response(['status'=>true]);
    }

    public function reject()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    LeavePermission::where('id',$id)->
                    update(['approval1'=>'Rejected','approval2'=>'Pending','approval_one_user' => authInfo()->id]);
    
                    Deduction::where('leave_permission_id',$id)->
                    update(['approval1'=>'Rejected','approval2'=>'Pending','approval_one_user' => authInfo()->id]);
                });
            }
        }
        return response(['status'=>true]);
    }

    public function cancel()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    LeavePermission::where('id',$id)->
                    update(['approval1'=>'Canceled','approval2'=>'Pending','approval_one_user' => authInfo()->id]);

                    Deduction::where('leave_permission_id',$id)->
                    update(['approval1'=>'Canceled','approval2'=>'Pending','approval_one_user' => authInfo()->id]);
                });
            }
        }
        return response(['status'=>true]);
    }

    public function confirm()
    {
        if (request()->ajax()) {
            $data = LeavePermission::with('employee')->orderBy('id','desc')->where('approval1','Accepted')->get();
            return $this->dataTableApproval2($data);
        }
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::leave-permissions.confirm',
        ['title'=>trans('staff::local.confirm_requests'),'employees'=>$employees]);  
    }

    public function filterConfirm()
    {
        if (request()->ajax()) {
            $data = LeavePermission::with('employee')->orderBy('id','desc')
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
            $username = empty($data->approvalOne->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalOne->username;
            switch ($data->approval1) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-primary round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-warning round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.canceled'):                                 
                    return '<div class="badge badge-info round">
                                <span>'.trans('staff::local.canceled_done').'</span>
                                <i class="la la-hand-paper-o font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>' .$username;                         
            }
            
        })      
        ->addColumn('approval2',function($data){
            $username = empty($data->approvalTwo->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalTwo->username;
            switch ($data->approval2) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-success round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>'. $username;
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-danger round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>'. $username;
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>'. $username;                         
            }
            
        })                   
        ->addColumn('workingData',function($data){
            return $this->workingData($data);
        })                           
        ->addColumn('check', function($data){
               $btnCheck = '<label class="pos-rel">
                            <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                            <span class="lbl"></span>
                        </label>';
                return $btnCheck;
        })
        ->addColumn('leave_permission_id',function($data){
            return session('lang') == 'ar' ? $data->leaveType->ar_leave:$data->leaveType->ar_leave ;
        })
        ->rawColumns(['check','employee_name','attendance_id','workingData','approval1','approval2','leave_permission_id'])
        ->make(true);
    }

    public function acceptConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    $deduction = Deduction::where('leave_permission_id',$id)->update(['approval2'=>'Accepted','approval_two_user' => authInfo()->id]);
                    
                    LeavePermission::where('id',$id)->update(['approval2'=>'Accepted','approval_two_user' => authInfo()->id]);
                    $leave_permission = LeavePermission::findOrFail($id);
                    $employee = Employee::findOrFail($leave_permission->employee->id);
                    // notification  for permission                   
                    $user = Admin::findOrFail($employee->user_id);                
                    $data['icon']  = 'road';
                    $data['color'] = 'success';
                    $data['title'] = 'الاذونات';
                    $data['data']  = 'تم تسجيل اذن و الموافقة عليه بتاريخ ' . $leave_permission->date_leave . '<br> الساعه : ' .$leave_permission->time_leave;
                    $user->notify(new \App\Notifications\StaffNotification($data));
    
                    // notification  for deduction  
                    if ($deduction == 1) {
                        $user = Admin::findOrFail($employee->user_id);                
                        $data['icon']  = 'gavel';
                        $data['color'] = 'danger';
                        $data['title'] = 'الجزاءات';
                        $data['data']  = 'تم تسجيل جزاء واعتماده بتاريخ ' . $leave_permission->date_leave . '<br> اذن بخصم permission with deduction';
                        $user->notify(new \App\Notifications\StaffNotification($data));                    
                    }                 
                });
            }
        }
        return response(['status'=>true]);
    }
    public function rejectConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    LeavePermission::where('id',$id)->update(['approval2'=>'Rejected','approval_two_user' => authInfo()->id]);
                    $deduction = Deduction::where('leave_permission_id',$id)->update(['approval2'=>'Rejected','approval_two_user' => authInfo()->id]);
                    $leave_permission = LeavePermission::findOrFail($id);
                    $employee = Employee::findOrFail($leave_permission->employee->id);
    
                    // notification for permission                   
                    $user = Admin::findOrFail($employee->user_id);                
                    $data['icon']  = 'road';
                    $data['color'] = 'danger';
                    $data['title'] = 'الاذونات';
                    $data['data']  = 'تم رفض اذن بتاريخ ' . $leave_permission->date_leave . '<br> الساعه : ' .$leave_permission->time_leave;
                    $user->notify(new \App\Notifications\StaffNotification($data));

                    // notification  for deduction  
                    if ($deduction == 1) {
                        $user = Admin::findOrFail($employee->user_id);                
                        $data['icon']  = 'gavel';
                        $data['color'] = 'success';
                        $data['title'] = 'الجزاءات';
                        $data['data']  = 'تم الغاء الجزاء عبى الاذن بتاريخ ' . $leave_permission->date_leave;
                        $user->notify(new \App\Notifications\StaffNotification($data));                    
                    }
                });
            }
        }
        return response(['status'=>true]);
    }

    public function leaveDeduction()
    {
        if (request()->ajax()) {
            $data = Deduction::with('employee')->orderBy('id','desc')
            ->whereNotNull('leave_permission_id')
            ->where('approval1','Accepted')            
            ->get();
            
            return $this->dataTable($data);
        }
        $employees = Employee::work()->orderBy('attendance_id')->get();
        return view('staff::leave-permissions.leave-deduction',
        ['title'=>trans('staff::local.leave_deduction'),'employees'=>$employees]);  
    }
    private function dataTable($data)
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
            $username = empty($data->approvalOne->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalOne->username;
            switch ($data->approval1) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-primary round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-warning round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.canceled'):                                 
                    return '<div class="badge badge-info round">
                                <span>'.trans('staff::local.canceled_done').'</span>
                                <i class="la la-hand-paper-o font-medium-2"></i>
                            </div>' .$username;
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>' .$username;                         
            }
            
        })      
        ->addColumn('approval2',function($data){
            $username = empty($data->approvalTwo->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalTwo->username;
            switch ($data->approval2) {
                case trans('staff::local.accepted'): 
                    return '<div class="badge badge-success round">
                                <span>'.trans('staff::local.accepted_done').'</span>
                                <i class="la la-check font-medium-2"></i>
                            </div>'. $username;
                case trans('staff::local.rejected'):                                 
                     return '<div class="badge badge-danger round">
                                <span>'.trans('staff::local.rejected_done').'</span>
                                <i class="la la-close font-medium-2"></i>
                            </div>'. $username;
                case trans('staff::local.pending'):                                 
                    return '<div class="badge badge-dark round">
                                <span>'.trans('staff::local.pending').'</span>
                                <i class="la la-hourglass-1 font-medium-2"></i>
                            </div>'. $username;                         
            }
            
        })                   
        ->addColumn('workingData',function($data){
            return $this->workingData($data);
        })    
        ->addColumn('reason',function($data){
            return '<a href="#" onclick="reason('."'".$data->reason."'".')">'.trans('staff::local.reason').'</a>';
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
        ->rawColumns(['check','employee_name','attendance_id','workingData','approval1','approval2','reason'])
        ->make(true);
    }
    public function byEmployee()
    {
        if (request()->ajax()) {
            $data = LeavePermission::with('employee')->orderBy('id','desc')
            ->where('approval1',request('approval1'))
            ->where('employee_id',request('employee_id'))
            ->get();
            return $this-> dataTableApproval1($data);
        }
    }

    public function byEmployeeConfirm()
    {
        if (request()->ajax()) {
            $data = LeavePermission::with('employee')->orderBy('id','desc')
            ->where('approval1','Accepted')
            ->where('approval2',request('approval2'))
            ->where('employee_id',request('employee_id'))
            ->get();
            return $this-> dataTableApproval2($data);
        }
    }

    public function byEmployeeDeduction()
    {
        if (request()->ajax()) {
            $data = Deduction::with('employee')->orderBy('id','desc')
            ->whereNotNull('leave_permission_id')
            ->where('employee_id',request('employee_id'))            
            ->get();
            return $this->dataTable($data);
        }
    }
    
    public function profile()
    {
        if (request()->ajax()) {
            $data = LeavePermission::orderBy('id','desc')            
            ->where('employee_id',request('employee_id'))
            ->get();
            return datatables($data)
                ->addIndexColumn()                                 
                
                ->addColumn('approval1',function($data){
                    $username = empty($data->approvalOne->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalOne->username;
                    switch ($data->approval1) {
                        case trans('staff::local.accepted'): 
                            return '<div class="badge badge-primary round">
                                        <span>'.trans('staff::local.accepted_done').'</span>
                                        <i class="la la-check font-medium-2"></i>
                                    </div>' .$username;
                        case trans('staff::local.rejected'):                                 
                            return '<div class="badge badge-warning round">
                                        <span>'.trans('staff::local.rejected_done').'</span>
                                        <i class="la la-close font-medium-2"></i>
                                    </div>' .$username;
                        case trans('staff::local.canceled'):                                 
                            return '<div class="badge badge-info round">
                                        <span>'.trans('staff::local.canceled_done').'</span>
                                        <i class="la la-hand-paper-o font-medium-2"></i>
                                    </div>' .$username;
                        case trans('staff::local.pending'):                                 
                            return '<div class="badge badge-dark round">
                                        <span>'.trans('staff::local.pending').'</span>
                                        <i class="la la-hourglass-1 font-medium-2"></i>
                                    </div>' .$username;                         
                    }
                    
                })      
                ->addColumn('approval2',function($data){
                    $username = empty($data->approvalTwo->username)?'':'<br><strong>' . trans('admin.by') . '</strong> : ' .$data->approvalTwo->username;
                    switch ($data->approval2) {
                        case trans('staff::local.accepted'): 
                            return '<div class="badge badge-success round">
                                        <span>'.trans('staff::local.accepted_done').'</span>
                                        <i class="la la-check font-medium-2"></i>
                                    </div>'. $username;
                        case trans('staff::local.rejected'):                                 
                            return '<div class="badge badge-danger round">
                                        <span>'.trans('staff::local.rejected_done').'</span>
                                        <i class="la la-close font-medium-2"></i>
                                    </div>'. $username;
                        case trans('staff::local.pending'):                                 
                            return '<div class="badge badge-dark round">
                                        <span>'.trans('staff::local.pending').'</span>
                                        <i class="la la-hourglass-1 font-medium-2"></i>
                                    </div>'. $username;                         
                    }
                    
                })                                   
                ->addColumn('leave_permission_id',function($data){
                    return session('lang') == 'ar' ? $data->leaveType->ar_leave:$data->leaveType->ar_leave ;
                })
                ->rawColumns(['approval1','approval2','leave_permission_id'])
                ->make(true);
        }
    }
    
}
