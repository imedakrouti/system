<?php
    Route::group(['namespace'=>'Dashboard'],function(){
        // dashboard
        Route::get('/dashboard/admission','AdmissionDashController@dashboard')->name('dashboard.admission');
        Route::get('/dashboard/applicants-divisions','AdmissionDashController@applicantsByDivision')->name('applicants-counts.divisions');
        Route::get('/dashboard/applicants-today','AdmissionDashController@applicantsToday')->name('applicants.today');
        Route::put('/dashboard/applicants/divisions/filter','AdmissionDashController@find')->name('applicants.find');
        
    
    });  