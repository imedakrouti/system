<?php
    Route::group(['namespace'=>'Dashboard'],function(){
        // e-learning dashboard
        Route::get('/dashboard/e-learning','LearningDashboardController@dashboard')->name('dashboard.learning');

    
    });  