@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('payrolls-sheets.index')}}">{{ trans('staff::local.temporary_components') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('payrolls-sheets.add-employees-page',$payroll_sheet_id)}}">{{ $sheet_name }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('payrolls-sheets.store-employees')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <input type="hidden" name="payroll_sheet_id" value="{{$payroll_sheet_id}}">

                    <div class="col-lg-3 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.employee_name') }}</label> <br>
                          <select name="employee_id[]" id="employee_id" class="form-control select2" required multiple>
                              <option value="">{{ trans('staff::local.select') }}</option>
                              @foreach ($employees as $employee)
                                  <option {{old('employee_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                                  @if (session('lang') == 'ar')
                                  [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                  @else
                                  [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$staff->en_th_name}}
                                  @endif
                                  </option>
                              @endforeach
                          </select> <br>
                          <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                        </div>
                    </div>                       
                                                  
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('payrolls-sheets.index')}}';">
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
