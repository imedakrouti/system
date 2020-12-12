
@foreach($comments as $comment)
<div class="comment-text mb-1">
    <div id="heading-icon-dropdown">
        @empty($comment->ar_name)
            <span class="avatar avatar-online">
                @isset($comment->user->image_profile)
                <img src="{{asset('images/imagesProfile/'.$comment->user->image_profile)}}" alt="avatar">                          
                @endisset
                @empty($comment->user->image_profile)                          
                <img src="{{asset('images/studentsImages/37.jpeg')}}" alt="avatar">                          
                @endempty
            </span>
            <strong>{{session('lang') == 'ar'? $comment->ar_student_name : $comment->en_student_name}} </strong>        
        @endempty
        
        @empty($comment->ar_student_name)
            <span class="avatar avatar-online">
                @isset($comment->admin->image_profile)
                <img src="{{asset('images/imagesProfile/'.$comment->admin->image_profile)}}" alt="avatar">                          
                @endisset
                @empty($comment->admin->image_profile)                          
                <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
                @endempty
            </span>
            <strong>{{session('lang') == 'ar'? $comment->ar_name : $comment->name}} </strong>        
        @endempty
        <span class="small d-none d-sm-inline-block">{{$comment->created_at->diffForHumans()}}            
            
        </span>
        <a class="red pull-right mr-2" onclick="deleteComment({{$comment->id}})"><i class="la la-trash"></i> {{ trans('learning::local.delete_comment') }}</a>
        </div>
    <span class="small d-inline-block d-sm-none">{{$comment->created_at->diffForHumans()}}</span>
    <div class="ml-2 mt-1">{!!$comment->comment_text!!}</div>  
</div>

@endforeach