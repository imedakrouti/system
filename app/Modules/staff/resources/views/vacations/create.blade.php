@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-lg-6 col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('vacations.index')}}">{{ trans('staff::local.vacations') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('vacations.store')}}"  enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group row">
                          <label>{{ trans('staff::local.employee_name') }}</label> <br>
                          <select name="employee_id[]" id="employee_id" class="form-control select2" required multiple>
                              <option value="">{{ trans('staff::local.select') }}</option>
                              @foreach ($employees as $employee)
                                  <option {{old('staff_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                                  @if (session('lang') == 'ar')
                                  [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                  @else
                                  [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$head->en_th_name}}
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
                              <label>{{ trans('staff::local.date_vacation') }}</label>
                              <input type="date" class="form-control " value="{{old('date_vacation')}}"                           
                                name="date_vacation" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.vacation_type') }}</label>
                              <select name="vacation_type" class="form-control" id="vacation_type" required>                            
                                    <option value="">{{ trans('staff::local.select') }}</option>
                                    <option value="Start work">{{ trans('staff::local.start_work') }}</option>
                                    <option value="End work">{{ trans('staff::local.end_work') }}</option>
                                    <option value="Sick leave">{{ trans('staff::local.sick_leave') }}</option>
                                    <option value="Regular vacation">{{ trans('staff::local.regular_vacation') }}</option>
                                    <option value="Vacation without pay">{{ trans('staff::local.vacation_without_pay') }}</option>
                                    <option value="Work errand">{{ trans('staff::local.work_errand') }}</option>
                                    <option value="Training">{{ trans('staff::local.training') }}</option>
                                    <option value="Casual vacation">{{ trans('staff::local.casual_vacation') }}</option>                                    
                                </select>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.vacation_from_date') }}</label>
                              <input type="date" class="form-control " value="{{old('from_date')}}"                           
                                name="from_date" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('staff::local.vacation_to_date') }}</label>
                              <input type="date" class="form-control " value="{{old('to_date')}}"                           
                                name="to_date" required>
                                <span class="red">{{ trans('staff::local.required') }}</span>                          
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                          <label >{{ trans('staff::local.file_name') }}</label>
                          <input  type="file" class="form-control" name="file_name">
                          
                        </div>
                    </div>   
                    <div class="col-lg-6 col-md-12">
                      <div class="form-group row">
                        <label >{{ trans('staff::local.notes') }}</label>
                        <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes')}}</textarea>                        
                      </div>
                    </div>                                                                      
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('vacations.index')}}';">
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
