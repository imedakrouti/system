@extends('layouts.backEnd.cpanel')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('main.dashboard')}}">{{ trans('admin.dashboard') }}</a>
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
            <form class="form form-horizontal" method="POST" action="{{route('update.settings')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ trans('admin.update_setting_data') }}</h4>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <!-- print all errors -->
                                    {{$error}} . <br>
                            @endforeach
                        </div>
                    @endif
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 label-control" for="userinput1">{{ trans('admin.site_arabic_name') }}</label>
                        <div class="col-md-9">
                          <input type="text" id="userinput1" class="form-control border-primary" placeholder="{{ trans('admin.site_arabic_name') }}"
                            name="siteNameArabic" value="{{settingHelper()->siteNameArabic}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 label-control">{{ trans('admin.site_english_name') }}</label>
                        <div class="col-md-9">
                          <input type="text" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.site_english_name') }}"
                          name="siteNameEnglish" value="{{settingHelper()->siteNameEnglish}}">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.address') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.address') }}"
                            name="address" value="{{settingHelper()->address}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.contact') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.contact') }}"
                            name="contact" value="{{settingHelper()->contact}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.email') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.email') }}"
                            name="email" value="{{settingHelper()->email}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.siteStatus') }}</label>
                          <div class="col-md-9">
                              <select name="status" class="form-control">
                                  <option value=""></option>
                                  <option {{settingHelper()->status == 'open' ?'selected':''}} value="open">{{ trans('admin.open') }}</option>
                                  <option {{settingHelper()->status == 'close' ?'selected':''}} value="close">{{ trans('admin.close') }}</option>
                              </select>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.fb') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.fb') }}"
                            name="facebook" value="{{settingHelper()->facebook}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('admin.yt') }}</label>
                          <div class="col-md-9">
                            <input type="text" id="userinput2" class="form-control border-primary" placeholder="{{ trans('admin.yt') }}"
                            name="youtube" value="{{settingHelper()->youtube}}">
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.arabic_description') }}</label>
                          <div class="col-md-9">
                            <textarea id="userinput8" rows="6" class="form-control border-primary" name="arabicDescription"
                            placeholder="{{ trans('admin.arabic_description') }}">{{settingHelper()->arabicDescription}}</textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.english_description') }}</label>
                          <div class="col-md-9">
                            <textarea id="userinput8" rows="6" class="form-control border-primary" name="englishDescription"
                            placeholder="{{ trans('admin.english_description') }}">{{settingHelper()->englishDescription}}</textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.keywords') }}</label>
                          <div class="col-md-9">
                            <textarea id="userinput8" rows="6" class="form-control border-primary" name="keywords"
                            placeholder="{{ trans('admin.keywords') }}">{{settingHelper()->keywords}}</textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.message_maintenance') }}</label>
                          <div class="col-md-9">
                            <textarea id="userinput8" rows="6" class="form-control border-primary" name="messageMaintenance"
                            placeholder="{{ trans('admin.message_maintenance') }}">{{settingHelper()->messageMaintenance}}</textarea>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.icon') }}</label>
                          <div class="col-md-9">
                            <input multiple="" type="file" id="id-input-file-31" name="icon"/>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('admin.logo') }}</label>
                          <div class="col-md-9">
                            <input multiple="" type="file" id="id-input-file-3" name="logo"/>
                          </div>
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
