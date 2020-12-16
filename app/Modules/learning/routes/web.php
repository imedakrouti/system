<?php
$moduleName = basename(dirname(__DIR__));
/**
 * Since Laravel 5.2 the StartSession middleware has been moved from the global $middleware list to the
 * web middleware group in App\Http\Kernel.php. That means that if you need
 * session access for your routes you can use that middleware group
 */
Route::namespace(getNamespaceController($moduleName))->middleware(['web','admin','lang'])->group(function() use($moduleName){
    Route::prefix(buildPrefix($moduleName))->group(function(){
        Route::group(['namespace'=>'Setting','prefix'=>'settings'],function(){            
            require 'setting.php';
        });
        require 'dashboard.php'; 
               
        require 'learning.php'; 

        require 'teacher_learning.php';    

        require 'post.php';        
           
  
    });
});




