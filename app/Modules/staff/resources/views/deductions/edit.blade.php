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
            <li class="breadcrumb-item"><a href="{{route('deductions.index')}}">{{ trans('staff::local.deductions') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('deductions.update',$deduction->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.employee_name') }}</label> <br>
                          <select name="employee_id[]" id="employee_id" class="form-control select2" required multiple>
                              <option value="">{{ trans('staff::local.select') }}</option>
                              @foreach ($employees as $employee)
                                  <option {{old('employee_id',$deduction->employee_id) == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
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
                    
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.date_deduction') }}</label>
                              <input type="date" class="form-control " value="{{old('date_deduction',$deduction->date_deduction)}}"                           
                                name="date_deduction" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.deduction_amount') }}</label>
                              <input type="number" min="0" step="0.25" class="form-control " value="{{old('amount',$deduction->days)}}"                           
                                name="amount" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.reason') }}</label>
                          <textarea name="reason" class="form-control" cols="30" rows="5">{{old('reason',$deduction->reason)}}</textarea>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>                                                            
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('deductions.index')}}';">
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
