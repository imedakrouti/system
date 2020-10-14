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
            <li class="breadcrumb-item"><a href="{{route('schools.index')}}">{{ trans('student::local.schools_names') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('schools.update',$school->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.school_name') }}</label>
                          <input type="text" class="form-control " value="{{old('school_name',$school->school_name)}}" placeholder="{{ trans('student::local.school_name') }}"
                            name="school_name" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('student::local.school_address') }}</label>
                          <textarea name="school_address" class="form-control" required cols="30" rows="5">{{old('school_address',$school->school_address)}}</textarea>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>  
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.school_type') }}</label>                         
                          <select name="school_type" class="form-control" required>
                              <option value="">{{ trans('student::local.select') }}</option>
                              <option {{old('school_type',$school->school_type) == trans('student::local.private')?'selected':''}} value="private">{{ trans('student::local.private') }}</option>
                              <option {{old('school_type',$school->school_type) == trans('student::local.lang')?'selected':''}} value="lang">{{ trans('student::local.lang') }}</option>
                              <option {{old('school_type',$school->school_type) == trans('student::local.international')?'selected':''}} value="international">{{ trans('student::local.international') }}</option>                                
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.school_government') }}</label>
                          <input type="text" class="form-control " value="{{old('school_government',$school->school_government)}}" placeholder="{{ trans('student::local.school_government') }}"
                            name="school_government" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>   
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('schools.index')}}';">
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
