<?php
    Route::group(['namespace'=>'Dashboard'],function(){
        // admission dashboard
        Route::get('/dashboard/staff','StaffDashboardController@dashboard')->name('dashboard.staff');
        Route::get('/dashboard/teacher','StaffDashboardController@teacherDashboard')->name('dashboard.teacher');
        
        Route::get('/dashboard/next-classroom','StaffDashboardController@nextVirtualClassroom')->name('next-virtual-classroom');
        Route::get('/dashboard/announcements','StaffDashboardController@announcements')->name('announcements');
    
    });  