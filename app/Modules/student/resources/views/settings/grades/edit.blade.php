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
            <form class="form form-horizontal" method="POST" action="{{route('grades.update',$grade->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.ar_grade_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_grade_name',$grade->ar_grade_name)}}" placeholder="{{ trans('student::local.ar_grade_name') }}"
                                  name="ar_grade_name">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.en_grade_name') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('en_grade_name',$grade->en_grade_name)}}" placeholder="{{ trans('student::local.en_grade_name') }}"
                                  name="en_grade_name">
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.ar_grade_parent') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('ar_grade_parent',$grade->ar_grade_parent)}}" placeholder="{{ trans('student::local.ar_grade_parent') }}"
                                  name="ar_grade_parent">
                              </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.en_grade_parent') }}</label>
                              <div class="col-md-9">
                                <input type="text" class="form-control " value="{{old('en_grade_parent',$grade->en_grade_parent)}}" placeholder="{{ trans('student::local.en_grade_parent') }}"
                                  name="en_grade_parent">
                              </div>
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-6 label-control">{{ trans('student::local.from_age_year') }}</label>
                              <div class="col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('from_age_year',$grade->from_age_year)}}" placeholder="{{ trans('student::local.from_age_year') }}"
                                  name="from_age_year">
                              </div>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-6 label-control">{{ trans('student::local.from_age_month') }}</label>
                              <div class="col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('from_age_month',$grade->from_age_month)}}" placeholder="{{ trans('student::local.from_age_month') }}"
                                  name="from_age_month">
                              </div>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-6 label-control">{{ trans('student::local.to_age_year') }}</label>
                              <div class="col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('to_age_year',$grade->to_age_year)}}" placeholder="{{ trans('student::local.to_age_year') }}"
                                  name="to_age_year">
                              </div>
                            </div>
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group row">
                              <label class="col-md-6 label-control">{{ trans('student::local.to_age_month') }}</label>
                              <div class="col-md-6">
                                <input type="number" min="0" class="form-control " value="{{old('to_age_month',$grade->to_age_month)}}" placeholder="{{ trans('student::local.to_age_month') }}"
                                  name="to_age_month">
                              </div>
                            </div>
                        </div> 
                    </div>                   
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                              <label class="col-md-3 label-control">{{ trans('student::local.sort') }}</label>
                              <div class="col-md-9">
                                <input type="number" min="0" class="form-control " value="{{old('sort',$grade->sort)}}" placeholder="{{ trans('student::local.sort') }}"
                                  name="sort">
                              </div>
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
