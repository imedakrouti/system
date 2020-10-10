@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('absences.index')}}">{{ trans('student::local.absences') }}</a></li>
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
            <div class="form-body">
                  <div class="row">
                      <div class="col-md-12">
                        @if (session('lang') == 'ar')
                        <h3><a href="{{route('students.show',$student->id)}}">{{$student->ar_student_name}}
                            {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}</a></h3>                            
                        @else
                        <h3><a href="{{route('students.show',$student->id)}}">{{$student->en_student_name}}
                            {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}</a></h3>                            
                        @endif

                  </div>                  
                </div>              
              </div>
            </div>
          </div>
      </div>
    </div>
</div>

@if (count($absences) != 0)
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">            
            <div class="form-body">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table" >
                                <thead class="bg-info white">
                                    <tr>                                        
                                        <th>{{trans('student::local.absence_date')}}</th>
                                        <th>{{trans('student::local.status')}}</th>
                                        <th>{{trans('student::local.notes')}}</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absences as $absence)
                                        <tr>
                                            <td>{{$absence->absence_date}}</td>
                                            <td>{{$absence->status}}</td>
                                            <td>{{$absence->notes}}</td>                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>                  
                </div>              
              </div>
            </div>
          </div>
      </div>
    </div>
</div>    
@else
<div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
  <span class="alert-icon"><i class="la la-info-circle"></i></span>               
  {{ trans('student::local.no_absences') }}
</div>        
@endif

@endsection
