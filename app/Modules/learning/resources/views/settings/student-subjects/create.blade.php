@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('student-subjects.index')}}">{{ trans('learning::local.student_subjects') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('student-subjects.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.student_name') }}</label>
                          <select name="student_id[]" class="form-control select2" multiple required>
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
                          <label>{{ trans('learning::local.subject') }}</label>
                          <select name="subject_id[]" class="form-control select2" multiple required>
                              @foreach ($subjects as $subject)
                                  <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                      {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                                                 
                                                                             
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('student-subjects.index')}}';">
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
