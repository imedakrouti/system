<?php
$moduleName = basename(dirname(__DIR__));
/**
 * Since Laravel 5.2 the StartSession middleware has been moved from the global $middleware list to the
 * web middleware group in App\Http\Kernel.php. That means that if you need
 * session access for your routes you can use that middleware group
 */
Route::namespace(getNamespaceController($moduleName))->middleware(['web','admin'])->group(function() use($moduleName){
    Route::prefix(buildPrefix($moduleName))->group(function(){
        Route::group(['namespace'=>'Setting'],function(){
            Route::get('settings','StaffSettingController@index')->name('staff.setting');
            require 'setting.php';
        });
    });
});
