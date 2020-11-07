<?php

namespace Staff\Http\Controllers\Payroll;
use App\Http\Controllers\Controller;
use Staff\Models\Employees\Employee;
use Staff\Models\Payrolls\PayrollComponent;
use Staff\Models\Payrolls\PayrollSheet;
use Staff\Models\Settings\HrReport;
use PDF;

class PayrollReportController extends Controller
{
    public function bankReport($code)
    {
        $title = trans('staff::local.payroll_bank');
        $payroll_components = PayrollComponent::where('code',$code)->first();
        $payroll_sheet = PayrollSheet::findOrFail($payroll_components->payroll_sheet_id);
        $sheet_name = session('lang') == 'ar' ? $payroll_sheet->ar_sheet_name :$payroll_sheet->en_sheet_name ;
        $period = $payroll_components->period;
        $where = [
            ['payroll_components.code',$code],
            ['payroll_components.salary_mode','Bank'],
            ['payroll_components.calculate','net'],
            ['payroll_components.value','>',0],
        ];
        $employees = Employee::with('sector','section','department','position')
        ->join('payroll_components','employees.id','=','payroll_components.employee_id')  
        ->where($where)            
        ->orderBy('employees.attendance_id')
        ->get();        
            
        return view('staff::payrolls.reports.bank',
        compact('title','code','employees','sheet_name','period'));        
    } 
    public function cashReport($code)
    {
        $title = trans('staff::local.payroll_bank');
        $payroll_components = PayrollComponent::where('code',$code)->first();
        $payroll_sheet = PayrollSheet::findOrFail($payroll_components->payroll_sheet_id);
        $sheet_name = session('lang') == 'ar' ? $payroll_sheet->ar_sheet_name :$payroll_sheet->en_sheet_name ;
        $period = $payroll_components->period;
        $where = [
            ['payroll_components.code',$code],
            ['payroll_components.salary_mode','Cash'],
            ['payroll_components.calculate','net'],
            ['payroll_components.value','>',0],
        ];
        $employees = Employee::with('sector','section','department','position')
        ->join('payroll_components','employees.id','=','payroll_components.employee_id')  
        ->where($where)            
        ->orderBy('employees.attendance_id')
        ->get();  

        $total = PayrollComponent::where($where)->sum('value');        
        
        $header = HrReport::first()->header;        
        $data = [         
            'title'                => trans('staff::local.payroll_cash'),                   
            'logo'                 => logo(),            
            'header'               => $header,                
            'sheet_name'           => $sheet_name,                
            'period'               => $period,                                   
            'employees'            => $employees,            
            'total'                => $total            
        ];

        $config = [
            'orientation'          => 'P',
            'margin_header'        => 5,
            'margin_footer'        => 30,
            'margin_left'          => 10,
            'margin_right'         => 10,
            'margin_top'           => 75,// pdf on server required this sizes
            'margin_bottom'        => session('lang') == 'ar' ? 40 : 45,  // pdf on server required this sizes
        ]; 

        // to avoid error timeout
        ini_set('max_execution_time', '300');
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf = PDF::loadView('staff::payrolls.reports.cash', $data,[],$config);
        return $pdf->stream(trans('staff::local.payroll_cash'));
            
       
    } 

}
