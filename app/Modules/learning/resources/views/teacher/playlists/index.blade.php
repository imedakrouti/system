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
    @empty(count($playlists))
    <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-info-circle"></i></span>               
        {{ trans('learning::local.no_playlists') }}
    </div>     
    @endempty
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @include('layouts.backEnd.includes._msg')
            <ul class="list-group">     
                @foreach ($playlists as $index => $playlist) 
                    <li class="list-group-item">                                
                        <span class="badge badge-info badge-pill float-right">{{ trans('student.lessons') }} {{$playlist->lessons->count()}}</span>
                        <a style="color: #7f888f;font-size:20px;font-weight:800" href="{{route('teacher.show-lessons',$playlist->id)}}">
                          {{$index+1}} - {{$playlist->playlist_name}}</a>
                        <br>
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

                    </li>
        
              @endforeach  
            </ul>
          </div>
        </div>
      </div>
  </div>
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
