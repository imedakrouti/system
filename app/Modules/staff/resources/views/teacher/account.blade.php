@extends('layouts.backEnd.dashboards.teacher')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <form class="form form-horizontal" method="POST" action="{{route('update.profile')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section">{{ trans('admin.profile') }}</h4>
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
                          <label class="col-md-3 label-control" >{{ trans('admin.imageProfile') }}</label>
                          <div class="col-md-9">
                            @isset(authInfo()->image_profile)
                                <img class="editable img-responsive" alt="Alex's Avatar" id="avatar2"                             
                                src="{{ asset('images/imagesProfile/'.authInfo()->image_profile) }}" />
                            @endisset
                            @empty(authInfo()->image_profile)                          
                                <img class="editable img-responsive" alt="Alex's Avatar" id="avatar2"                             
                                src="{{ asset('images/website/male.png') }}" />
                            @endempty
                                                       
                            <input  type="file" name="image_profile"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.account_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control" value="{{authInfo()->name}}" placeholder="{{ trans('admin.account_name') }}"
                              name="name" readonly>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.username') }}</label>
                          <div class="col-md-9">
                            <input type="text"  class="form-control" value="{{authInfo()->username}}" placeholder="{{ trans('admin.username') }}"
                            name="username" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.email') }}</label>
                          <div class="col-md-9">
                            <input type="email"  class="form-control" value="{{authInfo()->email}}" placeholder="{{ trans('admin.email') }}"
                            name="email" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.prefer_lang') }}</label>
                          <div class="col-md-9">
                            <select name="lang" class="form-control">
                                <option>{{ trans('admin.select') }}</option>
                                <option {{ (authInfo()->lang == trans('admin.en'))?'selected':''}} value="en">{{ trans('admin.en') }}</option>
                                <option {{ (authInfo()->lang == trans('admin.ar'))?'selected':''}} value="ar">{{ trans('admin.ar') }}</option>
                            </select>
                          </div>
                        </div>
                      </div>                      

                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save_changes') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('main.dashboard')}}';">
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
