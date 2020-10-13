@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-lg-4 col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('guardians.index')}}">{{ trans('student::local.guardians') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('guardians.update',$guardian->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_full_name') }}</label>
                              <input type="text" class="form-control " value="{{old('guardian_full_name',$guardian->guardian_full_name)}}" placeholder="{{ trans('student::local.guardian_full_name') }}"
                                name="guardian_full_name" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>                              
                    </div> 
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_id_type') }}</label>
                              <select name="guardian_id_type" class="form-control" required>
                                  <option value="">{{ trans('student::local.select') }}</option>
                                  <option {{old('guardian_id_type',$guardian->guardian_id_type) == trans('student::local.national_id') ?'selected':''}} value="national_id">{{ trans('student::local.national_id') }}</option>
                                  <option {{old('guardian_id_type',$guardian->guardian_id_type) == trans('student::local.passport') ?'selected':''}} value="passport">{{ trans('student::local.passport') }}</option>                                
                              </select>
                              <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_id_number') }}</label>
                              <input type="text" class="form-control " value="{{old('guardian_id_number',$guardian->guardian_id_number)}}" placeholder="{{ trans('student::local.guardian_id_number') }}"
                                name="guardian_id_number" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>                        
                    </div>  
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_mobile1') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('guardian_mobile1',$guardian->guardian_mobile1)}}" placeholder="{{ trans('student::local.guardian_mobile1') }}"
                                name="guardian_mobile1" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_mobile2') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('guardian_mobile2',$guardian->guardian_mobile2)}}" placeholder="{{ trans('student::local.guardian_mobile2') }}"
                                name="guardian_mobile2">                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_email') }}</label>
                              <input type="email" class="form-control " value="{{old('guardian_email',$guardian->guardian_email)}}" placeholder="{{ trans('student::local.guardian_email') }}"
                                name="guardian_email">                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_job') }}</label>
                              <input type="text" class="form-control " value="{{old('guardian_job',$guardian->guardian_job)}}" placeholder="{{ trans('student::local.guardian_job') }}"
                                name="guardian_job">                              
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_block_no') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('guardian_block_no',$guardian->guardian_block_no)}}" placeholder="{{ trans('student::local.guardian_block_no') }}"
                                name="guardian_block_no" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_street_name') }}</label>
                              <input type="text" class="form-control " value="{{old('guardian_street_name',$guardian->guardian_street_name)}}" placeholder="{{ trans('student::local.guardian_street_name') }}"
                                name="guardian_street_name" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_state') }}</label>
                              <input type="text" class="form-control " value="{{old('guardian_state',$guardian->guardian_state)}}" placeholder="{{ trans('student::local.guardian_state') }}"
                                name="guardian_state" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('student::local.guardian_government') }}</label>
                              <input type="text" class="form-control " value="{{old('guardian_government',$guardian->guardian_government)}}" placeholder="{{ trans('student::local.guardian_government') }}"
                                name="guardian_government" required>
                                <span class="red">{{ trans('student::local.requried') }}</span>                              
                            </div>
                        </div>
                    </div>              
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('guardians.index')}}';">
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
