<?php
    Route::group(['namespace'=>'Post'],function(){

      // posts
      Route::resource('teacher/posts','PostController')->except('index','destroy');
      Route::get('teacher/posts/index/{id}','PostController@index')->name('posts.index');

      Route::post('teacher/posts/destroy','PostController@destroy')->name('posts.destroy');

      // comments
      Route::resource('teacher/comments','CommentController')->except('destroy');
      Route::post('teacher/comments/destroy','CommentController@destroy')->name('teacher-comments.destroy');

  
    
    });  