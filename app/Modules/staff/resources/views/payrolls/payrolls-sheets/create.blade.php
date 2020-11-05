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
            <li class="breadcrumb-item"><a href="{{route('payrolls-sheets.index')}}">{{ trans('staff::local.payrolls_sheets') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('payrolls-sheets.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.ar_sheet_name') }}</label>
                              <input type="text" class="form-control " value="{{old('ar_sheet_name')}}" 
                              placeholder="{{ trans('staff::local.ar_sheet_name') }}"
                                name="ar_sheet_name" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.en_sheet_name') }}</label>
                              <input type="text" class="form-control " value="{{old('en_sheet_name')}}" 
                              placeholder="{{ trans('staff::local.en_sheet_name') }}"
                                name="en_sheet_name" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.period') }}</label>
                              <select name="end_period" class="form-control" required>
                                  <option {{old('end_period') =='End Month' ? 'selected':'' }} value="End Month">{{ trans('staff::local.this_month') }}</option>
                                  <option {{old('end_period') =='Next Month' ? 'selected':'' }} value="Next Month">{{ trans('staff::local.next_month') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>              
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                              <label>{{ trans('staff::local.from_day') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('from_day')}}" 
                              placeholder="{{ trans('staff::local.from_day') }}"
                                name="from_day" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3">
                            <div class="form-group">
                              <label>{{ trans('staff::local.to_day') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('to_day')}}" 
                              placeholder="{{ trans('staff::local.to_day') }}"
                                name="to_day" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
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
