<?php
    Route::group(['namespace'=>'Dashboard'],function(){
        // e-learning dashboard
        Route::get('/dashboard/e-learning','LearningDashboardController@dashboard')->name('dashboard.learning');
        Route::get('/dashboard/get/all-virtual-classrooms','LearningDashboardController@virtualClassroomsSchedule')->name('dashboard.virtual-classrooms');
        Route::get('/dashboard/view/page/virtual-classrooms','LearningDashboardController@virtualClassroomsPage')->name('virtual-classrooms.page');
        Route::get('/dashboard/all-virtual-classrooms','LearningDashboardController@viewVirtualClassrooms')->name('view.virtual-classrooms');
        Route::get('/dashboard/recent-lessons','LearningDashboardController@recentLessons')->name('dashboard.recent-lessons');
        

    
    });  