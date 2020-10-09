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
            <li class="breadcrumb-item"><a href="{{route('commissioners.index')}}">{{ trans('student::local.commissioners') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('commissioners.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.commissioner_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('commissioner_name')}}" 
                            placeholder="{{ trans('student::local.commissioner_name') }}"
                              name="commissioner_name" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.id_number_card') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('id_number')}}" 
                            placeholder="{{ trans('student::local.id_number') }}"
                              name="id_number" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.mobile_number') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="0" class="form-control " value="{{old('mobile')}}" 
                            placeholder="{{ trans('student::local.mobile') }}"
                              name="mobile" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.relation') }}</label>
                          <div class="col-md-9">                         
                              <select name="relation" class="form-control">
                                  <option {{old('relation') == 'relative' ? 'selected' : ''}} value="relative">{{ trans('student::local.relative') }}</option>
                                  <option {{old('relation') == 'driver' ? 'selected' : ''}} value="driver">{{ trans('student::local.driver') }}</option>
                              </select>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.notes') }}</label>
                          <div class="col-md-9">                         
                              <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes')}}</textarea>                              
                          </div>
                        </div>
                    </div>                     
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control" >{{ trans('student::local.attachements') }}</label>
                          <div class="col-md-9">                    
                            <input  type="file" name="file_name"/>
                          </div>
                        </div>
                    </div>                                                                          
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('commissioners.index')}}';">
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
