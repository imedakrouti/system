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
            <li class="breadcrumb-item"><a href="{{route('nationalities.index')}}">{{ trans('student::local.nationalities') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('nationalities.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.ar_name_nat_male') }}</label>
                          <input type="text" class="form-control " value="{{old('ar_name_nat_male')}}" placeholder="{{ trans('student::local.ar_name_nat_male') }}"
                            name="ar_name_nat_male" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="form-group">
                        <label>{{ trans('student::local.ar_name_nat_female') }}</label>
                        <input type="text" class="form-control " value="{{old('ar_name_nat_female')}}" placeholder="{{ trans('student::local.ar_name_nat_female') }}"
                          name="ar_name_nat_female" required>
                          <span class="red">{{ trans('student::local.requried') }}</span>                        
                      </div>
                   </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.en_name_nationality') }}</label>
                          <input type="text" class="form-control " value="{{old('en_name_nationality')}}" placeholder="{{ trans('student::local.en_name_nationality') }}"
                            name="en_name_nationality" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>                                      
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.sort') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('sort')}}" placeholder="{{ trans('student::local.sort') }}"
                            name="sort" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div> 
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('nationalities.index')}}';">
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
