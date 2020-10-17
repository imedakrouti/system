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
            <li class="breadcrumb-item"><a href="{{route('leave-types.index')}}">{{ trans('staff::local.leave_types') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('leave-types.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.ar_leave') }}</label>
                              <input type="text" class="form-control " value="{{old('ar_leave')}}" 
                              placeholder="{{ trans('staff::local.ar_leave') }}"
                                name="ar_leave" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.en_leave') }}</label>
                              <input type="text" class="form-control " value="{{old('en_leave')}}" 
                              placeholder="{{ trans('staff::local.en_leave') }}"
                                name="en_leave" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.have_balance') }}</label>
                              <select name="have_balance" class="form-control" required>
                                  <option {{old('have_balance') =='yes' ? 'selected':'' }} value="yes">{{ trans('staff::local.yes_balance') }}</option>
                                  <option {{old('have_balance') =='no' ? 'selected':'' }} value="no">{{ trans('staff::local.no_balance') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.activation') }}</label>
                              <select name="activation" class="form-control" required>
                                  <option {{old('activation') =='active' ? 'selected':'' }} value="active">{{ trans('staff::local.active') }}</option>
                                  <option {{old('activation') =='inactive' ? 'selected':'' }} value="inactive">{{ trans('staff::local.inactive') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>                        
                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.deduction') }}</label>
                              <select name="deduction" class="form-control" required>
                                  <option {{old('deduction') =='yes' ? 'selected':'' }} value="yes">{{ trans('staff::local.yes') }}</option>
                                  <option {{old('deduction') =='no' ? 'selected':'' }} value="no">{{ trans('staff::local.no') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>                         
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.deduction_allocated') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('deduction_allocated')}}" 
                              placeholder="{{ trans('staff::local.deduction_allocated') }}"
                                name="deduction_allocated" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>                                       

                    </div>

                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.target') }}</label>
                              <select name="target" class="form-control" required>
                                  <option {{old('target') =='late' ? 'selected':'' }} value="late">{{ trans('staff::local.late') }}</option>
                                  <option {{old('target') =='early' ? 'selected':'' }} value="early">{{ trans('staff::local.early') }}</option>
                              </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div> 
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.sort') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('sort')}}" 
                              placeholder="{{ trans('staff::local.sort') }}"
                                name="sort" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div> 
                    </div>   
                                     
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.period') }}</label>
                              <select name="period" class="form-control" required>
                                  <option {{old('period') =='this month' ? 'selected':'' }} value="this month">{{ trans('staff::local.this_month') }}</option>
                                  <option {{old('period') =='next month' ? 'selected':'' }} value="next month">{{ trans('staff::local.next_month') }}</option>
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
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('leave-types.index')}}';">
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
