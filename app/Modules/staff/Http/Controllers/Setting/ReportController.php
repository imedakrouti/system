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
}
