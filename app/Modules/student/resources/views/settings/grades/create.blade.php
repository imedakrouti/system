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
            <li class="breadcrumb-item"><a href="{{route('grades.index')}}">{{ trans('student::local.grades') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('grades.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.ar_grade_name') }}</label>
                              <input type="text" class="form-control " value="{{old('ar_grade_name')}}" placeholder="{{ trans('student::local.ar_grade_name') }}"
                                name="ar_grade_name" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.en_grade_name') }}</label>
                              <input type="text" class="form-control " value="{{old('en_grade_name')}}" placeholder="{{ trans('student::local.en_grade_name') }}"
                                name="en_grade_name" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.ar_grade_parent') }}</label>
                              <input type="text" class="form-control " value="{{old('ar_grade_parent')}}" placeholder="{{ trans('student::local.ar_grade_parent') }}"
                                name="ar_grade_parent" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.en_grade_parent') }}</label>
                              <input type="text" class="form-control " value="{{old('en_grade_parent')}}" placeholder="{{ trans('student::local.en_grade_parent') }}"
                                name="en_grade_parent" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.from_age_year') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('from_age_year')}}" placeholder="{{ trans('student::local.from_age_year') }}"
                                name="from_age_year" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                             
                            </div>
                        </div> 
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.from_age_month') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('from_age_month')}}" placeholder="{{ trans('student::local.from_age_month') }}"
                                name="from_age_month" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div> 
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.to_age_year') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('to_age_year')}}" placeholder="{{ trans('student::local.to_age_year') }}"
                                name="to_age_year" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div> 
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.to_age_month') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('to_age_month')}}" placeholder="{{ trans('student::local.to_age_month') }}"
                                name="to_age_month" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div> 
                    </div>                   
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.sort') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('sort')}}" placeholder="{{ trans('student::local.sort') }}"
                                name="sort" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div> 
                    </div>   
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('grades.index')}}';">
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
