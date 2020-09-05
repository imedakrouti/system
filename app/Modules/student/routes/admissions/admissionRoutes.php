<?php
Route::group(['namespace'=>'Admissions'],function(){
    // Interviews Dates
    Route::resource('/meetings','MeetingController')->except('destroy','show');
    Route::post('/meetings/destroy','MeetingController@destroy')->name('meetings.destroy');
    Route::get('all/meetings','MeetingController@showMeetings')->name('show.meetings');
    Route::get('meetings/fathers/all/{id}','MeetingController@fatherMeetings')->name('father.meetings');
    Route::post('meetings/father-attend', 'MeetingController@fatherAttend')->name('father.attend');
    Route::post('meetings/father-canceled', 'MeetingController@fatherCanceled')->name('father.canceled');
    Route::post('meetings/father-pending', 'MeetingController@fatherPending')->name('father.pending');
    // Parent Reports
    Route::resource('/parent-reports','ParentReportController')->except('destroy');
    Route::post('/parent-reports/destroy','ParentReportController@destroy')->name('parent-reports.destroy');
    Route::get('/parent-reports/pdf/{id}','ParentReportController@parentReportPdf')->name('parent-reports.pdf');    
    Route::get('/parent-reports/father/{id}','ParentReportController@fatherReport')->name('father.report');    
    
    // Student Reports
    Route::resource('/student-reports','StudentReportController')->except('destroy');
    Route::delete('/student-reports/destroy/{id}','StudentReportController@destroy')->name('student-reports.destroy');    
    Route::get('/student-reports/pdf/{id}','StudentReportController@parentReportPdf')->name('student-reports.pdf');    
});