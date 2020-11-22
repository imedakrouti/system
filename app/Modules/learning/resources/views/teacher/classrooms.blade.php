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
</div>
<div class="row mt-1">
    @empty(count($classrooms))
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <h5 class="red">{{ trans('learning::local.no_classrooms') }}</h5>       
          </div>
        </div>
      </div>
    </div>
    @endempty
    @foreach ($classrooms as $classroom) 
        <div class="col-xl-3 col-lg-6 col-12">
            <div class="card">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="media-body text-left mb-1">
                      <h3 class="danger">20</h3>
                      <span><a href="{{route('teacher-posts.index',$classroom->id)}}">
                        {{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}
                        </a></span>

                    </div>
                    <div class="align-self-center">
                      <a href="{{route('teacher-posts.index',$classroom->id)}}"><i class="la la-graduation-cap info font-large-2 float-right"></i></a>
                    </div>
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
