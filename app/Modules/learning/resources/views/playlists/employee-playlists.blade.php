@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{strip_tags($employee_name)}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('playlists.index')}}">{{ trans('learning::local.playlists') }}</a></li>
            <li class="breadcrumb-item active">{{strip_tags($employee_name)}}
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
            <h4 class="mb-2 red">{{ trans('learning::local.playlists') }}</h4>                    
            @foreach ($playlists as $playlist)
                <div class="bs-callout-primary callout-border-left callout-round p-2 py-1 mb-1">
                    <h4 class="pl-2"><a target="blank" href="{{route('playlists.show',$playlist->id)}}"><strong>{{$playlist->playlist_name}}</strong></a></h4>                                                               
                </div> 
            @endforeach  
            {{$playlists->links()}}                      
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
