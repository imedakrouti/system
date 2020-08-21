@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('offers.index')}}">{{ trans('admin.special_offers') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('offers.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.offer_title') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" value="{{old('title')}}" placeholder="{{ trans('admin.title') }}"
                              name="title" ">
                          </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.start_display') }}</label>
                          <div class="col-md-9">
                              <input type="datetime-local"  class="form-control" name="start_display" value="{{old('start_display')}}">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.end_display') }}</label>
                          <div class="col-md-9">
                              <input type="datetime-local" class="form-control" name="end_display" value="{{old('end_display')}}">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.status_display') }}</label>
                          <div class="col-md-9">
                            <select name="status_display" class="form-control">
                                <option>{{ trans('admin.select') }}</option>
                                <option {{ (old('status_display') == 'yes')?'selected':''}} value="yes">{{ trans('admin.yes') }}</option>
                                <option {{ (old('status_display') == 'no')?'selected':''}} value="no">{{ trans('admin.no') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.start_offer') }}</label>
                          <div class="col-md-9">
                            <select name="start_offer" class="form-control">
                                <option>{{ trans('admin.select') }}</option>
                                <option {{ (old('start_offer') == 'active')?'selected':''}} value="active">{{ trans('admin.yes') }}</option>
                                <option {{ (old('start_offer') == '')?'selected':''}} value="">{{ trans('admin.no') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.link') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('link')}}" placeholder="{{ trans('admin.link') }}"
                              name="link" ">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.image_offer_name') }}</label>
                          <div class="col-md-9">
                            <input  type="file" name="image_offer_name"/>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('offers.index')}}';">
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
