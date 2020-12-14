<?php
    Route::group(['namespace'=>'Post'],function(){
      // posts
      Route::resource('teacher/posts','PostController')->except('index','create');
      Route::get('teacher/posts/index/{id}','PostController@index')->name('posts.index');
      
      Route::get('posts/all','PostController@allPosts')->name('admin.posts');
      Route::get('posts/all/by-classroom/{classroom_id}','PostController@allPostsByClassroom')->name('posts.by-classroom');
      Route::post('posts/admin/store','PostController@adminStorePost')->name('admin.store-post');
      Route::get('posts/edit/{post_id}','PostController@adminEditPost')->name('admin.edit-posts');
      Route::put('posts/edit/{post_id}','PostController@adminUpdatePost')->name('admin.update-posts');
      Route::delete('posts/destroy/{post_id}','PostController@adminDestroyPost')->name('admin.destroy-posts');
  
      // comments
      Route::resource('teacher/comments','CommentController')->only('index','store','destroy');  
      Route::get('teacher/comments/count','CommentController@count')->name('comments.count') ;
      Route::post('teacher/comment/destroy','CommentController@destroy')->name('comment.destroy') ;
      
      // likes
      Route::post('teacher/post/like','PostController@likePost')->name('post.like') ;
      Route::post('teacher/post/dislike','PostController@dislikePost')->name('post.dislike') ;
      
      Route::post('teacher/comment/like','CommentController@likeComment')->name('comment.like') ;
      Route::post('teacher/comment/dislike','CommentController@dislikeComment')->name('comment.dislike') ;

      // show likes names comments
      Route::put('teacher/comments/show-like-names','CommentController@showLikeNames')->name('comment.show-likes') ;
      Route::put('teacher/comments/show-dislike-names','CommentController@showDislikeNames')->name('comment.show-dislike') ;


    });  