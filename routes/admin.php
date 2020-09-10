<?php
Route::group(['prefix' => 'admin','namespace' => 'Admin'],function(){
    // ========================================= CONFIGURATIONS ======================================
        Config::set('auth.defaults.guard','admin');
        Config::set('auth.defaults.passwords','users');
    // ========================================= END CONFIGURATIONS ==================================
    // ========================================= LANG ================================================
        Route::get('lang/{lang}',function($lang){
            // check session lang and destroy session
            $data['lang'] = $lang;

            if (adminAuth()->check()) {
                \App\Models\Admin::where('id',authInfo()->id)->update($data);
            }

            session()->has('lang')?session()->forget('lang'):'';
            // set new session
            $lang == 'ar' || $lang == trans('admin.ar') ? session()->put('lang','ar'):session()->put('lang','en');
            //return to previous page
            return back();
        });
    // ========================================= END LANG ============================================

    // ========================================= LOGIN ===============================================
        Route::get('/login','AdminAuth@login');
        Route::post('/signIn','AdminAuth@setLogin')->name('setLogin');

        Route::get('/',function(){

            if (session()->has('login')) {
                if (adminAuth()->check()) {
                    Route::get('/dashboard','DashboardController@index')->name('main.dashboard');
                }
                else{
                    Route::get('/login','AdminAuth@login');
                }
            }
            else{
                Route::get('/login','AdminAuth@login');
            }
        });

    // ================================= LOGOUT ==============================================

    Route::group(['middleware'=>['admin']],function(){
            Route::any('/logout','AdminAuth@logout')->name('logout');
            Route::get('/','DashboardController@index');
            // dashboards
            Route::get('/dashboard','DashboardController@index')->name('main.dashboard');
            
            Route::get('/dashboard/staff','DashboardController@staff')->name('dashboard.staff');

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

        });
});

Route::get('/pdf','HomeController@testExportPdf');
