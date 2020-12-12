@extends('layouts.backEnd.teacher')
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
            .comment-text{
                background-color: #F0F2F5; border-radius: 10px;display:inline-block;border: 1px solid #dadada;
                padding-left: 7px;
                padding-right: 7px;
                padding-top: 7px;
                margin-top: 5px;
                /* margin-left: 15px; */
                /* padding-bottom: -10px; */
                
            }  
            .load-comments{
                cursor: pointer;
                color:#1e9ff2;
            }           
         
    </style>
@endsection
@section('content')
{{-- images --}}
<div class="row">
    <div class="col-lg-12 mb-1">
        <img style="border-radius: 10px;" src="{{asset('images/website/img_code.jpg')}}" width="100%" alt="cover">    
        <h1 class="top-left"><strong>{{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}</strong></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-12">
        <div class="card" style="border-radius: 15px;">          
        <div class="card-content">
            <div class="card-body">   
                {{-- homework --}}
                <div class="btn-group mr-1 mb-1">
                    <button type="button" class="btn btn-info btn-min-width dropdown-toggle btn-sm" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"><i class="la la-plus"></i> {{ trans('learning::local.class_work') }}</button>
                    <div class="dropdown-menu">
                    <a class="dropdown-item" onclick="assignment()" href="#"><i class="la la-sticky-note"></i>{{ trans('learning::local.assignment') }}</a>
                    <a class="dropdown-item" onclick="question()" href="#"><i class="la la-question"></i>{{ trans('learning::local.add_questions') }}</a>                  
                    </div>
                </div>
                {{-- end homework --}}
              <h4 class="card-title" id="heading-icon-dropdown"><strong>{{ trans('learning::local.next_exams') }}</strong></h4>
              <ul>
                  @empty(count($exams))
                    <p class="card-text">{{ trans('learning::local.no_works') }}</p>                   
                  @endempty
                  @foreach ($exams as $exam)
                      <li><a target="_blank" href="{{route('teacher.preview-exam',$exam->id)}}">{{$exam->exam_name}}</a></li>
                  @endforeach
              </ul>
              <hr>             
              <h4 class="card-title" id="heading-icon-dropdown"><strong>{{ trans('learning::local.classrooms') }}</strong></h4>
              <ol>
                  @foreach (employeeClassrooms() as $class_item)
                    @if ($class_item->id == $classroom->id)
                        <li>{{session('lang') == 'ar' ? $class_item->ar_name_classroom : $class_item->en_name_classroom}}</li>
                    @else
                        <li><a href="{{route('posts.index',$class_item->id)}}">{{session('lang') == 'ar' ? $class_item->ar_name_classroom : $class_item->en_name_classroom}}</a></li>
                    @endif
                  @endforeach
              </ol>
              <hr>
              <h4 class="card-title" id="heading-icon-dropdown"><strong>{{ trans('learning::local.attachments') }}</strong></h4>

            </div>
          </div>
        </div>
    </div>
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
                    @include('learning::teacher.posts.includes._create-post')                              
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
                            </h4>
                            {{-- mobile --}}
                            <span class="small  d-inline-block d-sm-none">{{$post->created_at->diffForHumans()}}</span>
                            {{-- edit and delete --}}
                            @if (authinfo()->id == $post->admin->id)
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
                            @endif

                        </div>
                        <div class="card-content">
                            <div class="card-body">

                                {{-- post type lesson --}}
                                @if ($post->post_type == 'lesson')
                                    <h6>
                                        <span class="avatar avatar-online mr-1" >
                                            <img style="border-radius: 0;max-width:110%;width:110%" src="{{asset('images/website/lesson.png')}}" alt="avatar">  
                                        </span>
                                        <span class="blue"><strong>{{ trans('learning::local.publish_new_lesson') }}</strong></span> {!!$post->post_text!!}</h6>                                    
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
                                    <p>{!!$post->post_text!!}</p>
                     
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
                                        <span class="blue"><strong>{{ trans('learning::local.publish_new_exam') }}</strong></span> {!!$post->post_text!!}</h6>                                    
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
                                    <p class="card-text" style="white-space: pre-line">{!!$post->post_text!!}</p>
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

                                {{-- button comments and count of comments --}}                                
                                <div class="mb-3">
                                    <button type="button" style="width: 35px;height: 35px;padding: 0px;" type="button" 
                                    class="btn btn-float btn-square btn-outline-primary comment" value="{{ $post->id }}" data-toggle="tooltip" data-placement="top"
                                    title="{{ trans('learning::local.comments') }}"><i class="la la-comments"></i></button> 
                                    @php
                                        $like = null;
                                        $dislike = null;
                                    @endphp

                                    @foreach ($post->likes as $like)
                                        @isset($like->admin_id)
                                            @if ($like->admin_id == authInfo()->id )
                                                @php
                                                    $like = 'active'
                                                @endphp
                                            @endif                                        
                                        @endisset
                                    @endforeach

                                    @foreach ($post->dislikes as $dislike)
                                        @isset($dislike->admin_id)
                                            @if ($dislike->admin_id == authInfo()->id )
                                                @php
                                                    $dislike = 'active'
                                                @endphp
                                            @endif                                                
                                        @endisset
                                    @endforeach
                                    {{-- like --}}
                                    <button style="width: 35px;height: 35px;padding: 0px;" type="button" 
                                    class="btn btn-float btn-square btn-outline-info {{$like}}"  
                                    data-toggle="tooltip" data-placement="top"
                                    title="{{ trans('learning::local.like') }}"
                                    id="btn_like_{{$post->id}}"
                                    onclick="likePost({{$post->id}})"><i class="la la-thumbs-up"></i></button> 
                                    
                                    {{-- dislike --}}
                                    <button style="width: 35px;height: 35px;padding: 0px;" type="button" 
                                    class="btn btn-float btn-square btn-outline-danger {{$dislike}}"  
                                    data-toggle="tooltip" data-placement="top"
                                    title="{{ trans('learning::local.dislike') }}"
                                    id="btn_dislike_{{$post->id}}"
                                    onclick="dislikePost({{$post->id}})"><i class="la la-thumbs-down"></i></button> 

                                    {{-- comments --}}
                                    <a href="#" class="{{session('lang') == 'ar' ? 'pull-left':'pull-right'}}" ><i class="la la-comments"></i> 
                                        {{ trans('learning::local.comments') }}   <span id="count_{{$post->id}}">{{$post->comments->count()}}</span>                                    
                                    </a href="#">   

                                    {{-- count of post like --}}
                                    <span class="{{session('lang') == 'ar' ? 'pull-left':'pull-right'}}" ><i class="la la-thumbs-down"></i> 
                                        {{ trans('learning::local.dislike') }}   <span id="count_dislike_{{$post->id}}">{{$post->dislikes->count()}}</span>                                    
                                    </span> 

                                    {{-- count of post dislike --}}
                                    <span  class="{{session('lang') == 'ar' ? 'pull-left':'pull-right'}}" ><i class="la la-thumbs-up"></i> 
                                        {{ trans('learning::local.like') }}   <span id="count_like_{{$post->id}}">{{$post->likes->count()}}</span>                                    
                                    </span >  
                                </div>
                                
                                {{-- add comment --}}
                                                                            
                                <div id="commentField_{{ $post->id }}" class="panel panel-default" style="padding:10px; margin-top:-20px; display:none;">                                    
                                    <div id="comment_{{ $post->id }}"> </div>
                                    <fieldset class="mt-2"> 
                                        <form id="commentForm_{{ $post->id }}">
                                            @csrf
                                            <input type="hidden" value="{{ $post->id }}" name="post_id">
                                            <div class="form-group">
                                                <textarea name="comment_text" id="text_{{ $post->id }}"  data-id="{{ $post->id }}" cols="30" rows="10" class="form-control editor" ></textarea>
                                            </div>    
                                            <div class="form-group">
                                            <button type="button" class="btn btn-info round submitComment" value="{{ $post->id }}"><i class="fa fa-comment"></i> 
                                                {{ trans('learning::local.add_comment') }}</button>
                                            </div>                                       
                                        </form> 
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-info round submitComment hidden" value="{{ $post->id }}"><i class="fa fa-comment"></i> {{ trans('learning::local.set_comment') }}</button>
                                        </div>                                        
                                    </fieldset> 
                                </div>                                    
                            </div>
                        </div>
                    </div>
                </div>                             
        @endforeach                        
    </div>    
</div>

@include('learning::teacher.posts.includes._homework-assignment')                                    
@include('learning::teacher.posts.includes._homework-question')                                    
@endsection
@section('script')
    {{-- comments --}}
    <script>
        function likePost(post_id) {
            $.ajax({
                url: "{{route('post.like')}}",
                method:"POST",
                dataType:"json",
                data: {post_id:post_id,_token : '{{ csrf_token() }}'},
                success: function(data){                
                    $('#count_like_'+ post_id).html(data.like);  
                    $('#count_dislike_'+ post_id).html(data.dislike);  
                    $('#btn_like_'+post_id).addClass('active');
                    $('#btn_dislike_'+post_id).removeClass('active');
                }
            })
        }

        function dislikePost(post_id) {
            $.ajax({
                url: "{{route('post.dislike')}}",
                method:"POST",
                dataType:"json",
                data: {post_id:post_id,_token : '{{ csrf_token() }}'},
                success: function(data){      
                    $('#count_like_'+post_id).html(data.like);            
                    $('#count_dislike_'+post_id).html(data.dislike);  
                    $('#btn_dislike_'+post_id).addClass('active');                               
                    $('#btn_like_'+post_id).removeClass('active');                               
                }
            })
        }


        var post_id;

        $(document).ready(function(){
            $('.commenttext').keypress(function(event){
                var keycode = (event.keyCode ? event.keyCode : event.which);
                if(keycode == '13'){
                    $(".submitComment").click();
                    return false;
                }
            });

            $(document).on('click', '.submitComment', function(){
                event.preventDefault();
                var id = $(this).val();            
                $('.editor').val(  CKEDITOR.instances['text_'+id].getData());

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
                            $('#commentForm_'+id)[0].reset();
                            getComment(id);	
                            CKEDITOR.instances['text_'+id].setData('');

                            $('#comment-modal').modal('hide');
                        }
                    });
            });
        });

        function loadComments(id) {
                post_id = id;
                if($('#commentField_'+id).is(':visible')){
                    $('#commentField_'+id).slideUp();
                }
                else{
                    $('#commentField_'+id).slideDown();
                    getComment(id);
                }
        }

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
                    countComment(id);                               
                }
            });
        }

        function countComment(id){
            $.ajax({
                url: "{{route('comments.count')}}",
                data: {id:id},
                success: function(data){                
                    $('#count_'+id).html(data);                                 
                }
            });
        }

        function deleteComment(comment_id) {
            swal({
                    title: "{{trans('msg.delete_confirmation')}}",
                    text: "{{trans('learning::local.ask_delete_comment')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#D15B47",
                    confirmButtonText: "{{trans('msg.yes')}}",
                    cancelButtonText: "{{trans('msg.no')}}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url: "{{route('comment.destroy')}}",
                        method:"POST",
                        dataType:"json",
                        data: {comment_id:comment_id,_token : '{{ csrf_token() }}'},
                        success: function(data){                
                            getComment(data);                                 
                        }
                    })
                    // display success confirm message
                    .done(function(data) {
                        swal("{{trans('msg.delete')}}", "{{trans('msg.delete_successfully')}}", "success");
                    });
                }
            );
        }

        setInterval(function()
        {
            getComment(post_id)
        },2000000); //1000 second
    </script>

    <script>

        $('#post').on('focus',function(){
            $('#create-post-modal').modal({backdrop: 'static', keyboard: false})
            $('#create-post-modal').modal('show');

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
        function closeYoutubeModal() {
            $('#youtube-url-modal').modal('toggle');
        }
        function closeURL() {
            $('#link-modal').modal('toggle');
        }
        function closeUploadFile() {
            $('#upload-file-modal').modal('toggle');
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

        function assignment()
        {            
            $('#assignment').modal({backdrop: 'static', keyboard: false})
            $('#assignment').modal('show');
        }
        function question()
        {            
            $('#question').modal({backdrop: 'static', keyboard: false})
            $('#question').modal('show');
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

    {{-- use ckeditor --}}
    <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>    
    <script>        
        CKEDITOR.replace( 'ckeditor', {
            toolbar: [
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },                   
                        { name: 'styles', items: ['FontSize' ] },
                        { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        { name: 'tools', items: [ 'Maximize' ] },                
                    ]        
            });

        $(".editor").each(function () {
            let id = $(this).attr('id');
            CKEDITOR.replace(id, {
                toolbar: [
                            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                            { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },                   
                            { name: 'styles', items: ['FontSize' ] },
                            { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                            { name: 'tools', items: [ 'Maximize' ] },                
                        ]        
                });
        });
    </script>
@endsection
