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
            <li class="breadcrumb-item"><a href="{{route('student-reports.index')}}">{{ trans('student::local.student_reports') }}</a></li>
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
                <h4 class="form-section"> {{ $title }}</h4>
                @include('layouts.backEnd.includes._msg')
                <div class="col-md-12">
                    <div class="form-group row">                          
                        <div class="col-md-4">   
                          <h4>{{ trans('student::local.father_name') }}</h4>                       
                            <h3>                                
                                @if (session('lang') == trans('admin.ar'))
                                    <a href="{{route('students.show',$report->students->id)}}">{{$report->students->ar_student_name}} </a> <a href="{{route('father.show',$report->students->father->id)}}">{{$report->students->father->ar_st_name}} {{$report->students->father->ar_nd_name}} {{$report->students->father->ar_rd_name}} {{$report->students->father->ar_th_name}}</a>
                                @else
                                    <a href="{{route('students.show',$report->students->id)}}">{{$report->students->en_student_name}} </a> <a href="{{route('father.show',$report->students->father->id)}}">{{$report->students->father->en_st_name}} {{$report->students->father->en_nd_name}} {{$report->students->father->en_rd_name}} {{$report->students->father->en_th_name}}</a>
                                @endif                                                                    
                            </h3>                                                       
                        </div>
                        <div class="col-md-4">
                          <h4>{{ trans('student::local.mother_name') }}</h4>                       
                            @foreach ($mothers as $mother)
                                @if ($mother->id == $report->students->mother_id)
                                    <h3><a href="{{route('mother.show',$mother->id)}}">{{$mother->full_name}}</a></h3>                                    
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-4">
                          <h4>{{ trans('student::local.siblings') }}</h4>                            
                            @foreach ($mothers as $mother)
                                @foreach ($mother->students as $student)
                                    @if ($student->id <> $report->students->id)
                                        <h3>
                                            <a href="{{route('students.show',$student->id)}}">
                                            @if (session('lang') == trans('admin.ar'))
                                                {{$student->ar_student_name}} 
                                            @else
                                                {{$student->en_student_name}}
                                            @endif
                                            | <span style="font-size: 18px;">
                                                @if (session('lang') == trans('admin.ar'))
                                                    {{$student->division->ar_division_name}} | {{$student->grade->ar_grade_name}}
                                                @else
                                                    {{$student->division->en_division_name}} | {{$student->grade->en_grade_name}}
                                                @endif
                                            </span> 
                                            </a> 
                                        </h3>                                  
                                    @endif
                                @endforeach
                            @endforeach
                        </div>                        
                    </div>
                </div>   
                <a href="{{route('student-reports.edit',$report->id)}}"class="btn btn-warning"><i class="la la-edit"></i>{{ trans('student::local.editing') }}</a>                                                                            
                <a target="blank" href="{{route('student-reports.pdf',$report->id)}}" class="btn btn-info"><i class="la la-print"></i>{{ trans('student::local.print') }}</a>
                <a href="{{route('student-reports.index')}}" class="btn btn-light"><i class="la la-mail-forward"></i>{{ trans('admin.back') }}</a>   
                <hr>
                <div class="col-md-12">
                    <div class="form-group row">                          
                        <div class="col-md-12">
                            <h2 class="purple mb-1">{{$report->report_title}}</h2>
                            <textarea class="form-control f-1" cols="30" readonly rows="30">{{$report->report}}</textarea>
                            <hr>
                        </div>                                                                                                                                                                                    
                    </div>
                </div>  
                <div class="col-md-12">
                  <h6><strong><span class="red">{{ trans('student::local.created_by') }} : </span></strong>{{$report->admin->name}}</h6>
                  <h6><strong><span class="red">{{ trans('student::local.created_at') }} : </span></strong>{{$report->created_at}}</h6>
                  <h6><strong><span class="red">{{ trans('student::local.updated_at') }} : </span></strong>{{$report->updated_at}}</h6>                                                                                             
                </div>
            </div>              
          </div>
        </div>
      </div>
    </div>
</div>
@endsection