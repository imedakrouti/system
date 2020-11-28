@extends('layouts.front-end.student.index')
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
        <div class="card-content">
            <div class="card-body">   
                <h4 class="card-title" id="heading-icon-dropdown"><strong>{{ trans('learning::local.next_exams') }}</strong></h4>
                <ul>
                    @empty(count($exams))
                        <p class="card-text">{{ trans('learning::local.no_works') }}</p>                   
                    @endempty
                    @foreach ($exams as $exam)                        
                        <li>
                            <strong> {{$exam->exam_name}}</strong>
                            
                            <h6> {{\Carbon\Carbon::parse( $exam->start_date)->format('M d Y') }} 
                                <span class="danger">[{{$exam->subjects->en_name}}]</span> </h6>                            
                        </li>
                    @endforeach
                </ul>

                @if (count($exams) > 5)
                    <span class=" {{session('lang') == 'ar'?'float:left':'float-right'}}">
                        <a href="{{route('student.upcoming-exams')}}">{{ trans('student.view_all') }}</a>
                    </span>
                    <br>
                @endif

              <hr>
              

            </div>
          </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-12">
        
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
                    <div class="card">
                        <div class="card-header">
         
                            <h4 class="card-title" id="heading-icon-dropdown">
                                <span class="avatar avatar-online">
                                    @isset($post->admin->image_profile)
                                    <img src="{{asset('images/imagesProfile/'. $post->admin->image_profile)}}" alt="avatar">                          
                                    @endisset
                                    @empty($post->admin->image_profile)                          
                                    <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
                                    @endempty
                                </span>
                                <strong>{{session('lang') == 'ar'? $post->admin->ar_name: $post->admin->name}} </strong>
                                <span class="small  d-none d-sm-inline-block">{{$post->created_at->diffForHumans()}}</span>
                            </h4>
                            {{-- mobile --}}
                            <span class="small  d-inline-block d-sm-none">{{$post->created_at->diffForHumans()}}</span>   
                        </div>
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
                                            <a target="_blank" href="{{route('student.view-lesson',['id'=>$url[0],'playlist_id'=>$url[0]])}}"><i class="la la-external-link"></i> {{ trans('learning::local.press_here') }}</a>
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
                                    @empty(!$post->url)
                                    <h6>
                                        <div class="mb-1">
                                            <span class="purple">{{ trans('learning::local.solve_homework_link') }}</span>                                                                                    
                                            <a target="_blank" href="{{$post->url}}"><i class="la la-external-link"></i> {{ trans('learning::local.press_here') }}</a>
                                        </div>
                                    </h6>                                        
                                    @endempty
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
                                            @php
                                                $str  = $post->url;
                                                $url = explode(",", $str);                                                                                                
                                            @endphp                                      
                                            <a target="_blank" href="{{route('student.pre-start-exam',$url[0])}}"><i class="la la-external-link"></i> {{ trans('learning::local.press_here') }}</a>                                                                                  
                                            
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
                    url:"{{route('student-store.comment')}}",
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
            url: "{{route('student.comments')}}",
            data: {id:id},
            success: function(data){                
                $('#comment_'+id).html(data);                                 
            }
        });
    }
    setInterval(function()
    {
        getComment(post_id)
    },5000); //1000 second
</script>
@endsection