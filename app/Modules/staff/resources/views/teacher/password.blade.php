@extends('layouts.backEnd.teacher')
@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <form class="form form-horizontal" method="POST" action="{{aurl('update/password')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section">{{ trans('admin.change_password') }}</h4>
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
                          <input type="password" class="form-control" required placeholder="{{ trans('admin.password') }}"
                            name="password" ">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-md-3 label-control" for="userinput2">{{ trans('admin.confirm_password') }}</label>
                        <div class="col-md-9">
                          <input type="password" class="form-control" required placeholder="{{ trans('admin.confirm_password') }}"
                          name="cPassword" >
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
