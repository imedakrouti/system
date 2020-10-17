<?php
    Route::group(['namespace'=>'Dashboard'],function(){
        // admission dashboard
        Route::get('/dashboard/staff','StaffDashboardController@dashboard')->name('dashboard.staff');

    
    });  