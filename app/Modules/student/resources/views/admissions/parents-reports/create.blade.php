@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('parent-reports.index')}}">{{ trans('student::local.parent_reports') }}</a></li>
            <li class="breadcrumb-item active">{{$title}}
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
            <form class="form form-horizontal" method="POST" enctype="multipart/form-data" action="{{route('parent-reports.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('student::local.father_name') }}</label> <br>
                          <select name="father_id[]" class="form-control select2" multiple required>
                              @foreach ($fathers as $father)
                                  <option {{old('father_id') == $father->id ? 'selected' :''}} value="{{$father->id}}">
                                  @if (session('lang') == 'ar')
                                    {{$father->ar_st_name}} {{$father->ar_nd_name}} {{$father->ar_rd_name}} {{$father->ar_th_name}}
                                  @else
                                    {{$father->en_st_name}} {{$father->en_nd_name}} {{$father->en_rd_name}} {{$father->en_th_name}}
                                  @endif
                                  </option>
                              @endforeach
                          </select>  <br>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>   
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">    
                          <label>{{ trans('student::local.report_title') }}</label>
                          <input type="text" class="form-control" name="report_title" value="{{old('report_title')}}" placeholder="{{ trans('student::local.report_title') }}" required>                          
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>  
                    <div class="col-md-12">
                        <div class="form-group">                          
                          <textarea name="report" class="form-control" placeholder="{{ trans('student::local.report') }}" required
                          cols="30" rows="20">{{old('report')}}</textarea>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>                                                                              
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('parent-reports.index')}}';">
                    <i class="ft-x"></i> {{ trans('admin.cancel') }}
                  </button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
