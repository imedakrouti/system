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
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">            
              @empty(count($lessons))
              <div class="bs-callout-danger callout-border-left callout-round p-2 py-1 mb-1">
                    <h5>{{ trans('learning::local.no_lessons') }} <span><a href="{{route('playlists.index')}}"> {{ trans('admin.back') }}</a></span></h5> 
              </div>                             
              @endempty              
            @foreach ($lessons as $lesson)
                <div class="bs-callout-primary callout-border-left callout-round p-2 py-1 mb-1">
                    <h4 class="pl-2"><a target="blank" href="{{route('lessons.show',$lesson->id)}}"><strong>{{$lesson->lesson_title}}</strong></a></h4>
                    <p>{{$lesson->description}}.</p>
                    <div class="form-group">
                        <h6 class="small"><strong>{{ trans('learning::local.created_by') }} : </strong>{{session('lang') == 'ar' ? $lesson->admin->ar_name : $lesson->admin->name}}</h6>
                        <h6 class="small"><strong>{{ trans('learning::local.created_at') }} : </strong>{{$lesson->created_at->diffForHumans()}}</h6>
                        <h6 class="small"><strong>{{ trans('learning::local.last_updated') }} :</strong> :{{$lesson->updated_at->diffForHumans()}}</h6>
                      </div>
                      <div class="ml-3">
                        @foreach ($lesson->divisions as $division)                    
                            <div class="badge badge-info">
                            <span>{{session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name}}</span>
                            <i class="la la-folder-o font-medium-3"></i>
                        </div>
                        @endforeach
                        @foreach ($lesson->grades as $grade)                    
                            <div class="badge badge-success">
                            <span>{{session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name}}</span>
                            <i class="la la-folder-o font-medium-3"></i>
                        </div>
                        @endforeach
                        @foreach ($lesson->years as $year)                    
                            <div class="badge badge-primary">
                            <span>{{$year->name}}</span>
                            <i class="la la-calendar font-medium-3"></i>
                        </div>
                        @endforeach                          
                      </div>                                            
                </div> 
            @endforeach                        
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
