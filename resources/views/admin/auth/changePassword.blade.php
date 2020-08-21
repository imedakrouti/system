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
            <li class="breadcrumb-item"><a href="index.html">{{ trans('staff::admin.dashboard') }}</a>
            </li>
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
            <form class="form form-horizontal" method="POST" action="{{aurl('update/password')}}" enctype="multipart/form-data">
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
                        <label class="col-md-3 label-control" for="userinput1">{{ trans('admin.password') }}</label>
                        <div class="col-md-9">
                          <input type="password" id="userinput1" class="form-control border-primary" placeholder="{{ trans('admin.password') }}"
                            name="password" ">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 label-control" for="userinput2">{{ trans('admin.confirm_password') }}</label>
                        <div class="col-md-9">
                          <input type="password" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.confirm_password') }}"
                          name="cPassword" >
                        </div>
                      </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save_changes') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{aurl('dashboard')}}';">
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
