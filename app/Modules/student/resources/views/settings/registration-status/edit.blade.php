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
            <li class="breadcrumb-item"><a href="{{route('registration-status.index')}}">{{ trans('student::local.registration_status') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('registration-status.update',$registrationStatus->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.ar_name_status') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('ar_name_status',$registrationStatus->ar_name_status)}}" placeholder="{{ trans('student::local.ar_name_status') }}"
                              name="ar_name_status">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.en_name_status') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('en_name_status',$registrationStatus->en_name_status)}}" placeholder="{{ trans('student::local.en_name_status') }}"
                              name="en_name_status">
                          </div>
                        </div>
                    </div>                    
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.description') }}</label>
                          <div class="col-md-9">                         
                              <textarea name="description" class="form-control" cols="30" rows="5">{{old('description',$registrationStatus->description)}}</textarea>
                          </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.shown') }}</label>                         
                          <div class="col-md-9">
                            <select name="shown" class="form-control">
                                <option {{old('shown',$registrationStatus->shown) == trans('student::local.show_regg')?'selected':''}} value="show">{{ trans('student::local.show_regg') }}</option>
                                <option {{old('shown',$registrationStatus->shown) == trans('student::local.hidden_reg')?'selected':''}} value="hidden">{{ trans('student::local.hidden_reg') }}</option>                                
                            </select>
                          </div>
                        </div>
                    </div>                     
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.sort') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="0" class="form-control " value="{{old('sort',$registrationStatus->sort)}}" placeholder="{{ trans('student::local.sort') }}"
                              name="sort">
                          </div>
                        </div>
                    </div> 
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('registration-status.index')}}';">
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
