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
            <li class="breadcrumb-item"><a href="{{route('assessment-result.index')}}">{{ trans('student::local.assessment_results') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('assessment-result.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-9">
                        <div class="form-group row">
                          <label class="col-md-2 label-control">{{ trans('student::local.student_name') }}</label>
                          <div class="col-md-4">
                            <select name="student_id" class="form-control select2" required>
                                <option value="">{{ trans('admin.select') }}</option>
                                @foreach ($students as $student)
                                    <option {{old('student_id') == $student->id ? 'selected' :''}} value="{{$student->id}}">
                                    @if (session('lang') == 'ar')
                                    {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}
                                    @else
                                    {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}
                                    @endif
                                    </option>
                                @endforeach
                            </select>    
                            <span class="red">{{ trans('student::local.requried') }}</span>                        
                          </div>
                        </div>
                    </div>    
                    <div class="col-md-9">
                        <div class="form-group row">
                          <label class="col-md-2 label-control">{{ trans('student::local.assessment_type') }}</label>
                          <div class="col-md-4">
                            <select name="assessment_type" class="form-control" required>
                              <option value="assessment">{{ trans('student::local.assessment') }}</option>
                              <option value="re-assessment">{{ trans('student::local.re_assessment') }}</option>
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>  
                    <div class="col-md-9">
                      <div class="form-group row">
                        <label class="col-md-2 label-control">{{ trans('student::local.final_evaluation') }}</label>
                        <div class="col-md-4">
                          <select name="acceptance" class="form-control" required>
                            <option value="accepted">{{ trans('student::local.accepted') }}</option>
                            <option value="rejected">{{ trans('student::local.rejected') }}</option>
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                      </div>
                  </div>                      
                    <div class="col-md-9">
                      <div class="form-group row">
                        <label class="col-md-2 label-control">{{ trans('student::local.notes') }}</label>
                        <div class="col-md-10">
                          <textarea name="notes" class="form-control" cols="30" rows="5"></textarea>                           
                        </div>
                      </div>
                  </div> 
                    <div class="col-md-9">
                        <div class="form-group row">
                          <label class="col-md-2 label-control">{{ trans('student::local.tests') }}</label>
                          <div class="col-md-10">
                            <div class="form-group col-md-12 mb-2 contact-repeater">
                                <div data-repeater-list="repeater-group">
                                  <div class="input-group mb-1" data-repeater-item>                                                                        
                                    
                                    <select name="acceptance_test_id" required class="form-control" style="margin-left: 10px;margin-top:0px">
                                        <option value="">{{ trans('student::local.subject_name') }}</option>
                                        @foreach ($tests as $test)
                                            <option value="{{$test->id}}">{{$test->ar_test_name}}</option>
                                        @endforeach
                                    </select>
                                    
                                    <select name="test_result" required class="form-control" style="margin-left: 10px;margin-top:0px">
                                        <option value="">{{ trans('student::local.evaluation') }}</option>
                                        <option value="excellent">{{ trans('student::local.excellent') }}</option>
                                        <option value="very good">{{ trans('student::local.very_good') }}</option>
                                        <option value="good">{{ trans('student::local.good') }}</option>
                                        <option value="weak">{{ trans('student::local.weak') }}</option>
                                    </select>
                                    <select name="employee_id" required class="form-control" style="margin-top:0px">
                                        <option value="">{{ trans('student::local.teacher_name') }}</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->arEmployeeName}}</option>
                                        @endforeach
                                    </select>
                                                                      
                                    <span class="input-group-append" id="button-addon2">
                                      <button style="height: 40px;" class="btn btn-danger btn-sm" type="button" data-repeater-delete><i class="ft-x"></i></button>
                                    </span>
                                    <span class="red">{{ trans('student::local.requried') }}</span>
                                  </div>
                                </div>
                                <button type="button" data-repeater-create class="btn btn-primary">
                                  <i class="ft-plus"></i> {{ trans('student::local.add_test_result') }}
                                </button>
                              </div>
                          </div>
                        </div>
                    </div>                      
                                   
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('assessment-result.index')}}';">
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
@section('script')
<script src="{{asset('public/cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('public/cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@endsection
