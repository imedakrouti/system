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
            <li class="breadcrumb-item"><a href="{{route('parents.index')}}">{{ trans('student::local.parents') }}</a></li>
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
              <div class="col-md-12">
                  <h2 class="mb-2">
                    @if (session('lang')=='ar')
                    <a href="{{route('father.show',$father->id)}}">{{$father->ar_st_name}} {{$father->ar_nd_name}} {{$father->ar_rd_name}} {{$father->ar_th_name}}</a>
                    @else
                    <a href="{{route('father.show',$father->id)}}">{{$father->en_st_name}} {{$father->en_nd_name}} {{$father->en_rd_name}} {{$father->en_th_name}}</a>
                    @endif                   
                  </h2>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          
          <div class="table-responsive">
            <table class="table">
              <thead class="bg-info white">
                <tr>
                    <th>{{trans('student::local.report_title')}}</th>                    
                    <th>{{trans('student::local.created_by')}}</th>                                                                
                    <th>{{trans('student::local.created_at')}}</th>
                    <th>{{trans('student::local.updated_at')}}</th>                 
                </tr>
              </thead>
              <tbody>
                @foreach ($reports as $report)
                  <tr>
                    <td>
                        <a href="{{route('parent-reports.show',$report->id)}}">{{$report->report_title}}</a>
                    </td>
                    <td>
                        {{$report->admin->name}}
                    </td>
                    <td>
                        {{$report->created_at}}
                    </td>  
                    <td>
                        {{$report->updated_at}}
                    </td>                  
                    
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
@endsection
