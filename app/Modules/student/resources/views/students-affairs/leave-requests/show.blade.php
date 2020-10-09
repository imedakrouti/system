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
            <div class="row">
                <div class="col-md-12">                
                  <h5> {{ trans('student::local.student_data') }}</h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h5><strong>{{ trans('student::local.student_number') }} :</strong> {{$leave->students->student_number}}</h5>                
                      <h5><strong>{{ trans('student::local.student_name') }} :</strong>
                        @if (session('lang') == 'ar')
                            <a href="{{route('students.show',$leave->students->id)}}">
                                {{$leave->students->ar_student_name}}  {{$leave->students->father->ar_st_name}}
                                {{$leave->students->father->ar_nd_name}} {{$leave->students->father->ar_rd_name}}
                            </a>
                        @else
                            <a href="{{route('students.show',$leave->students->id)}}">
                                {{$leave->students->en_student_name}}  {{$leave->students->father->en_st_name}}
                                {{$leave->students->father->en_nd_name}} {{$leave->students->father->en_rd_name}}                            
                            </a>
                        @endif
                      </h5>
                      <h5><strong>{{ trans('student::local.grade') }} :</strong> {{session('lang') == 'ar' ? 
                      $leave->students->grade->ar_grade_name : $leave->students->grade->en_grade_name}}</h5>
                      <h5><strong>{{ trans('student::local.division') }} : </strong>{{session('lang') == 'ar' ? 
                        $leave->students->division->ar_division_name : $leave->students->division->en_division_name}}</h5>              
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">                
                  <div class="row">
                    <div class="col-md-6">
                      <h5><strong>{{ trans('student::local.parent_type') }} :</strong> {{$leave->parent_type}}</h5>                
                      <h5><strong>{{ trans('student::local.leave_reason') }} :</strong> {{$leave->reason}}</h5>
                      <h5><strong>{{ trans('student::local.notes') }} :</strong> {{$leave->notes}}</h5>                                   
                      <h5><strong>{{ trans('student::local.created_by') }} :</strong> {{$leave->admin->name}}</h5>                                   
                      <h5><strong>{{ trans('student::local.created_at') }} :</strong> {{$leave->created_at}}</h5>                                                         
                    </div>
                  </div>
                  <div class="row mt-1">
                    <div class="col-md-6">
                      <a class="btn btn-warning" href="{{route('leave-requests.edit',$leave->id)}}">{{ trans('student::local.edit') }}</a>                                       
                      <a class="btn btn-primary" href="{{route('leave-requests.print',$leave->id)}}">{{ trans('student::local.print') }}</a>                                       
                    </div>
                  </div>                  
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection

