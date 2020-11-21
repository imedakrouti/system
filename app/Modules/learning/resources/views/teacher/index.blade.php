@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">                 
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-header-right col-md-6 col-12">
      <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        <a href="#" onclick="createPlaylist()" class="btn btn-success box-shadow round">{{ trans('learning::local.new_playlist') }}</a>
      </div>
    </div>
</div>
<div class="row mt-1">
    @empty($playlists->classes)
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <h5 class="red">{{ trans('learning::local.no_paylists') }}</h5>       
          </div>
        </div>
      </div>
    </div>
    @endempty
    @foreach ($playlists as $playlist) 
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left mb-1">
                      <h3 class="danger">{{$playlist->lessons->count()}}</h3>
                      <span><a href="{{route('teacher.show-lessons',$playlist->id)}}">{{$playlist->playlist_name}}</a></span>

                    </div>
                    <div class="align-self-center">
                      <a href="{{route('teacher.show-lessons',$playlist->id)}}"><i class="la la-youtube-play info font-large-2 float-right"></i></a>
                    </div>
                  </div>
     
                  @foreach ($playlist->classes as $class)                          
                      <div class="mb-1 badge badge-danger">
                          <span>{{session('lang') == 'ar' ? $class->ar_name_classroom : $class->en_name_classroom}}</span>
                          <i class="la la-group font-medium-3"></i>
                      </div>
                  @endforeach
                  <div class="mb-1 badge badge-primary">
                      <span>{{session('lang') == 'ar' ? $playlist->subjects->ar_shortcut : $playlist->subjects->en_shortcut}}</span>
                      <i class="la la-book font-medium-3"></i>
                  </div>
                </div>
              </div>
            </div>
        </div>  
    @endforeach
</div>
@include('learning::teacher.includes._create-playlist')

@endsection
@section('script')
    <script>
        function createPlaylist()
        {
            $('#playlist').modal({backdrop: 'static', keyboard: false})
            $('#playlist').modal('show');
        }
    </script>
@endsection
