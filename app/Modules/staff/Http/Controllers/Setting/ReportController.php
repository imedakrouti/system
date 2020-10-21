<?php

namespace Staff\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Staff\Models\Settings\HrReport;

class ReportController extends Controller
{
    public function hrLetter()
    {
        $title = trans('staff::local.hr_letter_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.hr-letter',
        compact('title','content'));
    }
    public function updateHrLetter()
    {
        $report = HrReport::first();
        $report->update(request()->only(['hr_letter'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('hr-letter.get');  
    }

    public function hrLeave()
    {
        $title = trans('staff::local.employee_leave_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.employee-leave',
        compact('title','content'));
    }
    public function updateLeave()
    {
        $report = HrReport::first();
        $report->update(request()->only(['employee_leave'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('employee-leave.get');  
    }

    public function hrExperience()
    {
        $title = trans('staff::local.employee_experience_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.employee-experience',
        compact('title','content'));
    }
    public function updateHrExperience()
    {
        $report = HrReport::first();
        $report->update(request()->only(['employee_experience'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('employee-experience.get');  
    }

    public function hrVacation()
    {
        $title = trans('staff::local.employee_vacation_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.employee-vacation',
        compact('title','content'));
    }
    public function updateHrVacation()
    {
        $report = HrReport::first();
        $report->update(request()->only(['employee_vacation'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('employee-vacation.get');  
    }

    public function hrLoan()
    {
        $title = trans('staff::local.employee_loan_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.employee-loan',
        compact('title','content'));
    }
    public function updateHrLoan()
    {
        $report = HrReport::first();
        $report->update(request()->only(['employee_loan'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('employee-loan.get');  
    }

    public function header()
    {
        $title = trans('staff::local.header_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.header',
        compact('title','content'));
    }
    public function updateHeader()
    {
        $report = HrReport::first();
        $report->update(request()->only(['header'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('header.get');  
    }

    public function footer()
    {
        $title = trans('staff::local.footer_form');
        $content = HrReport::first();
        return view('staff::settings.reports-forms.footer',
        compact('title','content'));
    }
    public function updateFooter()
    {
        $report = HrReport::first();
        $report->update(request()->only(['footer'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('footer.get');  
    }
}
