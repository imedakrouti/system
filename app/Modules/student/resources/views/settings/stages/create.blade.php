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
            <li class="breadcrumb-item"><a href="{{route('stages.index')}}">{{ trans('student::local.stages') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('stages.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                     <div class="row">
                       <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.ar_stage_name') }}</label> <br>
                          
                            <input type="text" class="form-control " value="{{old('ar_stage_name')}}" 
                            placeholder="{{ trans('student::local.ar_stage_name') }}"
                              name="ar_stage_name" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          
                        </div>
                    </div>
                     <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.en_stage_name') }}</label> <br>
                          
                            <input type="text" class="form-control " value="{{old('en_stage_name')}}" 
                            placeholder="{{ trans('student::local.en_stage_name') }}"
                              name="en_stage_name" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          
                        </div>
                    </div>
                     <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.sort') }}</label> <br>
                          
                            <input type="number" min="0" class="form-control " value="{{old('sort')}}" 
                            placeholder="{{ trans('student::local.sort') }}"
                              name="sort" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          
                        </div>
                     </div>
                    </div>   
                    <div class="col-md-12">
                      <label class="col-lg-6 col-md-12 label-control">{{ trans('student::local.signature_statement') }}</label> <br>
                      <div class="form-group">
                        <div class="col-md-12">
                          <textarea class="form-control" name="signature" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('signature')}}</textarea>                          
                        </div>
                      </div>
                  </div>                                                                         
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('stages.index')}}';">
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
@section('script')
<script src="{{asset('cpanel/app-assets/vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('cpanel/app-assets/js/scripts/editors/editor-ckeditor.js')}}"></script>    
@endsection