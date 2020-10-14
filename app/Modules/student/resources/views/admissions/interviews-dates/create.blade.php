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
            <form class="form form-horizontal" method="POST" action="{{route('meetings.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.father_name') }}</label>
                          <select name="father_id[]" class="form-control select2" required multiple>
                              @foreach ($fathers as $father)
                                  <option {{old('father_id') == $father->id ? 'selected' :''}} value="{{$father->id}}">
                                  @if (session('lang') == 'ar')
                                    {{$father->ar_st_name}} {{$father->ar_nd_name}} {{$father->ar_rd_name}} {{$father->ar_th_name}}
                                  @else
                                    {{$father->en_st_name}} {{$father->en_nd_name}} {{$father->en_rd_name}} {{$father->en_th_name}}
                                  @endif
                                  </option>
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-md-4 col-md-6">
                      <div class="form-group">
                        <label>{{ trans('student::local.type_interview') }}</label> <br>
                        <select name="interview_id" class="form-control" required>
                            @foreach ($interviews as $interview)
                                <option {{old('interview_id') == $interview->id ? 'selected' :''}} value="{{$interview->id}}">{{$interview->ar_name_interview}}</option>
                            @endforeach
                        </select> <br>
                        <span class="red">{{ trans('student::local.requried') }}</span>                        
                      </div>
                  </div>                    
                    <div class="col-md-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.start') }}</label>
                          <input type="datetime-local" name="start" value="{{old('start')}}" class="form-control" required>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-md-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.end') }}</label>
                          <input type="datetime-local" name="end" value="{{old('end')}}" class="form-control" required>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-md-12 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('student::local.notes') }}</label>
                          <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes')}}</textarea>                          
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
