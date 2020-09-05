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
});