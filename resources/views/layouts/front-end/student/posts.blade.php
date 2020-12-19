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

        .comment-form {
            padding: 5px;
            width: 100%;
        }

        .comment-text {
            background-color: #F0F2F5;
            border-radius: 10px;
            display: inline-block;
            border: 1px solid #dadada;
            padding-left: 7px;
            padding-right: 7px;
            padding-top: 7px;
            margin-top: 5px;
            /* margin-left: 15px; */
            /* padding-bottom: -10px; */

        }

        .load-comments {
            cursor: pointer;
            color: #1e9ff2;
        }

    </style>
@endsection
@section('content')
    {{-- images --}}
    <div class="row">
        <div class="col-lg-12 mb-1">
            <img style="border-radius: 15px;" src="{{ asset('images/website/banner.jpg') }}" width="100%" alt="cover">
            <h1 class="top-left">
                <strong>{{ $classroom->class_name }}</strong>
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-12">
            <div class="card" style="border-radius: 10px;">
                <div class="card-content">
                    <div class="card-body">
                        <h4 class="card-title" id="heading-icon-dropdown">
                            <strong>{{ trans('learning::local.next_exams') }}</strong></h4>
                        <ul>
                            @empty(count($exams))
                                <p class="card-text">{{ trans('student.no_upcoming_exams') }}</p>
                            @endempty
                            @foreach ($exams as $exam)
                                <li>
                                    <strong> {{ $exam->exam_name }}</strong>

                                    <h6> {{ \Carbon\Carbon::parse($exam->start_date)->format('M d Y') }}
                                        <span class="danger">[{{ $exam->subjects->en_name }}]</span>
                                    </h6>
                                </li>
                            @endforeach
                        </ul>

                        @if (count($exams) > 5)
                            <span class=" {{ session('lang') == 'ar' ? 'float:left' : 'float-right' }}">
                                <a href="{{ route('student.upcoming-exams') }}">{{ trans('student.view_all') }}</a>
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
                <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                    <span class="alert-icon"><i class="la la-info-circle"></i></span>
                    {{ trans('learning::local.no_posts') }}
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
                                    <img src="{{ asset('images/imagesProfile/' . $post->admin->image_profile) }}"
                                        alt="avatar">
                                @endisset
                                @empty($post->admin->image_profile)
                                    <img src="{{ asset('images/website/male.png') }}" alt="avatar">
                                @endempty
                            </span>
                            <strong>{{ session('lang') == 'ar' ? $post->admin->ar_name : $post->admin->name }}
                            </strong>
                            <span
                                class="small  d-none d-sm-inline-block">{{ $post->created_at->diffForHumans() }}
                            </span>
                        </h4>
                        {{-- mobile --}}
                        <span
                            class="small  d-inline-block d-sm-none">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            {{-- post type lesson --}}
                            @if ($post->post_type == 'lesson')
                                <h6>
                                    <span class="avatar avatar-online mr-1">
                                        <img style="border-radius: 0;max-width:110%;width:110%"
                                            src="{{ asset('images/website/lesson.png') }}" alt="avatar">
                                    </span>
                                    <span
                                        class="blue"><strong>{{ trans('learning::local.publish_new_lesson') }}</strong></span>
                                    {!! $post->post_text !!}
                                </h6>
                                <p class="card-text" style="white-space: pre-line">{{ $post->description }}</p>
                                <h6>
                                    <div class="mb-1">
                                        <span class="purple">{{ trans('learning::local.lesson_link') }}</span>
                                        @php
                                        $str = $post->url;
                                        $url = explode(",", $str);
                                        @endphp
                                        <a target="_blank"
                                            href="{{ route('teacher.view-lesson', ['id' => $url[0], 'playlist_id' => $url[0]]) }}"><i
                                                class="la la-external-link"></i>
                                            {{ trans('learning::local.press_here') }}</a>
                                    </div>
                                </h6>
                                @isset($post->youtube_url)
                                    <div class="mb-1">
                                        <iframe width="100%" style="min-height: 500px;" allowfullscreen
                                            src="https://www.youtube.com/embed/{{ prepareYoutubeURL($post->youtube_url) }}">
                                        </iframe>
                                    </div>
                                @endisset
                            @endif

                            {{-- post type assignment --}}
                            @if ($post->post_type == 'assignment')
                                <h6>
                                    <span class="avatar avatar-online mr-1">
                                        <img style="border-radius: 0;max-width:110%;width:110%"
                                            src="{{ asset('images/website/hw.png') }}" alt="avatar">
                                    </span>
                                    <span
                                        class="blue"><strong>{{ trans('learning::local.publish_new_assignment') }}</strong></span>
                                    {{ $post->description }}
                                </h6>
                                <p>{!! $post->post_text !!}</p>

                                @isset($post->youtube_url)
                                    <div class="mb-1">
                                        <iframe width="100%" style="min-height: 500px;" allowfullscreen
                                            src="https://www.youtube.com/embed/{{ prepareYoutubeURL($post->youtube_url) }}">
                                        </iframe>
                                    </div>
                                @endisset
                            @endif

                            {{-- post type exam --}}
                            @if ($post->post_type == 'exam')
                                <h6>
                                    <span class="avatar avatar-online mr-1">
                                        <img style="border-radius: 0;max-width:160%;width:160%"
                                            src="{{ asset('images/website/test.png') }}" alt="avatar">
                                    </span>
                                    <span
                                        class="blue"><strong>{{ trans('learning::local.publish_new_exam') }}</strong></span>
                                    {!! $post->post_text !!}
                                </h6>
                                <p class="card-text" style="white-space: pre-line">{{ $post->description }}</p>
                                <h6>
                                    <div class="mb-1">
                                        <span class="purple">{{ trans('learning::local.exam_link') }}</span>
                                        <a target="_blank" href="{{ $post->url }}"><i
                                                class="la la-external-link"></i>
                                            {{ trans('learning::local.press_here') }}</a>
                                    </div>
                                </h6>
                                @isset($post->youtube_url)
                                    <div class="mb-1">
                                        <iframe width="100%" style="min-height: 500px;" allowfullscreen
                                            src="https://www.youtube.com/embed/{{ prepareYoutubeURL($post->youtube_url) }}">
                                        </iframe>
                                    </div>
                                @endisset
                            @endif

                            {{-- post type post --}}
                            @if ($post->post_type == 'post')
                                <p class="card-text" style="white-space: pre-line">{!! $post->post_text !!}</p>
                                @isset($post->url)
                                    <div class="mb-1">
                                        <a target="_blank" href="{{ $post->url }}"><i class="la la-external-link"></i>
                                            {{ $post->url }}</a>
                                    </div>
                                @endisset
                                @isset($post->file_name)
                                    <div class="mb-1">
                                        <a target="_blank"
                                            href="{{ asset('images/posts_attachments/' . $post->file_name) }}"><i
                                                class="la la-download"></i> {{ $post->file_name }}</a>
                                    </div>
                                @endisset
                                @isset($post->youtube_url)
                                    <div class="mb-1">
                                        <iframe width="100%" style="min-height: 500px;" allowfullscreen
                                            src="https://www.youtube.com/embed/{{ prepareYoutubeURL($post->youtube_url) }}">
                                        </iframe>
                                    </div>
                                @endisset
                            @endif
                            <hr>

                            {{-- button comments and count of comments
                            --}}
                            <div class="mb-3">
                                <a onclick="loadComments({{ $post->id }})">
                                    <strong><span class="la la-comments"></span> {{ trans('learning::local.comments') }}</strong>
                                </a>
                                <a href="{{route('student-comments.show',$post->id)}}">
                                    <strong><span id="count_{{ $post->id }}">{{ $post->comments->count() }}</span></strong>
                                </a>
               
                                {{-- like and dislike from teacher account
                                --}}
                                @php
                                $like = null;
                                $dislike = null;
                                @endphp

                                @foreach ($post->likes as $like)
                                    @isset($like->user_id)
                                        @if ($like->user_id == userAuthInfo()->id)
                                            @php
                                            $like = 'blue'
                                            @endphp
                                        @endif
                                    @endisset
                                @endforeach

                                @foreach ($post->dislikes as $dislike)
                                    @isset($dislike->user_id)
                                        @if ($dislike->user_id == userAuthInfo()->id)
                                            @php
                                            $dislike = 'red'
                                            @endphp
                                        @endif
                                    @endisset
                                @endforeach

                                {{-- like --}}
                                <a class="{{ $like }}" onclick="likePost({{ $post->id }})" id="btn_like_{{ $post->id }}">
                                    <strong><span class="la la-thumbs-up"></span> {{ trans('learning::local.like') }}</strong>
                                </a>
                                {{-- count of post like --}}
                                <strong>
                                    <span id="tooltip_like_{{ $post->id }}" data-toggle="tooltip" data-placement="top" 
                                        data-html="true" data-original-title="
                                        {{-- get names of likes --}}                                                    
                                            @if(count($post->likes) > 0)
                                                @foreach ($post->likes as $admin)
                                                    {{-- teachers and admins --}}
                                                    @isset($admin->admin->employeeUser)
                                                        {{$admin->admin->employeeUser->employee_short_name}}                                                        
                                                        </br>
                                                    @endisset
                                                    {{-- students --}}
                                                    @isset($admin->user->studentUser)
                                                        {{$admin->user->studentUser->student_short_name}}                                                        
                                                        </br>
                                                    @endisset
                                                @endforeach
                                            @else
                                                {{ trans('learning::local.none') }}
                                            @endif                                                    
                                            ">
                                        <span
                                            id="count_like_{{ $post->id }}">{{ $post->likes->count() }}</span>
                                    </span>
                                </strong>
                               
                                {{-- dislike --}}
                                <a class="{{ $dislike }}" onclick="dislikePost({{ $post->id }})" id="btn_dislike_{{ $post->id }}">
                                    <strong><span class="la la-thumbs-down"></span> 
                                        {{ trans('learning::local.dislike') }}</strong>
                                </a>
                                {{-- count of post dislike --}}
                                <strong>
                                    <span id="tooltip_dislike_{{ $post->id }}" data-toggle="tooltip" data-placement="top"
                                        data-html="true" data-original-title="
                                        {{-- get names of dislikes --}}
                                        @if(count($post->dislikes) > 0)
                                            @foreach ($post->dislikes as $admin)
                                                {{-- teachers and admins
                                                --}}
                                                @isset($admin->admin->employeeUser)
                                                    {{ session('lang') == 'ar' ? $admin->admin->employeeUser->ar_st_name . ' ' . $admin->admin->employeeUser->ar_nd_name : $admin->admin->employeeUser->en_st_name . ' ' . $admin->admin->employeeUser->en_nd_name }}
                                                    </br>
                                                @endisset
                                                {{-- students --}}
                                                @isset($admin->user->studentUser)
                                                    {{ session('lang') == 'ar' ? $admin->user->studentUser->ar_student_name . ' ' . $admin->user->studentUser->father->ar_st_name : $admin->user->studentUser->en_student_name . ' ' . $admin->user->studentUser->father->en_st_name }}
                                                    </br>
                                                @endisset
                                            @endforeach
                                        @else
                                            {{ trans('learning::local.none') }}
                                        @endif">                                                
                                        <span id="count_dislike_{{ $post->id }}">{{ $post->dislikes->count() }}</span>
                                    </span>
                                </strong>
                            </div>

                            {{-- add comment --}}
                            <div id="commentField_{{ $post->id }}" class="panel panel-default"
                                style="padding:10px; margin-top:-20px; display:none;">
                                <div id="comment_{{ $post->id }}"> </div>
                                <fieldset class="mt-2">
                                    <form id="commentForm_{{ $post->id }}">
                                        @csrf
                                        <input type="hidden" value="{{ $post->id }}" name="post_id">
                                        <div class="form-group">
                                            <textarea name="comment_text" id="text_{{ $post->id }}" data-id="{{ $post->id }}" cols="30"
                                                rows="10" class="form-control editor"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-info round submitComment" value="{{ $post->id }}">
                                                <i class="la la-comment"></i> {{ trans('learning::local.add_comment') }}
                                            </button>
                                            <button type="button" class="btn btn-light round" onclick="loadComments({{ $post->id }})">
                                                {{ trans('learning::local.close') }}
                                            </button>
                                        </div>
                                    </form>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    @include('learning::teacher.posts.includes._show-likes-comments')
    @include('learning::teacher.posts.includes._show-dislikes-comments')
