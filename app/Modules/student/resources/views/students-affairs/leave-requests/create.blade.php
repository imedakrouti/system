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
            <li class="breadcrumb-item"><a href="{{route('leave-requests.index')}}">{{ trans('student::local.leave_requests') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('leave-requests.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.student_name') }}</label>
                          <div class="col-md-9">
                            <select name="student_id" class="form-control select2" multiple required>
                                @foreach ($students as $student)
                                    <option value="{{$student->id}}">
                                        @foreach ($students as $student)
                                        <option {{old('student_id') == $student->id ? 'selected' :''}} value="{{$student->id}}">
                                            @if (session('lang') == 'ar')
                                        {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}
                                        @else
                                            {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}
                                        @endif
                                        </option>
                                    @endforeach
                                    </option>
                                @endforeach
                            </select>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.parent_type') }}</label>                         
                          <div class="col-md-9">
                            <select name="school_type" class="form-control" required>
                                <option value="father">{{ trans('student::local.father') }}</option>
                                <option value="mother">{{ trans('student::local.mother') }}</option>
                                <option value="others">{{ trans('student::local.others') }}</option>                                
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>                     
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.leave_reason') }}</label>
                          <div class="col-md-9">                         
                              <textarea name="reason" class="form-control" required cols="30" rows="5">{{old('reason')}}</textarea>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.notes') }}</label>
                          <div class="col-md-9">                         
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
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('leave-requests.index')}}';">
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
