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
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('announcements.index')}}">{{ trans('staff::local.announcements') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('announcements.update',$announcement->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.start_at') }}</label>
                              <input type="date" class="form-control " value="{{old('start_at',$announcement->start_at)}}" 
                              placeholder="{{ trans('staff::local.start_at') }}"
                                name="start_at" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.end_at') }}</label>
                              <input type="date" class="form-control " value="{{old('end_at',$announcement->end_at)}}" 
                              placeholder="{{ trans('staff::local.end_at') }}"
                                name="end_at" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.domain_role') }}</label>
                              <select name="domain_role" class="form-control">
                                <option value="">{{ trans('staff::local.select') }}</option>
                                <option {{old('domain_role',$announcement->domain_role) == trans('staff::local.super_admin')?'selected':''}} value="super admin">{{ trans('staff::local.super_admin') }}</option>
                                <option {{old('domain_role',$announcement->domain_role) == trans('staff::local.manager')?'selected':''}} value="manager">{{ trans('staff::local.manager') }}</option>
                                <option {{old('domain_role',$announcement->domain_role) == trans('staff::local.super_visor')?'selected':''}} value="super visor">{{ trans('staff::local.super_visor') }}</option>
                                <option {{old('domain_role',$announcement->domain_role) == trans('staff::local.staff')?'selected':''}} value="staff">{{ trans('staff::local.staff') }}</option>
                                <option {{old('domain_role',$announcement->domain_role) == trans('staff::local.teacher')?'selected':''}} value="teacher">{{ trans('staff::local.teacher') }}</option>                    
                              </select> <br>
                              <span class="red">{{ trans('staff::local.required') }}</span>                                                   
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-md-12"> 
                        <div class="form-group row">
                            <label>{{ trans('staff::local.announcement') }}</label>
                            <textarea class="form-control" name="announcement" cols="30" rows="5">{{old('announcement',$announcement->announcement)}}</textarea>                                                                 
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                   
                        </div>
                    </div>   
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('announcements.index')}}';">
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