@endsection
@section('script')
    <script>
        // likes post and comments
        // like post
        function likePost(post_id) {
            $.ajax({
                url: "{{ route('student-post.like') }}",
                method: "POST",
                dataType: "json",
                data: {
                    post_id: post_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#count_like_' + post_id).html(data.like);
                    $('#count_dislike_' + post_id).html(data.dislike);
                    $('#btn_like_' + post_id).addClass('blue');
                    $('#btn_dislike_' + post_id).removeClass('red');

                    // get all like names
                    $('#tooltip_like_' + post_id).attr('data-original-title',data.like_names);
                    $('#tooltip_dislike_' + post_id).attr('data-original-title',data.dislike_names);
                }
            })
        }
        // dislike post
        function dislikePost(post_id) {
            $.ajax({
                url: "{{ route('student-post.dislike') }}",
                method: "POST",
                dataType: "json",
                data: {
                    post_id: post_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#count_like_' + post_id).html(data.like);
                    $('#count_dislike_' + post_id).html(data.dislike);
                    $('#btn_dislike_' + post_id).addClass('red');
                    $('#btn_like_' + post_id).removeClass('blue');

                    // get all like names
                    $('#tooltip_like_' + post_id).attr('data-original-title',data.like_names);
                    $('#tooltip_dislike_' + post_id).attr('data-original-title',data.dislike_names);
                }
            })
        }
        // like comment
        function likeComment(comment_id) {
            $.ajax({
                url: "{{ route('student-comment.like') }}",
                method: "POST",
                dataType: "json",
                data: {
                    comment_id: comment_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#count_comment_like_' + comment_id).html(data.like);
                    $('#count_comment_dislike_' + comment_id).html(data.dislike);
                    $('#btn_comment_like_' + comment_id).addClass('blue');
                    $('#btn_comment_dislike_' + comment_id).removeClass('red');
                }
            })
        }
        // dislike comment
        function dislikeComment(comment_id) {
            $.ajax({
                url: "{{ route('student-comment.dislike') }}",
                method: "POST",
                dataType: "json",
                data: {
                    comment_id: comment_id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    $('#count_comment_like_' + comment_id).html(data.like);
                    $('#count_comment_dislike_' + comment_id).html(data.dislike);
                    $('#btn_comment_dislike_' + comment_id).addClass('red');
                    $('#btn_comment_like_' + comment_id).removeClass('blue');
                }
            })
        }

        // show likes comments
        function showLikes(comment_id) {
            $.ajax({
                url: "{{ route('student-comment.show-likes') }}",
                type: "post",
                data: {
                    _method: 'PUT',
                    comment_id: comment_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('#names_likes').html(data);
                }
            })
            $('#like-comments-modal').modal('show');
        }

        function showDislikes(comment_id) {
            $.ajax({
                url: "{{ route('student-comment.show-dislike') }}",
                type: "post",
                data: {
                    _method: 'PUT',
                    comment_id: comment_id,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {
                    $('#names_dislikes').html(data);
                }
            })
            $('#dislike-comments-modal').modal('show');
        }    

        function loadComments(id) {
            post_id = id;
            if ($('#commentField_' + id).is(':visible')) {
                $('#commentField_' + id).slideUp();
            } else {
                $('#commentField_' + id).slideDown();
                getComment(id);
            }
        }

        var post_id;
        $(document).ready(function() {
            $(document).on('click', '.submitComment', function() {
                event.preventDefault();
                var id = $(this).val();
                $('.editor').val(CKEDITOR.instances['text_' + id].getData());
                var form_data = new FormData($('#commentForm_' + id)[0]);

                $.ajax({
                    url: "{{ route('student-store.comment') }}",
                    method: "POST",
                    data: form_data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    // display succees message
                    success: function(data) {
                        getComment(id);
                        $('#commentForm_' + id)[0].reset();
                        CKEDITOR.instances['text_' + id].setData('');
                    }
                });
            });
        });

        $(document).on('click', '.comment', function() {
            var id = $(this).val();
            post_id = id;
            if ($('#commentField_' + id).is(':visible')) {
                $('#commentField_' + id).slideUp();
            } else {
                $('#commentField_' + id).slideDown();
                getComment(id);
            }
        });

        function getComment(id) {
            $.ajax({
                url: "{{ route('student.comments') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    countComment(id);
                    $('#comment_' + id).html(data);
                }
            });
        }

        function countComment(id) {
            $.ajax({
                url: "{{ route('student-comments.count') }}",
                data: {
                    id: id
                },
                success: function(data) {
                    $('#count_' + id).html(data);
                }
            });
        }

        setInterval(function() {
            getComment(post_id)
        }, 5000); //1000 second

    </script>
    <script src="{{ asset('cpanel/app-assets/js/scripts/tooltip/tooltip.js') }}"></script>
    {{-- use ckeditor --}}
    <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
    <script>
        $(".editor").each(function() {
            let id = $(this).attr('id');
            CKEDITOR.replace(id, {
                toolbar: [{
                        name: 'basicstyles',
                        groups: ['basicstyles', 'cleanup'],
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
                            '-', 'RemoveFormat'
                        ]
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                            'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                            'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'
                        ]
                    },
                    {
                        name: 'styles',
                        items: ['FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize']
                    },
                ]
            });
        });

    </script>
@endsection
