@extends('layouts.cpanel')
@section('sidebar')
    @include('layouts.includes.sidebars._staff')
@endsection
@section('content')
  <div class="content-body">
    <!-- Basic Tables start -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3>{{ trans('staff::admin.settings') }}</h3>
          </div>
          <div class="card-content collapse show">
            <div class="card-body">
                <div class="simple-line-icons overflow-hidden row">
                  <div class="col-md-4 col-sm-6 col-12 ">
                    <h4><a href="{{route('sector.index')}}" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.sectors') }} </a></h4>
                    <h4><a href="{{route('department.index')}}" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.departments') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.sections') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.positions') }} </a></h4>
                  </div>
                  <div class="col-md-4 col-sm-6 col-12 ">
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.leaves_types') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.require_documents') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.skills') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.timetable') }} </a></h4>
                  </div>
                  <div class="col-md-4 col-sm-6 col-12 ">
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.holidays') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.fingerprint_device') }} </a></h4>
                    <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.create_reports') }} </a></h4>

                  </div>
                </div>
            </div>
          </div>
        </div>
        <div class="card">
            <div class="card-header">
              <h3>{{ trans('staff::admin.payroll_settings') }}</h3>
            </div>
            <div class="card-content collapse show">
              <div class="card-body">
                  <div class="simple-line-icons overflow-hidden row">
                    <div class="col-md-4 col-sm-6 col-12 ">
                      <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.salary_component_parameter') }} </a></h4>
                      <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.salary_component') }} </a></h4>
                      <h4><a href="#" class="fonticon-classname"><i class="la la-hand-o-left"></i> {{ trans('staff::admin.payroll_sheets') }} </a></h4>
                    </div>
                  </div>
              </div>
            </div>
          </div>
      </div>
    </div>
    <!-- Responsive tables end -->
  </div>
@endsection
