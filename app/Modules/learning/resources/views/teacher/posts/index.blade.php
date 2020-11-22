@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
            /* Top left text */
            .top-left {
            position: absolute;
            top: 50px;
            left: 70px;
            color: aliceblue
            }    
            .comment-form{
                padding:5px;                
                width:100%;
            }                    
         
    </style>
@endsection
@section('content')
{{-- images --}}
<div class="row">
    <div class="col-lg-12 mb-1">
        <img src="{{asset('images/website/img_code.jpg')}}" width="100%" alt="cover">    
        <h1 class="top-left"><strong>{{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}</strong></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title" id="heading-icon-dropdown"><strong>{{ trans('learning::local.upcoming') }}</strong></h4>
          </div>
          <div class="card-content">
            <div class="card-body">              
              <p class="card-text">{{ trans('learning::local.no_works') }}</p>              
            </div>
          </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12">

        {{-- create post --}}
        <div class="col-md-12 col-sm-12 mb-1">
            <div class="card" id="create-post">
                <div class="card-header">                                            
                    <div class="comment-form">
                        <span class="avatar avatar-online">
                            @isset(authInfo()->image_profile)
                            <img style="width: 50px;height:50px;max-width: 50px;float:right" src="{{asset('images/imagesProfile/'.authInfo()->image_profile)}}" alt="avatar">                          
                            @endisset
                            @empty(authInfo()->image_profile)                          
                            <img style="width: 50px;height:50px;max-width: 50px;float:right" src="{{asset('images/website/male.png')}}" alt="avatar">                          
                            @endempty
                        </span>
                            
                            <input id="post" readonly type="text" class="ml-2 round form-control" 
                            style="width: calc( 100% - 70px);display:inline-block;height:54px;cursor:pointer;" 
                            placeholder="{{ trans('learning::local.share_classroom') }}">
                    </div>
                </div>                
            </div>
            <div class="card hidden" id="my-post">
                <div class="card-header">   
                    <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
                        @csrf  
                        <input type="hidden" name="classroom_id" value="{{$classroom->id}}">                      
                        <textarea required name="post_text" class="form-control" cols="30" rows="5" style="border: 0; min-height:50px;max-height:200px;"
                         placeholder="{{ trans('learning::local.share_classroom') }}"></textarea>
                         <div id="file_name"></div>
                         <div id="youtube-url"></div>
                         @include('learning::teacher.posts.includes._upload-file')                                    
                         @include('learning::teacher.posts.includes._youtube-url')                                    
                         
                         <hr>
                        <div class="form-group mt-1">
                            <div class="btn-group mr-1 mb-1">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.attachments') }}</button>
                                <div class="dropdown-menu">
                                    <a onclick="uploadFile()" class="dropdown-item" href="#">{{ trans('learning::local.file') }}</a>                                    
                                    <a onclick="youtubeURL()" class="dropdown-item" href="#">{{ trans('learning::local.youtube_url') }}</a>                                                        
                                </div>
                                <button class="btn btn-success btn-sm ml-1">{{ trans('learning::local.post') }}</button>
                            </div>
                            <button onclick="cancel()" class="btn btn-light btn-sm pull-left">{{ trans('learning::local.cancel') }}</button>
                        </div>    
                        
                    </form>                                         
            </div>
        </div>  

        {{-- posts --}}

        @foreach ($posts as $post)
            <div class="col-md-12 col-sm-12 mb-1">
                <div class="card">
                    <div class="card-header">
                    
                    <h4 class="card-title" id="heading-icon-dropdown">
                        <span class="avatar avatar-online">
                            @isset(authInfo()->image_profile)
                            <img src="{{asset('images/imagesProfile/'.authInfo()->image_profile)}}" alt="avatar">                          
                            @endisset
                            @empty(authInfo()->image_profile)                          
                            <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
                            @endempty
                        </span>
                        <strong>{{session('lang') == 'ar'? authInfo()->ar_name : authInfo()->name}} </strong>
                        <span class="small">{{$post->created_at->diffForHumans()}}</span>
                    </h4>
                    <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                    <div class="heading-elements">
                        <button type="button" class="btn btn-round " data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"><i class="la la-ellipsis-v"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item pb-1" href="#">{{ trans('learning::local.edit') }}</a>
                            <a class="dropdown-item" href="#">{{ trans('admin.delete') }}</a>                        
                        </div>
                    </div>
                    </div>
                    <div class="card-content">
                    <div class="card-body">                    
                        <p class="card-text">{{$post->post_text}}</p>
                        <div class="mb-1">
                            @isset($post->youtube_url)              
                              <iframe width="100%"  style="min-height: 500px;" allowfullscreen
                                  src="https://www.youtube.com/embed/{{prepareYoutubeURL($post->youtube_url)}}">
                              </iframe>
                            @endisset
                          </div>
                        <hr>
                        <h6><i class="la la-comments"></i> <a href="#">{{ trans('learning::local.comments') }}</a> 500</h6>
                        <input type="text" class="form-control round" placeholder="{{ trans('learning::local.add_comment') }}">
                    </div>
                    </div>
                </div>
            </div>             
        @endforeach
        
        
        
    </div>    
</div>


@endsection
@section('script')
    <script>
        $('#post').on('focus',function(){
            $('#create-post').hide();
            $('#my-post').removeClass('hidden');
            
        })
        function cancel()
        {
            event.preventDefault();
            $('#create-post').show();
            $('#my-post').addClass('hidden');
            $('#post').blur()
        }
        function uploadFile()
        {
            $('#upload-file').modal({backdrop: 'static', keyboard: false})
            $('#upload-file').modal('show');
        }
        function youtubeURL()
        {
            $('#youtube_url').modal({backdrop: 'static', keyboard: false})
            $('#youtube_url').modal('show');
        }
        function getFile()
        {
            var filename = $('#file-name').val();
            if (filename.substring(3,11) == 'fakepath') {
                filename = filename.substring(12);
            } // Remove c:\fake at beginning from localhost chrome
            $('#file_name').html('<i class="la la-file"></i>' + filename);
            $('#upload-file').modal('hide');
        }
        function getUrl()
        {
            var filename = $('#url').val();  
            $('#youtube-url').html('<i class="la la-youtube"></i>' + filename);
            $('#youtube_url').modal('hide');
        }
    </script>
@endsection
