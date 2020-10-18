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
            <li class="breadcrumb-item"><a href="{{route('external-codes.index')}}">{{ trans('staff::local.external-codes') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('external-codes.update',$externalCode->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                      <span class="alert-icon"><i class="la la-info-circle"></i></span>               
                       <h4 class="white">{{ trans('staff::local.external_code_tip') }}</h4>
                    </div>
                    <div class="col-lg-4 col-md-6">
                      <div class="form-group">
                        <label>{{ trans('staff::local.description') }}</label>
                        <input type="text" class="form-control " value="{{old('description',$externalCode->description`)}}" 
                        placeholder="{{ trans('staff::local.description') }}"
                          name="description" required>
                          <span class="red">{{ trans('staff::local.required') }}</span>                          
                      </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.pattern') }}</label>
                          <input type="text" class="form-control " value="{{old('pattern',$externalCode->pattern)}}" 
                          placeholder="{{ trans('staff::local.pattern') }}"
                            name="pattern" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12">
                        <div class="form-group">
                            <label>{{ trans('staff::local.replacement') }}</label>              
                            <textarea name="replacement"class="form-control" required cols="30" rows="5">{{old('replacement',$externalCode->replacement)}}</textarea>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('external-codes.index')}}';">
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
