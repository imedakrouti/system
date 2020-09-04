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
            <li class="breadcrumb-item"><a href="{{route('meetings.index')}}">{{ trans('student::local.interviews_dates') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('meetings.update',$meeting->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.father_name') }}</label>
                          <div class="col-md-9">
                            <select name="father_id" class="form-control select2" required>
                                @foreach ($fathers as $father)
                                    <option {{old('father_id',$meeting->father_id) == $father->id ? 'selected' :''}} value="{{$father->id}}">{{$father->ar_st_name}}</option>
                                @endforeach
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.notes') }}</label>
                          <div class="col-md-9">                            
                              <input type="datetime-local" name="start" value="{{old('start',$meeting->start)}}" class="form-control" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.notes') }}</label>
                          <div class="col-md-9">                            
                              <input type="datetime-local" name="end" value="{{old('end',$meeting->end)}}" class="form-control" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                      <label class="col-md-3 label-control">{{ trans('student::local.meeting_status') }}</label>
                      <div class="col-md-9">                    
                          <select name="meeting_status" class="form-control" required>
                              <option value="">{{ trans('student::local.select') }}</option>
                              <option {{old('meeting_status',$meeting->meeting_status) == trans('student::local.meeting_pending') ||
                                      old('meeting_status',$meeting->meeting_status) == 'pending'
                              ?'selected':''}} value="pending">{{ trans('student::local.meeting_pending') }}</option>
                              <option {{old('meeting_status',$meeting->meeting_status) == trans('student::local.meeting_canceled') ||
                                      old('meeting_status',$meeting->meeting_status) == 'canceled'
                              ?'selected':''}} value="canceled">{{ trans('student::local.meeting_canceled') }}</option>                                
                              <option {{old('meeting_status',$meeting->meeting_status) == trans('student::local.meeting_done') ||
                                      old('meeting_status',$meeting->meeting_status) == 'done'
                              ?'selected':''}} value="done">{{ trans('student::local.meeting_done') }}</option>                                                                                            
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                      </div>
                      </div>
                  </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.notes') }}</label>
                          <div class="col-md-9">                            
                              <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes',$meeting->notes)}}</textarea>
                          </div>
                        </div>
                    </div>                                               
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('meetings.index')}}';">
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
