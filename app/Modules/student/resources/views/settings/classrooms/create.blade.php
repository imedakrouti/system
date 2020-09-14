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
            <li class="breadcrumb-item"><a href="{{route('classrooms.index')}}">{{ trans('student::local.classrooms') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('classrooms.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.ar_name_classroom') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('ar_name_classroom')}}" placeholder="{{ trans('student::local.ar_name_classroom') }}"
                              name="ar_name_classroom" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.en_name_classroom') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('en_name_classroom')}}" placeholder="{{ trans('student::local.en_name_classroom') }}"
                              name="en_name_classroom" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.division') }}</label>
                          <div class="col-md-9">
                            <select name="division_id" class="form-control" required>
                                @foreach ($divisions as $division)
                                    <option {{old('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                                        {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                                @endforeach
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>    
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.grade') }}</label>
                          <div class="col-md-9">
                            <select name="grade_id" class="form-control" required>
                                @foreach ($grades as $grade)
                                    <option {{old('grade_id') == $grade->id ? 'selected' : ''}} value="{{$grade->id}}">
                                        {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                                @endforeach
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.grade') }}</label>
                          <div class="col-md-9">
                            <select name="year_id" class="form-control" required>
                                @foreach ($years as $year)
                                    <option {{old('year_id') == $year->id ? 'selected' : ''}} value="{{$year->id}}">
                                        {{$year->name}}</option>                                    
                                @endforeach
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.sort') }}</label>
                          <div class="col-md-9">
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
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('classrooms.index')}}';">
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
