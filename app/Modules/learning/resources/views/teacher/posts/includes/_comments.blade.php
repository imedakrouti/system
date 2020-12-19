@foreach ($comments as $comment)

    <div id="heading-icon-dropdown">
        {{-- from user account --}}
        @empty($comment->ar_student_name)
            <span class="avatar avatar-online">
                @isset($comment->user->studentUser->student_image)
                    <img src="{{ asset('images/studentsImages/' . $comment->user->studentUser->student_image) }}" alt="avatar">
                @endisset
                @empty($comment->user->studentUser->student_image)
                    <img src="{{ asset('images/studentsImages/37.jpeg') }}" alt="avatar">
                @endempty
            </span>
            <strong>{{ session('lang') == 'ar' ? $comment->ar_student_name : $comment->en_student_name }} </strong>
        @endempty

        {{-- from admin account --}}
        @empty($comment->ar_name)
            <span class="avatar avatar-online">
                @isset($comment->admin->image_profile)
                    <img src="{{ asset('images/imagesProfile/' . $comment->admin->image_profile) }}" alt="avatar">
                @endisset
                @empty($comment->admin->image_profile)
                    <img src="{{ asset('images/website/male.png') }}" alt="avatar">
                @endempty
            </span>
            <strong>{{ session('lang') == 'ar' ? $comment->ar_name : $comment->name }} </strong>
        @endempty
        {{-- time --}}
        <span class="small d-none d-sm-inline-block">{{ $comment->created_at->diffForHumans() }}</span>
        {{-- delete accoutn from teacher accout --}}
        <a class="red {{ session('lang') == 'ar' ? ' pull-left ml-2' : ' pull-right mr-2' }}"
            onclick="deleteComment({{ $comment->id }})"><i class="la la-trash"></i>
            {{ trans('learning::local.delete_comment') }}</a>
    </div>
    <span class="small d-inline-block d-sm-none">{{ $comment->created_at->diffForHumans() }}</span>
    <div>
        {{-- comment body --}}
        <span class="comment-text ml-3"><strong>{!! $comment->comment_text !!}</strong></span>
    </div>
    @php
    $like_comment = null;
    $dislike_comment = null;
    @endphp
    {{-- teacher account --}}
    {{-- check if teache make like or dislike --}}
    @foreach ($comment->likes as $like)
        @isset($like->admin_id)
            @if ($like->admin_id == authInfo()->id)
                @php
                $like_comment = 'blue'
                @endphp
            @endif
        @endisset
    @endforeach

    @foreach ($comment->dislikes as $dislike)
        @isset($dislike->admin_id)
            @if ($dislike->admin_id == authInfo()->id)
                @php
                $dislike_comment = 'red'
                @endphp
            @endif
        @endisset
    @endforeach
    {{-- end teacher account --}}
    
    {{-- like and dislike for comments --}}
    <div class="mb-1">
        <a class="ml-2 secandary {{ $like_comment }}" id="btn_comment_like_{{ $comment->id }}"
            onclick="likeComment({{ $comment->id }})">
            <span class="la la-thumbs-up"></span> {{ trans('learning::local.like') }}
        </a>
        <a onclick="showLikes({{ $comment->id }})">
            <strong>
                
                <span id="count_comment_like_{{ $comment->id }}">{{ $comment->likes->count() }}</span>
            </strong>
        </a>
        <a class="secandary  {{ $dislike_comment }}" id="btn_comment_dislike_{{ $comment->id }}"
            onclick="dislikeComment({{ $comment->id }})">
            <span class="la la-thumbs-down"></span> {{ trans('learning::local.dislike') }}
        </a>
        <a onclick="showDislikes({{ $comment->id }})">
            <strong>                
                <span id="count_comment_dislike_{{ $comment->id }}">{{ $comment->dislikes->count() }}</span>
            </strong>
        </a>
    </div>
@endforeach
