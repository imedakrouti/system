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
            <li class="breadcrumb-item"><a href="{{route('parent-requests.index')}}">{{ trans('student::local.parent_requests') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('parent-requests.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                      <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.student_name') }}</label> <br>
                            <select name="student_id[]" class="form-control select2" style="width: 100%" multiple required>
                                @foreach ($students as $student)
                                    <option {{old('student_id') == $student->id ? 'selected' :''}} value="{{$student->id}}">
                                        @if (session('lang') == 'ar')
                                        [{{$student->student_number}}] {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}
                                    @else
                                        [{{$student->student_number}}] {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}
                                    @endif
                                    </option>
                                @endforeach
                            </select> <br>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.date_request') }}</label> <br>
                            <input type="date" class="form-control" required name="date_request" value="{{old('date_request')}}">
                            <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                    </div>                     
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.time_request') }}</label> <br>                    
                            <input type="time" class="form-control" required name="time_request" value="{{old('time_request')}}">
                              <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                    </div>  
                    <div class="col-lg-8 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('student::local.notes') }}</label> <br>                 
                              <textarea name="notes" class="form-control" required cols="30" rows="5">{{old('notes')}}</textarea>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                    </div>   
                    </div>                                                       
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('parent-requests.index')}}';">
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
