<?php
namespace Staff\Http\Controllers\Payroll;
use App\Http\Controllers\Controller;
use App\Http\Requests\PayrollSheetRequest;
use Staff\Models\Employees\Employee;
use Staff\Models\Payrolls\PayrollSheet;
use Staff\Models\Payrolls\PayrollSheetEmployee;

class PayrollSheetController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = PayrollSheet::with('admin')->get();
            return datatables($data)
                    ->addIndexColumn()
                    ->addColumn('username',function($data){
                        return $data->admin->username . '<br>' . $data->created_at;
                    })
                    ->addColumn('add_employees',function($data){
                        return '<a href="'.route('payrolls-sheets.add-employees-page',$data->id).'" class="btn btn-purple">'.trans('staff::local.add_employees').'</a>';
                    })
                    ->addColumn('employee_count',function($data){
                        $count = PayrollSheetEmployee::where('payroll_sheet_id',$data->id)->count();
                        return '<div class="badge badge-primary round">
                                    <span>'.$count.'</span>
                                    <i class="la la-user"></i>
                                </div>';
                    })
                    ->addColumn('check', function($data){
                           $btnCheck = '<label class="pos-rel">
                                        <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                        <span class="lbl"></span>
                                    </label>';
                            return $btnCheck;
                    })
                    ->addColumn('action', function($data){
                        return '<a class="btn btn-warning btn-sm" href="'.route('payrolls-sheets.edit',$data->id).'">
                                <i class=" la la-edit"></i>
                            </a>';                           
                        })
                    ->rawColumns(['check','username','add_employees','employee_count','action'])
                    ->make(true);
        }
        return view('staff::payrolls.payrolls-sheets.index',
        ['title'=>trans('staff::local.payrolls_sheets')]);   
    }
    public function create()
    {
        $title = trans('staff::local.new_payroll_sheet');        
        return view('staff::payrolls.payrolls-sheets.create',
        compact('title'));
    }

    private function attributes()
    {
        return [
            'ar_sheet_name',
            'en_sheet_name',
            'from_day',
            'to_day',
            'end_period',
            'admin_id',
        ];
    }
    public function store(PayrollSheetRequest $request)
    {        
        $request->user()->payrollSheet()->create($request->only($this->attributes()));    
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('payrolls-sheets.index');     
    }
    public function edit($id)
    {
        $payroll_sheet_id = PayrollSheet::findOrFail($id);
        $title = trans('staff::local.edit_payroll_sheet');        
        return view('staff::payrolls.payrolls-sheets.edit',
        compact('title','payroll_sheet_id'));
    }
    public function update(PayrollSheetRequest $request , $id)
    {
        $payroll_sheet_id = PayrollSheet::findOrFail($id);
        $payroll_sheet_id->update($request->only($this->attributes()));
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('payrolls-sheets.index');
    }
    
    public function destroy()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    PayrollSheet::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }

    public function addEmployeesPage($payroll_sheet_id)
    {
        $sheet = PayrollSheet::findOrFail($payroll_sheet_id);
        $sheet_name = session('lang') == 'ar' ? $sheet->ar_sheet_name : $sheet->en_sheet_name;
        $title = trans('staff::local.add_employees_to_payroll');        
        return view('staff::payrolls.payrolls-sheets.add-employees.index',
        compact('title','payroll_sheet_id','sheet_name'));
    }
    public function employeesPayrollSheet($payroll_sheet_id)
    {        
        $data = PayrollSheetEmployee::with('admin','employees')->get();
        return datatables($data)
                ->addIndexColumn()
                ->addColumn('username',function($data){
                    return $data->admin->username . '<br>' . $data->created_at;
                })
                ->addColumn('employee_name',function($data){
                    return $this->getFullEmployeeName($data->employees);
                })
                ->addColumn('working_data',function($data){
                    return $this->workingData($data->employees);
                })    
                ->addColumn('salary',function($data){
                    return $data->employees->salary;
                })            
                ->addColumn('position',function($data){
                    return !empty($data->employees->position->ar_position)?
                    (session('lang') == 'ar'?$data->employees->position->ar_position:$data->employees->position->en_position):'';
                })
                ->addColumn('check', function($data){
                       $btnCheck = '<label class="pos-rel">
                                    <input type="checkbox" class="ace" name="id[]" value="'.$data->id.'" />
                                    <span class="lbl"></span>
                                </label>';
                        return $btnCheck;
                })
                ->rawColumns(['check','username','employee_name','working_data','position','salary'])
                ->make(true);
    }
    private function getFullEmployeeName($data)
    {
        $employee_name = '';
        if (session('lang') == 'ar') {
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->ar_st_name . ' ' . $data->ar_nd_name.
            ' ' . $data->ar_rd_name.' ' . $data->ar_th_name.'</a>';
        }else{
            $employee_name = '<a target="blank" href="'.route('employees.show',$data->id).'">' .$data->en_st_name . ' ' . $data->en_nd_name.
            ' ' . $data->th_rd_name.' ' . $data->th_th_name.'</a>';
        }
        return $employee_name;
    }
    private function workingData($data)
    {
        $sector = '';
        if (!empty($data->sector->ar_sector)) {
            $sector = session('lang') == 'ar' ?  '<span class="blue">'.$data->sector->ar_sector . '</span>': '<span class="blue">'.$data->sector->en_sector . '</span>';            
        }
        $department = '';
        if (!empty($data->department->ar_department)) {
            $department = session('lang') == 'ar' ?  '<span class="purple">'.$data->department->ar_department . '</span>': '<span class="blue">'.$data->department->en_department . '</span>';            
        }
        $section = '';
        if (!empty($data->section->ar_section)) {
            $section = session('lang') == 'ar' ?  '<span class="red">'.$data->section->ar_section . '</span>': '<span class="blue">'.$data->section->en_section . '</span>';            
        }
        return $sector . ' '. $department . '<br>' .  $section ;
    }

    public function addEmployeesToSheet($payroll_sheet_id)
    {      
        $sheet = PayrollSheet::findOrFail($payroll_sheet_id);
        $sheet_name = session('lang') == 'ar' ? $sheet->ar_sheet_name : $sheet->en_sheet_name;  
        $employees = Employee::work()->orderBy('attendance_id')->get();
        $title = trans('staff::local.add_employees_to_payroll');        
        return view('staff::payrolls.payrolls-sheets.add-employees.create',
        compact('title','payroll_sheet_id','employees','sheet_name'));
    }
    private function attributesPayrollEmployeeSheet()
    {
        return [            
            'payroll_sheet_id',            
        ];
    }
    
    public function storeEmployeeIntoSheet()
    {        
        foreach (request('employee_id') as $employee_id) {            
            request()->user()->payrollSheetEmployee()->firstOrCreate(request()->only($this->attributesPayrollEmployeeSheet())+
            [
                'employee_id'   => $employee_id,                
            ]);    
        }
        toast(trans('msg.stored_successfully'),'success');
        return redirect()->route('payrolls-sheets.add-employees-page',request('payroll_sheet_id')); 
    }
    public function removeEmployeeFromSheet()
    {
        if (request()->ajax()) {
            if (request()->has('id'))
            {
                foreach (request('id') as $id) {                    
                    PayrollSheetEmployee::destroy($id);
                }
            }
        }
        return response(['status'=>true]);
    }
}
