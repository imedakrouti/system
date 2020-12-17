<?php
Route::group(['middleware'=>['user'],'namespace'=>'ParentStudent\Student'],function(){
    // dashboard
    // student dashboard
    Route::get('/parent-dashboard', 'UserParentController@dashboard')->name('parent.dashboard');
    
    Route::get('/student-dashboard', 'DashboardController@dashboard')->name('student.dashboard');
    // student comment
    Route::post('student/comment','DashboardController@storeComment')->name('student-store.comment');
    Route::get('student/comment/get','DashboardController@comments')->name('student.comments');

    
    // likes
    Route::post('student/post/like','DashboardController@likePost')->name('student-post.like') ;
    Route::post('student/post/dislike','DashboardController@dislikePost')->name('student-post.dislike') ;
    
    Route::post('student/comment/like','DashboardController@likeComment')->name('student-comment.like') ;
    Route::post('student/comment/dislike','DashboardController@dislikeComment')->name('student-comment.dislike') ;

    // show likes names comments
    Route::put('student/comments/show-like-names','DashboardController@showLikeNames')->name('student-comment.show-likes') ;
    Route::put('student/comments/show-dislike-names','DashboardController@showDislikeNames')->name('student-comment.show-dislike') ;

    Route::get('student/comments/count','DashboardController@count')->name('student-comments.count') ;
    Route::get('student/comments/show/{post_id}','DashboardController@show')->name('student-comments.show') ;
});