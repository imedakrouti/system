<?php
/**
 * LOGIN
 * LANG
 * CHANGE PASSWORD
 * UPDATE SETTINGS
 * USER PROFILE
 * CREATE NEW USER
 * NOTIFICATIONS
 * LOGS
 * 
 */
Route::group(['prefix' => 'admin','namespace' => 'Admin'],function(){
    // ========================================= CONFIGURATIONS ======================================
        Config::set('auth.defaults.guard','admin');
        Config::set('auth.defaults.passwords','users');
    // ========================================= END CONFIGURATIONS ==================================
    // ========================================= LANG ================================================
        Route::get('lang/{lang}','ClosureController@lang');        
    // ========================================= END LANG ============================================

    // ========================================= LOGIN ===============================================
        Route::get('/login','AdminAuth@login');
        Route::post('/signIn','AdminAuth@setLogin')->name('setLogin');

        Route::get('/','ClosureController@checkLogin');            

    // ================================= LOGOUT ==============================================

    Route::group(['middleware'=>['admin']],function(){
            Route::any('/logout','AdminAuth@logout')->name('logout');
            Route::get('/','DashboardController@index');
            // dashboards
            Route::get('/dashboard','DashboardController@index')->name('main.dashboard');
                        

            // change password
            Route::get('/password','AdminAuth@changePassword');
            Route::post('/update/password','AdminAuth@updateChangePassword')->name('update.password');

            // update settings
            Route::get('/settings','SettingController@siteSettingPage')->name('site.settings');
            Route::post('update/settings','SettingController@updateSettings')->name('update.settings');

            // admin
            Route::resource('/accounts','AdminController')->except('show','destroy');
            Route::post('accounts/destroy','AdminController@destroy')->name('accounts.destroy');
            // user profile
            Route::get('user-profile','AdminController@userProfile')->name('user-profile');
            Route::post('user-profile','AdminController@updateProfile')->name('update.profile');

            // notifications
            Route::get('all/user/notification','NotificationController@userNotifications')->name('user.notifications');
            Route::get('view/all','NotificationController@viewNotifications')->name('view.notifications');
            Route::get('delete/all','NotificationController@delete')->name('delete.notifications');
            Route::get('read/all','NotificationController@markAsRead')->name('read.notifications');

            // logs
            Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
        });
});

// Route::get('/test',function()
// {
//     dd(authInfo()->user->ar_st_name);
// });
