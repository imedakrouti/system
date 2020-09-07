<?php
 Route::group(['namespace'=>'Age'],function(){            
    Route::get('calculate-student-age','AgeCalculateController@calculateStudentAge')->name('calculate.age');
    Route::put('calculate-student-age','AgeCalculateController@calculateStudentAge')->name('student.age');
});