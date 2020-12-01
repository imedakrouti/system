@extends('layouts.front-end.student.index')
@section('styles')
    <style>
        .shadow{
            /* text-shadow: 0px 0px 1px rgba(0, 0, 0, 0.7); */
            color: #194872;
        }
    </style>
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>            
    </div>      
</div>
<h4 class="blue mb-1">
    {{session('lang') == 'ar' ?                 
    $employee->ar_st_name .' ' .$employee->ar_nd_name.' '.$employee->ar_rd_name 
    : 
    $employee->en_st_name .' ' .$employee->en_nd_name.' '.$employee->en_rd_name}}                    
</h4>
<div class="row mt-1">
    @empty(count($playlists))
    <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-info-circle"></i></span>               
        {{ trans('learning::local.no_playlists') }}
    </div>     
    @endempty

    @foreach ($playlists as $playlist) 
        @foreach ($playlist->classes as $classroom)
            @if ($classroom->id == classroom_id())
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body text-left mb-1">
                                <h3 class="danger">{{$playlist->lessons->count()}}</h3>
                                <span><a href="{{route('student.show-lessons',$playlist->id)}}">{{$playlist->playlist_name}}</a></span>
                
                                </div>
                                <div class="align-self-center">
                                <a href="{{route('student.show-lessons',$playlist->id)}}"><i class="la la-youtube-play info font-large-2 float-right"></i></a>
                                </div>
                            </div>
                            <div class="mb-1 badge badge-primary">
                                <span>{{session('lang') == 'ar' ? $playlist->subjects->ar_shortcut : $playlist->subjects->en_shortcut}}</span>
                                <i class="la la-book font-medium-3"></i>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>                  
            @endif
        @endforeach
@endforeach  
</div>
@endsection