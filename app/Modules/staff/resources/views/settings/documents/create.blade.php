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
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('documents.index')}}">{{ trans('staff::local.required_documents') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('documents.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.ar_document') }}</label>
                          <input type="text" class="form-control " value="{{old('ar_document')}}" 
                          placeholder="{{ trans('staff::local.ar_document') }}"
                            name="ar_document" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.en_document') }}</label>
                          <input type="text" class="form-control " value="{{old('en_document')}}" 
                          placeholder="{{ trans('staff::local.en_document') }}"
                            name="en_document" required>
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
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('documents.index')}}';">
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
