@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('holidays.index')}}">{{ trans('staff::local.holidays') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('holidays-days.index',$holiday->id)}}">{{ $holiday_name }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('holidays-days.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                  <input type="hidden" name="holiday_id" value="{{$holiday->id}}">
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.date_holiday_from') }}</label>
                              <input type="date" class="form-control " name="from_date" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.date_holiday_to') }}</label>
                              <input type="date" class="form-control" name="to_date" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group row">
                        <label>{{ trans('staff::local.description') }}</label>
                        <textarea name="description" class="form-control" cols="30" rows="5">{{old('description')}}</textarea>
                          <span class="red">{{ trans('staff::local.required') }}</span>                          
                      </div>
                    </div>                                                          
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('holidays-days.index',$holiday->id)}}';">
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
