<?php
    Route::group(['namespace'=>'Post'],function(){
      // posts
      Route::resource('teacher/posts','PostController')->except('index','create','show');
      Route::get('teacher/posts/index/{id}','PostController@index')->name('posts.index');
      
      Route::get('posts/all','PostController@allPosts')->name('admin.posts');
      Route::get('posts/all/by-classroom/{classroom_id}','PostController@allPostsByClassroom')->name('posts.by-classroom');
      Route::post('posts/admin/store','PostController@adminStorePost')->name('admin.store-post');
      Route::get('posts/edit/{post_id}','PostController@adminEditPost')->name('admin.edit-posts');
      Route::put('posts/edit/{post_id}','PostController@adminUpdatePost')->name('admin.update-posts');
      Route::delete('posts/destroy/{post_id}','PostController@adminDestroyPost')->name('admin.destroy-posts');
  
      // comments
      Route::resource('teacher/comments','CommentController')->only('index','store');   
    
    });  