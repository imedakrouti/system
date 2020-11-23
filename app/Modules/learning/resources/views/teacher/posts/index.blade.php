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
                        <input type="hidden" name="classroom_id[]" value="{{$classroom->id}}">                       
                        <textarea required name="post_text" class="form-control" cols="30" rows="5" style="border: 0; min-height:50px;max-height:200px;"
                         placeholder="{{ trans('learning::local.share_classroom') }}"></textarea>
                         <div id="file_name"></div>
                         <div id="url-link"></div>
                         <div id="youtube-url"></div>

                         @include('learning::teacher.posts.includes._upload-file')                                    
                         @include('learning::teacher.posts.includes._link')                                    
                         @include('learning::teacher.posts.includes._youtube-url')                                    
                        <div class="form-control">
                            <label>{{ trans('learning::local.share_with_class') }}</label>
                            <select name="classroom_id[]" class="form-control select2" id="filter_room_id" multiple>
                                    @foreach ($classrooms as $class)
                                        @if ($class->id != $classroom->id)
                                            <option value="{{$class->id}}">
                                                {{session('lang') == 'ar'? $class->ar_name_classroom : $class->en_name_classroom}}
                                            </option>                                
                                        @endif
                                    @endforeach
                            </select>           
                        </div>                               
                         
                         <hr>
                        <div class="form-group mt-1">
                            <div class="btn-group mr-1 mb-1">
                                <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.attachments') }}</button>
                                <div class="dropdown-menu">
                                    <a onclick="uploadFile()" class="dropdown-item" href="#"><i class="la la-upload"></i> {{ trans('learning::local.upload_file') }}</a>                                    
                                    <a onclick="link()" class="dropdown-item" href="#"><i class="la la-external-link"></i> {{ trans('learning::local.link') }}</a>                                    
                                    <a onclick="youtubeURL()" class="dropdown-item" href="#"><i class="la la-youtube"></i> {{ trans('learning::local.youtube_url') }}</a>                                                        
                                </div>                                
                                <button type="submit" class="btn btn-success btn-sm ml-1">{{ trans('learning::local.post') }}</button>
                            </div>
                            <button onclick="cancel()" class="btn btn-light btn-sm pull-left">{{ trans('learning::local.cancel') }}</button>
                        </div>    
                        
                    </form>                                         
            </div>
        </div>
        
        @empty(count($posts))
        <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body">
                  <h5 class="red">{{ trans('learning::local.no_posts') }}</h5>       
                </div>
              </div>
            </div>
          </div>
        @endempty

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
                                <span class="small  d-none d-sm-inline-block">{{$post->created_at->diffForHumans()}}</span>
                            </h4>
                            <span class="small  d-inline-block d-sm-none">{{$post->created_at->diffForHumans()}}</span>
                            
                            <div class="heading-elements ">                                
                                <div class="form-group text-center">
                                    <!-- Floating icon Outline button -->
                                    <form class="form-horizontal frm-post" action="{{route('posts.destroy',$post->id)}}" method="post" >
                                        @csrf 
                                        @method('DELETE') 
                                        <input type="hidden" name="classroom_id" value="{{$post->classroom_id}}">
                                        {{-- edit --}}
                                        <button style="width: 35px;height: 35px;padding: 0px;" type="button" 
                                        class="btn btn-float btn-square btn-outline-warning"  data-toggle="tooltip" data-placement="top"
                                        title="{{ trans('learning::local.edit') }}"
                                        onclick="location.href='{{route('posts.edit',$post->id)}}';"><i class="la la-edit"></i></button>                                        
                                        {{-- delete --}}
                                        <button style="width: 35px;height: 35px;padding: 0px;" type="submit" 
                                        class="btn btn-float btn-square btn-outline-danger delete-post"  data-toggle="tooltip" data-placement="top"
                                        title="{{ trans('admin.delete') }}"><i class="la la-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                
                                <p class="card-text" style="white-space: pre-line">{{$post->post_text}}</p>
                                @isset($post->url)
                                <div class="mb-1">
                                    <a target="_blank" href="{{$post->url}}"><i class="la la-external-link"></i> {{$post->url}}</a>
                                </div>                            
                                @endisset
                                @isset($post->file_name)
                                <div class="mb-1">
                                    <a target="_blank" href="{{asset('images/posts_attachments/'.$post->file_name)}}"><i class="la la-download"></i> {{$post->file_name}}</a>
                                </div>                            
                                @endisset
                                @isset($post->youtube_url)              
                                <div class="mb-1">
                                    <iframe width="100%"  style="min-height: 500px;" allowfullscreen
                                        src="https://www.youtube.com/embed/{{prepareYoutubeURL($post->youtube_url)}}">
                                    </iframe>
                                </div>
                                @endisset
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
            $('#upload-file-modal').modal({backdrop: 'static', keyboard: false})
            $('#upload-file-modal').modal('show');
        }
        function link()
        {
            $('#link-modal').modal({backdrop: 'static', keyboard: false})
            $('#link-modal').modal('show');
        }

        function youtubeURL()
        {
            $('#youtube-url-modal').modal({backdrop: 'static', keyboard: false})
            $('#youtube-url-modal').modal('show');
        }
        function getFile()
        {
            var filename = $('#file-name').val();
            if (filename.substring(3,11) == 'fakepath') {
                filename = filename.substring(12);
            } // Remove c:\fake at beginning from localhost chrome
            $('#file_name').html('<i class="la la-file"></i>' + filename);
            $('#upload-file-modal').modal('hide');
        }
        function getUrl()
        {
            var url = $('#url').val();  
            $('#youtube-url').html('<i class="la la-youtube"></i>' + url);
            $('#youtube-url-modal').modal('hide');
        }

        function getLink()
        {
            var url = $('#link').val();  
            $('#url-link').html('<i class="la la-external-link"></i>' + url);
            $('#link-modal').modal('hide');
        }

        $('#url').on('change',function(){
            url();
        })

        $("#url").keyup(function(){
            url();
        });

        function url()
        {
            var youtube_link = $('#url').val();  

            var from_start = youtube_link.indexOf("=") + 1;
            var end_start = youtube_link.indexOf("&");
            if (end_start < 0) {
                end_start = youtube_link.length;            
            }
            var link = youtube_link.substring(from_start, end_start)                        
            url =  "https://www.youtube.com/embed/" + link ;
            
            $('#video_url').addClass('hidden');
            $('#youtube').removeClass('hidden');
            $('#youtube').attr('src', url);
        }

        $('.delete-post').on('click',function(){     
            
            if (confirm("{{trans('learning::local.delete_post')}}")) {
                $('form').submit();
            }else{
                event.preventDefault();                   
            }
        })
         
    </script>
    <script src="{{asset('cpanel/app-assets/js/scripts/tooltip/tooltip.js')}}"></script>
@endsection
