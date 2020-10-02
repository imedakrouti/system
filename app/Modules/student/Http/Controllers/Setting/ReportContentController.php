<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Models\Students\ReportContent;

class ReportContentController extends Controller
{
    public function leaveRequest()
    {
        $title = trans('student::local.leave_request_form');
        $content = ReportContent::first();
        return view('student::settings.reports-forms.endorsement',
        compact('title','content'));
    }
    public function updateLeaveRequests()
    {
        $reportContent = ReportContent::first();
        $reportContent->update(request()->only(['endorsement'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('leave-request.get');  
    }

    public function dailyRequest()
    {
        $title = trans('student::local.daily_request_form');
        $content = ReportContent::first();
        return view('student::settings.reports-forms.daily-request',
        compact('title','content'));
    }
    public function updateDailyRequests()
    {
        $reportContent = ReportContent::first();
        $reportContent->update(request()->only(['daily_request'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('daily-request.get');  
    }

    public function proofEnrollmentRequest()
    {
        $title = trans('student::local.proof_enrollment_form');
        $content = ReportContent::first();
        return view('student::settings.reports-forms.proof-enrollment',
        compact('title','content'));
    }
    public function updateProofEnrollmentRequests()
    {
        $reportContent = ReportContent::first();
        $reportContent->update(request()->only(['proof_enrollment'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('proof-enrollment.get');  
    }   
    
    public function parentRequest()
    {
        $title = trans('student::local.parent_request_form');
        $content = ReportContent::first();
        return view('student::settings.reports-forms.parent-request',
        compact('title','content'));
    }
    public function updateParentRequests()
    {
        $reportContent = ReportContent::first();
        $reportContent->update(request()->only(['parent_request'])); 
        toast(trans('msg.updated_successfully'),'success');
        return redirect()->route('parent-request.get');  
    }
}
