<?php
    Route::group(['namespace'=>'Dashboard'],function(){
        // dashboard
        Route::get('/dashboard/admission','AdmissionDashController@dashboard')->name('dashboard.admission');
    
    });  