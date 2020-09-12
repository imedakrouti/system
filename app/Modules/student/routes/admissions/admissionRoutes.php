<?php
Route::group(['namespace'=>'Admissions'],function(){
    // Interviews Dates
    Route::resource('/meetings','MeetingController')->except('destroy','show');
    Route::post('/meetings/destroy','MeetingController@destroy')->name('meetings.destroy');    
    Route::get('meetings/fathers/all/{id}','MeetingController@fatherMeetings')->name('father.meetings');
    Route::post('meetings/father-attend', 'MeetingController@fatherAttend')->name('father.attend');
    Route::post('meetings/father-canceled', 'MeetingController@fatherCanceled')->name('father.canceled');
    Route::post('meetings/father-pending', 'MeetingController@fatherPending')->name('father.pending');

    // Calendar 
    Route::get('calendar/meetings','CalendarController@showMeetings')->name('calendar.index');

    // Parent Reports
    Route::resource('/parent-reports','ParentReportController')->except('destroy');
    Route::post('/parent-reports/destroy','ParentReportController@destroy')->name('parent-reports.destroy');
    Route::get('/parent-reports/pdf/{id}','ParentReportController@parentReportPdf')->name('parent-reports.pdf');    
    Route::get('/parent-reports/father/{id}','ParentReportController@fatherReport')->name('father.report');    
    
    // Student Reports
    Route::resource('/student-reports','StudentReportController')->except('destroy');
    Route::post('/student-reports/destroy','StudentReportController@destroy')->name('student-reports.destroy');    
    Route::get('/student-reports/pdf/{id}','StudentReportController@studentReportPdf')->name('student-reports.pdf');    
    Route::get('/student-reports/student/{id}','StudentReportController@studentReport')->name('student.report');   
    
    // Employee open admission
    Route::get('/employee-admission/','EmployeeAdmissionController@bonus')->name('employee-admission');   
    Route::put('/employee-admission/find','EmployeeAdmissionController@find')->name('employee-admission.find');   
    Route::get('/employee-admission/report','EmployeeAdmissionController@report')->name('emp-open.print');   

    
});
