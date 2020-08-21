@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('countries.index')}}">{{ trans('admin.countries') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('countries.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.ar_country_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('ar_country_name')}}" placeholder="{{ trans('admin.ar_country_name') }}"
                              name="ar_country_name" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.en_country_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('en_country_name')}}" placeholder="{{ trans('admin.en_country_name') }}"
                              name="en_country_name" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.global_key') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('global_key')}}" placeholder="{{ trans('admin.global_key') }}"
                              name="global_key" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.currency') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('currency')}}" placeholder="{{ trans('admin.currency') }}"
                              name="currency" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.code') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('code')}}" placeholder="{{ trans('admin.code') }}"
                              name="code" ">
                          </div>
                        </div>
                    </div>

                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('countries.index')}}';">
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
