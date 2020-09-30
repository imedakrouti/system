<?php

namespace Student\Http\Controllers\Setting;
use App\Http\Controllers\Controller;
use Student\Models\Students\ReportContent;

class ReportContentController extends Controller
{
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
}
