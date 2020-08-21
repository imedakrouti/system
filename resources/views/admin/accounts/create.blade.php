@extends('layouts.cpanel')
@section('sidebar')
    @include('layouts.includes.sidebars._main')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('accounts.index')}}">{{ trans('admin.users_accounts') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('accounts.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <!-- print all errors -->
                                    {{$error}} . <br>
                            @endforeach
                        </div>
                    @endif

                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" for="userinput1">{{ trans('admin.account_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput1" class="form-control border-primary" value="{{old('name')}}" placeholder="{{ trans('admin.account_name') }}"
                              name="name" ">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.username') }}</label>
                          <div class="col-md-9">
                            <input type="text"  class="form-control border-primary" value="{{old('username')}}" placeholder="{{ trans('admin.username') }}"
                            name="username" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.email') }}</label>
                          <div class="col-md-9">
                            <input type="email"  class="form-control border-primary" value="{{old('email')}}" placeholder="{{ trans('admin.email') }}"
                            name="email" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.prefer_lang') }}</label>
                          <div class="col-md-9">
                            <select name="lang" class="form-control">
                                <option>{{ trans('admin.select') }}</option>
                                <option {{ (old('lang') == 'en')?'selected':''}} value="en">{{ trans('admin.en') }}</option>
                                <option {{ (old('lang') == 'ar')?'selected':''}} value="ar">{{ trans('admin.ar') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-md-3 label-control" >{{ trans('admin.account_status') }}</label>
                            <div class="col-md-9">
                              <select name="status" class="form-control">
                                  <option value="">{{ trans('admin.select') }}</option>
                                  <option {{old('status') == 'enable' ?'selected':''}} value="enable">{{ trans('admin.active') }}</option>
                                  <option {{old('status') == 'disable'?'selected':''}} value="disable">{{ trans('admin.inactive') }}</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.password') }}</label>
                          <div class="col-md-9">
                            <input type="password"  class="form-control border-primary" placeholder="{{ trans('admin.password') }}"
                            name="password" >
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.confirm_password') }}</label>
                          <div class="col-md-9">
                            <input type="password"  class="form-control border-primary" placeholder="{{ trans('admin.confirm_password') }}"
                            name="cPassword" >
                          </div>
                        </div>
                      </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('accounts.index')}}';">
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
