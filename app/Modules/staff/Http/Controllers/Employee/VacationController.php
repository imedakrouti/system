<?php

namespace Staff\Http\Controllers\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\VacationRequest;
use App\Models\Admin;
use DateInterval;
use DatePeriod;
use DateTime;
use DB;
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
            $data = Vacation::with('employee')->orderBy('id','desc')->where('approval2','<>','Accepted')->where('approval2','<>','Rejected')->get();
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
            ->where('approval2','<>','Accepted')->get();
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

         return $interval->invert == 0 ? $interval->format('%a') +1 : 'invalid';//now do whatever you like with $days
    }

    public function store(VacationRequest $request)
    {         
        if ($this-> getDaysCount() == 'invalid' ) {
            toast(trans('staff::local.invalid_vacation_period'),'error');
            return back()->withInput();
        } 

        if (request()->hasFile('file_name')) {
            if (count(request('employee_id')) > 1) {
                toast(trans('staff::local.invalid_number_employees'),'error');
                return back()->withInput();
            }
            $this->file_name = uploadFileOrImage(null,request('file_name'),'images/attachments');             
        }    

        foreach (request('employee_id') as $employee_id) {   
            $employee = Employee::findOrFail($employee_id);
            $vacation_allocated = $employee->vacation_allocated;

            $message = '';

            if ($vacation_allocated < $this->getDaysCount()+1) {
                $message .= ' [' .$employee->attendance_id . ' ]';
            }else{
                $vacation = $request->user()->vacations()->firstOrCreate($request->only($this->attributes())+
                [                    
                    'employee_id'       => $employee_id,
                    'file_name'         => $this->file_name,
                    'count'             => $this-> getDaysCount(),
                ]);    
                $this->InsertVacationPeriod($vacation,$employee_id);  
                
                // notification

                // deduct from vacation allocated
                Employee::where('id',$employee_id)->
                update(['vacation_allocated'=>($vacation_allocated - $this->getDaysCount()) ]);
            }
        }        
        toast(trans('msg.stored_successfully') . ' - ' .trans('staff::local.check_vacation_balance').$message,'success');
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
                    $vacation = Vacation::findOrFail($id);
                    
                    $file_path = public_path()."/images/attachments/".$vacation->file_name;                                                             
                    removeFileOrImage($file_path); // remove file from directory                    
                    if ($vacation->approval1 == trans('staff::local.accepted') || 
                    $vacation->approval1 == trans('staff::local.pending')) {
                        $employee = Employee::findOrFail($vacation->employee->id);
                        Employee::where('id',$employee->id)
                        ->update(['vacation_allocated'=> ($employee->vacation_allocated + $vacation->count )]);
                        Vacation::where('id',$id)->update(['approval1'=>'Canceled','approval2'=>'Pending']);
                    }
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
                $vacation = Vacation::findOrFail($id);
                if ($vacation->approval1 == trans('staff::local.rejected')|| 
                $vacation->approval1 == trans('staff::local.canceled')) {
                    $employee = Employee::findOrFail($vacation->employee->id);
                    Employee::where('id',$employee->id)
                    ->update(['vacation_allocated'=> ($employee->vacation_allocated - $vacation->count )]);
                }
                Vacation::where('id',$id)->update(['approval1'=>'Accepted','approval_one_user' => authInfo()->id]);
            }
        }
        return response(['status'=>true]);
    }
    public function reject()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    $vacation = Vacation::findOrFail($id);
                    if (($vacation->approval1 == trans('staff::local.accepted')|| $vacation->approval1 == trans('staff::local.pending')) &&
                    ($vacation->approval2 != trans('staff::local.rejected') || $vacation->approval2 == trans('staff::local.pending'))) {

                        $employee = Employee::findOrFail($vacation->employee->id);
                        Employee::where('id',$employee->id)
                        ->update(['vacation_allocated'=> ($employee->vacation_allocated + $vacation->count )]);
                    }
                    Vacation::where('id',$id)
                    ->update(['approval1'=>'Rejected','approval2'=>'Pending','approval_one_user' => authInfo()->id]);                         
                });
            }
        }
        return response(['status'=>true,'msg'=>trans('staff::local.rejected_successfully')]);
    }
    public function cancel()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                DB::transaction(function() use ($id){
                    $vacation = Vacation::findOrFail($id);
                    if ($vacation->approval1 == trans('staff::local.accepted')|| 
                    $vacation->approval1 == trans('staff::local.pending')) {
                        $employee = Employee::findOrFail($vacation->employee->id);
                        Employee::where('id',$employee->id)
                        ->update(['vacation_allocated'=> ($employee->vacation_allocated + $vacation->count )]);
                    }
                    Vacation::where('id',$id)
                    ->update(['approval1'=>'Canceled','approval2'=>'Pending','approval_one_user' => authInfo()->id]);
                });                
            }
        }
        return response(['status'=>true,'msg'=>trans('staff::local.canceled_successfully')]);
    }

    public function confirm()
    {
        if (request()->ajax()) {
            $data = Vacation::with('employee','admin')->orderBy('id','desc')->where('approval1','Accepted')->get();
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
            $data = Vacation::with('employee','admin')->orderBy('id','desc')
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
                $vacation = Vacation::findOrFail($id);
                $employee = Employee::findOrFail($vacation->employee->id);
                
                if ($vacation->approval2 == trans('staff::local.rejected')) {
                    Employee::where('id',$employee->id)
                    ->update(['vacation_allocated'=> ($employee->vacation_allocated - $vacation->count )]);
                    
                    // notification                    
                    $user = Admin::findOrFail($employee->user_id);                
                    $data['icon']  = 'plane';
                    $data['color'] = 'warning';
                    $data['title'] = 'الاجازات';
                    $data['data']  = 'تم تسجل الاجازة واعتمادها خلال الفترة ما بين ' . $vacation->from_date . ' و ' . $vacation->to_date;                
                    $user->notify(new \App\Notifications\StaffNotification($data));
                }
                Vacation::where('id',$id)->update(['approval2'=>'Accepted','approval_two_user' => authInfo()->id]);
            }
        }
        return response(['status'=>true]);
    }
    public function rejectConfirm()
    {
        if (request()->ajax()) {
            foreach (request('id') as $id) {
                
                $vacation = Vacation::findOrFail($id);
                if ($vacation->approval1 == trans('staff::local.accepted')|| 
                $vacation->approval1 == trans('staff::local.pending') ||$vacation->approval2 == trans('staff::local.accepted')|| 
                $vacation->approval2 == trans('staff::local.pending')) {
                    $employee = Employee::findOrFail($vacation->employee->id);
                    Employee::where('id',$employee->id)
                    ->update(['vacation_allocated'=> ($employee->vacation_allocated + $vacation->count )]);

                    // notification                    
                    $user = Admin::findOrFail($employee->user_id);                
                    $data['icon']  = 'plane';
                    $data['color'] = 'danger';
                    $data['title'] = 'الاجازات';
                    $data['data']  = 'تم رفض الاجازة خلال الفترة ما بين ' . $vacation->from_date . ' و ' . $vacation->to_date;                
                    $user->notify(new \App\Notifications\StaffNotification($data));
                }
                Vacation::where('id',$id)->update(['approval2'=>'Rejected']);
            }
        }
        return response(['status'=>true,'msg'=>trans('staff::local.rejected_successfully'),'approval_two_user' => authInfo()->id]);
    }

    public function balance()
    {
        $sectors = Sector::sort()->get();
        $departments = Department::sort()->get();
        $sections = Section::sort()->get();
        $positions = Position::sort()->get();
        $employees = Employee::work()->get();
        $title = trans('staff::local.vacation_balance');
        return view('staff::vacations.balance',
        compact('sectors','departments','sections','positions','employees','title'));

    }
    public function setBalance()
    {        
        if (request('execute_type') == 'employees') {
            foreach (request('employee_id') as $employee_id) {
                $vacation_allocated = Employee::findOrFail($employee_id)->vacation_allocated;
                $balance_allocated = request('old_vacation') == 'true' ? $vacation_allocated + request('vacation_balance')
                :request('vacation_balance');                
                Employee::where('hiring_date','<=',request('set_date'))
                ->where('id',$employee_id)
                ->update(['vacation_allocated'=>$balance_allocated]);
            }
        }else{
            $employees = Employee::work()->get();
            foreach ($employees as $employee) {
                $vacation_allocated = $employee->vacation_allocated;
                $balance_allocated = request('old_vacation') == 'true' ? $vacation_allocated + request('vacation_balance')
                :request('vacation_balance'); 

                Employee::where('hiring_date','<=',request('set_date'))
                ->where('id',$employee->id)
                ->where('department_id',request('department_id'))
                ->update(['vacation_allocated'=>$balance_allocated]);
            }
        }
        toast(trans('staff::local.set_vacation_balance'),'success');
        return redirect()->route('vacations.balance');
    }
}
