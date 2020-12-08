<?php
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent\Student'],function(){
    // virtual classroom
    Route::get('student/view-schedule','VirtualClassroomController@viewSchedule')->name('student.view-schedule');      
    Route::get('student/join-classroom','VirtualClassroomController@joinClassroom')->name('student.join-classroom');      
    Route::get('student/live-classroom/{employee_id}/{zoom_schedule_id}','VirtualClassroomController@liveClassroom')->name('student.live-classroom');      
});