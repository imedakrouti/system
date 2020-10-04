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
            <li class="breadcrumb-item"><a href="{{route('commissioners.index')}}">{{ trans('student::local.commissioners') }}</a></li>
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
                        @if (count($commissioners) != 0)
                          <a href="{{route('student-report.print',$student->id)}}" class="btn btn-primary mt-1">{{ trans('student::local.print_commissioner_report') }}</a>                            
                        @endif
                  </div>                  
                </div>              
              </div>
            </div>
          </div>
      </div>
    </div>
</div>

@if (count($commissioners) != 0)
    @foreach ($commissioners as $commissioner)
      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body">            
                  <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="red"><a href="{{route('commissioners.show',$commissioner->id)}}">{{$commissioner->commissioner_name}}</a></h3>
                                <h6><strong>{{ trans('student::local.mobile_number') }} : </strong>{{$commissioner->mobile}}</h6>
                                <h6><strong>{{ trans('student::local.id_number_card') }} : </strong>{{$commissioner->id_number}}</h6>
                                <h6><strong>{{ trans('student::local.relation') }} : </strong>{{$commissioner->relation}}</h6>
                                <h6><strong>{{ trans('student::local.created_by') }} : </strong>{{$commissioner->admin->name}}</h6>
                                <h6><strong>{{ trans('student::local.created_at') }} : </strong>{{$commissioner->created_at}}</h6>
                                <h6><strong>{{ trans('student::local.updated_at') }} : </strong>{{$commissioner->updated_at}}
                                </div></h6>
                            <div class="col-md-6">
                                <h6><strong>{{ trans('student::local.notes') }}</strong></h6>
                                <p>{{$commissioner->commissioner_name}}</p>
                                @if (!empty($commissioner->file_name))
                                    <a target="blank" class="btn btn-success btn-sm" href="{{asset('storage/attachments/'.$commissioner->file_name)}}">
                                      <i class="la la-download"></i> {{ trans('student::local.attachements') }}
                                    </a>
                                @endif
                            </div>
                        </div>                  
                      </div>              
                    </div>
                  </div>
                </div>
          </div>
      </div>
    @endforeach
@else
<div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
  <span class="alert-icon"><i class="la la-info-circle"></i></span>               
  {{ trans('student::local.no_commissioners') }}
</div>        
@endif

@endsection
