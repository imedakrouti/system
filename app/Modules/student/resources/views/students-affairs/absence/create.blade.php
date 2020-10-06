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
            <li class="breadcrumb-item"><a href="{{route('absences.index')}}">{{ trans('student::local.absence') }}</a></li>
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
            <h4><strong>{{ trans('student::local.division') }} : </strong>
              {{session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name}}</h4>
            <h4><strong>{{ trans('student::local.grade') }} :</strong>
              {{session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name}}</h4>
            <h4><strong>{{ trans('student::local.class_room') }} :</strong>
              {{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}</h4>
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
            <form class="form form-horizontal" method="POST" action="{{route('absences.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>                    
                    <div class="table-responsive">
                      <table class="table" >
                        <thead class="bg-info white">
                            <tr>
                                <th>#</th>
                                <th>{{trans('student::local.student_name')}}</th>
                                <th>{{trans('student::local.status')}}</th>
                                <th>{{trans('student::local.notes')}}</th>                                    
                            </tr>
                        </thead>
                        <tbody>
                         @php
                             $n = 1;
                         @endphp
                          @foreach ($students as $student)     
                              <tr>
                                <td>{{$n}}</td>
                                <td>
                                  <input name="student_id[{{$n}}]" type="hidden" value="{{$student->id}}">
                                  @if (session('lang') == 'ar')
                                    {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}
                                  @else
                                    {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}
                                  @endif
                                </td>
                                <td>                                  
                                      <label class="pos-rel">
                                          <input type="radio" class="ace ml-1" checked name="status[{{$n}}]" value="attend"/> 
                                          <span class="lbl"></span> {{ trans('student::local.attend') }}
                                      </label>
                                      <label class="pos-rel">
                                          <input type="radio" class="ace ml-1" name="status[{{$n}}]" value="absence"/> 
                                          <span class="lbl"></span> {{ trans('student::local.absence') }}
                                      </label>    
                                      <label class="pos-rel">
                                          <input type="radio" class="ace ml-1" name="status[{{$n}}]" value="permit"/> 
                                          <span class="lbl"></span> {{ trans('student::local.permit') }}
                                      </label>                                                                
                                </td>
                                <td>
                                  <input type="text" class="form-control" name="notes[{{$n}}]" value="" placeholder="{{ trans('student::local.notes') }}">
                                </td>
                                
                              </tr>
                             @php
                                 $n++
                             @endphp
                          @endforeach
                        </tbody>
                    </table>
                  </div>
                </div>
                <div class="form-actions left">
                  <button type="submit" class="btn btn-success">
                      <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                    </button>
                  <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('absences.index')}}';">
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
