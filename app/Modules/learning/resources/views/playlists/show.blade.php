@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$playlist->playlist_name}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('playlists.index')}}">{{ trans('learning::local.playlists') }}</a></li>
            <li class="breadcrumb-item active">{{$playlist->playlist_name}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>

<div class="row mt-1">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">            
            @empty(count($lessons))                                    
              <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                  <span class="alert-icon"><i class="la la-info-circle"></i></span>               
                  {{ trans('learning::local.no_lessons') }}
              </div>  
            @endempty   
          
            <div class="col-lg-12 col-md-12">
              @foreach ($lessons as $index=>$lesson)
              <div class="card collapse-icon accordion-icon-rotate">

                    <div id="headingCollapse_{{$lesson->id}}" class="card-header " style="border: .2px solid #c0c0c07d;">
                      <a style="color: #7f888f;font-size:20px;font-weight:800"  data-toggle="collapse" href="#collapse_{{$lesson->id}}" aria-expanded="false" aria-controls="collapse_{{$lesson->id}}"
                      class="card-title lead collapsed"><strong>{{++$index}} - {{$lesson->lesson_title}}</strong></a>
                    </div>
                    <div id="collapse_{{$lesson->id}}" role="tabpanel" aria-labelledby="headingCollapse_{{$lesson->id}}" class="card-collapse collapse " style="border: .2px solid #c0c0c07d;"
                    aria-expanded="true">
                      <div class="card-content">
                        <div class="card-body">
                          <p>{{$lesson->description}}</p>
                          <div class="form-group">
                              <h6 class="small"><strong>{{ trans('learning::local.created_by') }} : </strong>{{session('lang') == 'ar' ? $lesson->admin->ar_name : $lesson->admin->name}}
                              | <strong>{{ trans('learning::local.created_at') }} : </strong>{{$lesson->created_at->diffForHumans()}}
                              | <strong>{{ trans('learning::local.last_updated') }} :</strong> :{{$lesson->updated_at->diffForHumans()}}</h6>
                          </div>
                          <div class="ml-3">
                              <div class="badge badge-danger">
                                  <span><a href="{{route('lessons.show',$lesson->id)}}">{{ trans('learning::local.watch') }}</a></span>
                                  <i class="la la-tv font-medium-3"></i>
                              </div>  
                              <div class="badge badge-info">
                                  <span><a href="{{ route('teacher.students-views',$lesson->id) }}">
                                    {{ trans('learning::local.views') }} {{$lesson->views}} </a></span>
                                  <i class="la la-eye font-medium-3"></i>
                              </div>                                                                 
                              @foreach ($lesson->divisions as $division)                    
                                  <div class="badge badge-secondary">
                                  <span>{{session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name}}</span>
                                  <i class="la la-folder-o font-medium-3"></i>
                              </div>
                              @endforeach
                              @foreach ($lesson->grades as $grade)                    
                                  <div class="badge badge-primary">
                                  <span>{{session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name}}</span>
                                  <i class="la la-folder-o font-medium-3"></i>
                              </div>
                              @endforeach
                          </div>
                        </div>
                      </div>
                    </div>                        
                    
              </div>
              @endforeach
        </div>                                                
        {{$lessons->links()}}
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
