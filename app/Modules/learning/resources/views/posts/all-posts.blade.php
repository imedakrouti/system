@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('styles')
    <style>
            /* Top left text */
            .top-left {
            position: absolute;
            top: 50px;
            left: 70px;
            font-weight: bold;
            color: #fff;
            text-shadow: 0px 0px 10px rgba(0, 0, 0, 0.7);
            }    
            .comment-form{
                padding:5px;                
                width:100%;
            }               
            ul, #myUL {
            list-style-type: none;
            }

            #myUL {
            margin: 0;
            padding: 0;
            }

            .caret {
            
            cursor: pointer;
            -webkit-user-select: none; /* Safari 3.1+ */
            -moz-user-select: none; /* Firefox 2+ */
            -ms-user-select: none; IE 10+
            user-select: none;
            }

            .caret::before {
            content: "\25B6";
            color: black;
            display: none;
            margin-right: 6px;
            }

            .caret-down::before {
            -ms-transform: rotate(0deg); /* IE 9 */
            -webkit-transform: rotate(0deg); /* Safari */'
            transform: rotate(0deg);  
            }

            .nested {
            display: none;
            }

            .active {
            display: block;
            }         
    </style>
@endsection
@section('content')
<div class="row">
    {{-- classrooms --}}
    <div class="col-lg-3 col-md-12 ">
        <div class="card" style="border-radius: 15px;">          
        <div class="card-content">
            <div class="card-body">
                <div class="card-body">
                    <h4>{{ trans('learning::local.classrooms') }}</h4>
                    <ul id="myUL">
                        @foreach ($divisions as $division)
                        <li><span class="caret"><i class="la la-slack"></i>
                            {{session('lang') == 'ar' ?$division->ar_division_name:$division->en_division_name}}
                            </span>
                                <ul class="nested active">
                                    @foreach ($grades as $grade)
                                        <li><span class="caret"><i class="la la-minus"></i>
                                             {{session('lang') == 'ar' ?$grade->ar_grade_name:$grade->en_grade_name}}
                                            </span>
                                            <ul class="nested active">
                                            @foreach ($classrooms as $classroom)
                                                @if ($classroom->division_id == $division->id && $classroom->grade_id == $grade->id)
                                                <li><span> <a href="{{route('posts.by-classroom',$classroom->id)}}">
                                                    {{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}
                                                </a></span></li>                                                                                                        
                                                @endif
                                            @endforeach
                                            </ul>
                                        </li>                                  
                                    @endforeach                            
                                </ul>
                            </li>                            
                        @endforeach
                    </ul>
                
                </div>
              </div>
          </div>
        </div>
    </div>
    {{-- posts --}}
    <div class="col-lg-9 col-md-12">

        {{-- create post --}}
        <div class="col-md-12 col-sm-12 mb-1">
            <div class="card" id="create-post" style="border-radius: 15px;">
                <div class="card-header" style="border-radius: 10px;">                                            
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
                    <form action="{{route('admin.store-post')}}" method="post" enctype="multipart/form-data" id="form_post">
                        @csrf   
                        <input type="hidden" name="post_type" value="post">                       
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
                            <select name="classroom_id[]" class="form-control select2" id="filter_room_id" required multiple>
                                    @foreach ($classrooms as $class)
                                            <option value="{{$class->id}}">
                                                {{session('lang') == 'ar'? $class->ar_name_classroom : $class->en_name_classroom}}
                                            </option>                                
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
                            <button onclick="cancel()" class="btn btn-light btn-sm {{session('lang') == 'ar' ? 'pull-left' : 'pull-right'}}">{{ trans('learning::local.cancel') }}</button>
                        </div>    
                        
                    </form>                                         
            </div>
        </div>
        
        {{-- no posts --}}
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
                <div class="card" style="border-radius: 15px;">
                    <div class="card-header" style="border-radius: 15px;">
        
                        <h4 class="card-title" id="heading-icon-dropdown">
                            <span class="avatar avatar-online">
                                @isset($post->admin->image_profile)
                                <img src="{{asset('images/imagesProfile/'.$post->admin->image_profile)}}" alt="avatar">                          
                                @endisset
                                @empty($post->admin->image_profile)                          
                                <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
                                @endempty
                            </span>
                            <strong>{{session('lang') == 'ar'? $post->admin->ar_name : $post->admin->name}} </strong>
                            <span class="small  d-none d-sm-inline-block">{{$post->created_at->diffForHumans()}}</span>
                            <div class="badge badge-danger">
                                {{session('lang') == 'ar' ? $post->classroom->ar_name_classroom : $post->classroom->en_name_classroom}}
                            </div>
                        </h4>
                        {{-- mobile --}}
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
                    {{-- post content --}}
                    <div class="card-content">
                        <div class="card-body">

                            {{-- post type lesson --}}
                            @if ($post->post_type == 'lesson')
                                <h6>
                                    <span class="avatar avatar-online mr-1" >
                                        <img style="border-radius: 0;max-width:110%;width:110%" src="{{asset('images/website/lesson.png')}}" alt="avatar">  
                                    </span>
                                    <span class="blue"><strong>{{ trans('learning::local.publish_new_lesson') }}</strong></span> {{$post->post_text}}</h6>                                    
                                    <p class="card-text" style="white-space: pre-line">{{$post->description}}</p>
                                <h6>
                                    <div class="mb-1">
                                        <span class="purple">{{ trans('learning::local.lesson_link') }}</span>  
                                        @php
                                            $str  = $post->url;
                                            $url = explode(",", $str);                                                                                                
                                        @endphp                                      
                                        <a target="_blank" href="{{route('teacher.view-lesson',['id'=>$url[0],'playlist_id'=>$url[0]])}}"><i class="la la-external-link"></i> {{ trans('learning::local.press_here') }}</a>
                                    </div>
                                </h6>
                                @isset($post->youtube_url)              
                                <div class="mb-1">
                                    <iframe width="100%"  style="min-height: 500px;" allowfullscreen
                                        src="https://www.youtube.com/embed/{{prepareYoutubeURL($post->youtube_url)}}">
                                    </iframe>
                                </div>
                                @endisset                                                                  
                            @endif  

                            {{-- post type assignment --}}
                            @if ($post->post_type == 'assignment')
                                <h6>
                                    <span class="avatar avatar-online mr-1">
                                        <img style="border-radius: 0;max-width:110%;width:110%" src="{{asset('images/website/hw.png')}}" alt="avatar">  
                                    </span>
                                    <span class="blue"><strong>{{ trans('learning::local.publish_new_assignment') }}</strong></span> {{$post->description}}</h6>
                                <p>{{$post->post_text}}</p>
                    
                                @isset($post->youtube_url)              
                                <div class="mb-1">
                                    <iframe width="100%"  style="min-height: 500px;" allowfullscreen
                                        src="https://www.youtube.com/embed/{{prepareYoutubeURL($post->youtube_url)}}">
                                    </iframe>
                                </div>
                                @endisset                                                                  
                            @endif                                  
                            
                            {{-- post type exam --}}
                            @if ($post->post_type == 'exam')
                                <h6>
                                    <span class="avatar avatar-online mr-1">
                                        <img style="border-radius: 0;max-width:160%;width:160%" src="{{asset('images/website/test.png')}}" alt="avatar">  
                                    </span>
                                    <span class="blue"><strong>{{ trans('learning::local.publish_new_exam') }}</strong></span> {{$post->post_text}}</h6>                                    
                                <p class="card-text" style="white-space: pre-line">{{$post->description}}</p>
                                <h6>
                                    <div class="mb-1">
                                        <span class="purple">{{ trans('learning::local.exam_link') }}</span>                                                                                    
                                        <a target="_blank" href="{{$post->url}}"><i class="la la-external-link"></i> {{ trans('learning::local.press_here') }}</a>
                                    </div>
                                </h6>
                                @isset($post->youtube_url)              
                                <div class="mb-1">
                                    <iframe width="100%"  style="min-height: 500px;" allowfullscreen
                                        src="https://www.youtube.com/embed/{{prepareYoutubeURL($post->youtube_url)}}">
                                    </iframe>
                                </div>
                                @endisset                                                                  
                            @endif                                    

                            {{-- post type post --}}
                            @if ($post->post_type == 'post')
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
                            @endif
                            <hr>
                            <button type="button" class="btn btn-info round btn-sm comment mb-1" value="{{ $post->id }}">{{ trans('learning::local.comments') }}</button>
                                
                            {{-- add comment --}}
                                                                        
                            <div id="commentField_{{ $post->id }}" class="panel panel-default" style="padding:10px; margin-top:-20px; display:none;">
                                <div id="comment_{{ $post->id }}">
                                </div>
                                <form id="commentForm_{{ $post->id }}">
                                    @csrf
                                    <input type="hidden" value="{{ $post->id }}" name="post_id">
                                    <div class="row"> 
                                        <div class="col-md-12">                                                
                                            <fieldset>
                                                <div class="input-group">
                                                <input type="text" name="comment_text" data-id="{{ $post->id }}" class="form-control round commenttext" aria-describedby="button-addon2"
                                                    placeholder="{{ trans('learning::local.add_comment') }}">
                                                    <div class="input-group-append">
                                                    <button type="button" class="btn btn-info round submitComment" value="{{ $post->id }}"><i class="fa fa-comment"></i> {{ trans('learning::local.set_comment') }}</button>
                                                    </div>
                                                </div>
                                            </fieldset>                                                 
                                        </div>                                            
                                    </div>                                        
                                </form>
                            </div>                                    
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
        var post_id;
        $(document).ready(function(){
            $('.commenttext').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    
                    return false;
                }
            });
            $(document).on('click', '.submitComment', function(){
                event.preventDefault();
                var id = $(this).val();            
                var form_data = new FormData($('#commentForm_'+id)[0]);

                $.ajax({
                        url:"{{route('comments.store')}}",
                        method:"POST",
                        data:form_data,
                        cache       : false,
                        contentType : false,
                        processData : false,
                        dataType:"json",
                        // display succees message
                        success:function(data)
                        {	
                            getComment(id);							
                            $('#commentForm_'+id)[0].reset();
                        }
                    });
            });
        });

        $(document).on('click', '.comment', function(){
            var id = $(this).val();
            post_id = id;
            if($('#commentField_'+id).is(':visible')){
                $('#commentField_'+id).slideUp();
            }
            else{
                $('#commentField_'+id).slideDown();
                getComment(id);
            }
        });

        function getComment(id){
            $.ajax({
                url: "{{route('comments.index')}}",
                data: {id:id},
                success: function(data){                
                    $('#comment_'+id).html(data);                                 
                }
            });
        }
        setInterval(function()
        {
            getComment(post_id)
        },20000); //1000 second
    </script>

    <script>
 
        $('#post').on('focus',function(){
            $('#create-post').hide();
            $('#my-post').removeClass('hidden');
            
        })
        function cancel()
        {
            event.preventDefault();
            $('#create-post').show();
            $('#form_post')[0].reset();
            $('#file_name').html('');
            $('#url-link').html('');
            $('#youtube-url').html('');
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

    <script>
        var toggler = document.getElementsByClassName("caret");
        var i;
        
        for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
        }
    </script>
    <script src="{{asset('cpanel/app-assets/js/scripts/tooltip/tooltip.js')}}"></script>
@endsection