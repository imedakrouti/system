<?php
Route::group(['namespace'=>'Admissions'],function(){
    // Interviews Dates
    Route::resource('/meetings','MeetingController')->except('destroy','show');
    Route::post('/meetings/destroy','MeetingController@destroy')->name('meetings.destroy');
    Route::get('all/meetings','MeetingController@showMeetings')->name('show.meetings');
});