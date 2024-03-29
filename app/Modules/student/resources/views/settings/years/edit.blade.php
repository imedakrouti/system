@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('cpanel/app-assets/vendors/css/forms/toggle/bootstrap-switch.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cpanel/app-assets/vendors/css/forms/toggle/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('cpanel/app-assets/css-rtl/plugins/forms/switch.css') }}">
    <link rel="stylesheet" href="{{ asset('cpanel/app-assets/css-rtl/core/colors/palette-switch.css') }}">
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
            <h3 class="content-header-title">{{ $title }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('dashboard.admission') }}">{{ trans('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('years.index') }}">{{ trans('student::local.academic_years') }}</a></li>
                        <li class="breadcrumb-item active">{{ $title }}
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
                        <form class="form form-horizontal" method="POST" action="{{ route('years.update', $year->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <h4 class="form-section"> {{ $title }}</h4>
                                @include('layouts.backEnd.includes._msg')
                                @if (session('error'))
                                    <h4 class="red"> {{ session('error') }}</h4>
                                @endif
                                <div class="col-lg-4 col-md-12">
                                  <div class="form-group row">                                      
                                    <label>{{ trans('student::local.academic_year_name') }}</label>
                                      <input type="text" class="form-control " value="{{ old('name', $year->name) }}"
                                          placeholder="{{ trans('student::local.academic_year_name') }}" name="name"
                                          required>
                                      <span class="red">{{ trans('student::local.requried') }}</span>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-lg-4 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('student::local.start_from') }}</label>
                                        <input type="date" class="form-control " value="{{ old('start_from', $year->start_from) }}"
                                            placeholder="{{ trans('student::local.start_from') }}" name="start_from"
                                            required>
                                        <span class="red">{{ trans('student::local.requried') }}</span>
                                        
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="form-group">
                                          <label>{{ trans('student::local.end_from') }}</label>
                                            <input type="date" class="form-control " value="{{ old('end_from', $year->end_from) }}"
                                                placeholder="{{ trans('student::local.end_from') }}" name="end_from"
                                                required>
                                            <span class="red">{{ trans('student::local.requried') }}</span>
                                        </div>
                                    </div>

                              </div>
                              
                              <div class="row">
                                  <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('student::local.default_year') }}</label>
                                          <select name="status" class="form-control">
                                              <option
                                                  {{ old('status', $year->status) == trans('student::local.not_current') || 
                                                  old('status', $year->status) == 'not_current' ? 'selected' : '' }}
                                                  value="not current">{{ trans('student::local.not_current') }}</option>
                                              <option
                                                  {{ old('status', $year->status) == trans('student::local.current') || 
                                                  old('status', $year->status) == 'current' ? 'selected' : '' }}
                                                  value="current">{{ trans('student::local.current') }}</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-lg-4 col-md-6">
                                      <div class="form-group">
                                        <label>{{ trans('student::local.year_status') }}</label>
                                          <select name="year_status" class="form-control">
                                              <option
                                                  {{ old('year_status', $year->year_status) == trans('student::local.close') ||
                                                  old('year_status', $year->year_status) == 'close' ? 'selected' : '' }}
                                                  value="close">{{ trans('student::local.no') }}</option>
                                              <option
                                                  {{ old('year_status', $year->year_status) == trans('student::local.open') ||
                                                  old('year_status', $year->year_status) == 'open' ? 'selected' : '' }}
                                                  value="open">{{ trans('student::local.yes') }}</option>
                                          </select>
                                      </div>
                                  </div>
                              </div> 
                            </div>
                            <div class="form-actions left"></div>
                            <button type="submit" class="btn btn-success">
                                <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                            </button>
                            <button type="button" class="btn btn-warning mr-1"
                                onclick="location.href='{{ route('years.index') }}';">
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
@section('script')
    <script src="{{ asset('cpanel/app-assets/vendors/js/forms/toggle/bootstrap-switch.min.js') }}"></script>
    <script src="{{ asset('cpanel/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') }}"></script>
    <script src="{{ asset('cpanel/app-assets/vendors/js/forms/toggle/switchery.min.js') }}"></script>
    <script src="{{ asset('cpanel/app-assets/js/scripts/forms/switch.js') }}"></script>

@endsection
