@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">      
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>            
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
{{-- Statistics --}}
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-warning">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['applicants']}}</h3>
                <span>{{ trans('student::local.all_applicants') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-child text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-success">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['students']}}</h3>
                <span>{{ trans('student::local.all_students') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-graduation-cap text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-danger">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['parents']}}</h3>
                <span>{{ trans('student::local.parents') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-users text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card bg-info">
        <div class="card-content">
          <div class="card-body">
            <div class="media d-flex">
              <div class="media-body text-white text-left">
                <h3 class="text-white">{{$data['guardians']}}</h3>
                <span>{{ trans('student::local.guardians') }}</span>
              </div>
              <div class="align-self-center">
                <i class="la la-male text-white font-large-2 float-right"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
