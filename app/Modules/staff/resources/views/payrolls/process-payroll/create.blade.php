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
            <li class="breadcrumb-item"><a href="{{route('payroll-process.index')}}">{{ trans('staff::local.process_payroll') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('payroll-process.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                      <div class="col-lg-3 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('staff::local.payroll_sheet_name') }}</label> <br>
                            <select name="payroll_sheet_id" class="form-control" required>
                                <option value="">{{ trans('staff::local.select') }}</option>
                                @foreach ($payrollSheets as $payrollSheet)
                                    <option {{old('payroll_sheet_id') == $payrollSheet->id ? 'selected' :''}} value="{{$payrollSheet->id}}">
                                          {{session('lang') == 'ar' ? $payrollSheet->ar_sheet_name : $payrollSheet->en_sheet_name}}                                  
                                    </option>
                                @endforeach
                            </select> <br>
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                          </div>
                      </div>   
                      <div class="col-lg-2 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('staff::local.payroll_from_date') }}</label>
                            <input type="date" class="form-control" name="from_date">                            
                          </div>
                      </div>                                                                          
                      <div class="col-lg-2 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('staff::local.payroll_to_date') }}</label>
                          <input type="date" class="form-control" name="to_date">                          
                        </div>
                    </div> 
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('payroll-process.index')}}';">
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
