<?php
    Route::group(['namespace'=>'Post'],function(){

      // posts
      Route::resource('teacher/posts','PostController')->except('index','create');
      Route::get('teacher/posts/index/{id}','PostController@index')->name('posts.index');

    

      // comments
      Route::resource('teacher/comments','CommentController')->except('destroy');
      Route::post('teacher/comments/destroy','CommentController@destroy')->name('teacher-comments.destroy');

  
    
    });  