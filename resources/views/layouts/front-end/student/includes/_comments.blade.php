<div class="pull-left" id=""><i class="la la-comments"></i> {{ trans('learning::local.comments') }}
    <span>{{$comment_count}}</span></div>
@foreach($comments as $comment)
<h4 class="card-title" id="heading-icon-dropdown">
    @empty($comment->ar_name)
        <span class="avatar avatar-online">
            @isset(userAuthInfo()->image_profile)
            <img src="{{asset('images/imagesProfile/'.userAuthInfo()->image_profile)}}" alt="avatar">                          
            @endisset
            @empty(userAuthInfo()->image_profile)                          
            <img src="{{asset('images/studentsImages/37.jpeg')}}" alt="avatar">                          
            @endempty
        </span>
        <strong>{{session('lang') == 'ar'? $comment->ar_student_name : $comment->en_student_name}} </strong>        
    @endempty
    
    @empty($comment->ar_student_name)
        <span class="avatar avatar-online">
            @isset(authInfo()->image_profile)
            <img src="{{asset('images/imagesProfile/'.authInfo()->image_profile)}}" alt="avatar">                          
            @endisset
            @empty(authInfo()->image_profile)                          
            <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
            @endempty
        </span>
        <strong>{{session('lang') == 'ar'? $comment->ar_name : $comment->name}} </strong>        
    @endempty
    <span class="small  d-none d-sm-inline-block">{{$comment->created_at->diffForHumans()}}</span>
</h4>
<span class="small  d-inline-block d-sm-none">{{$comment->created_at->diffForHumans()}}</span>
<p class="ml-3">{{ $comment->comment_text }}</p>

@endforeach