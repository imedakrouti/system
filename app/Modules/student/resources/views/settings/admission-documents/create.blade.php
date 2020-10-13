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
            <li class="breadcrumb-item"><a href="{{route('admission-documents.index')}}">{{ trans('student::local.admission_documents') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('admission-documents.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.ar_document_name') }}</label>
                          <input type="text" class="form-control " value="{{old('ar_document_name')}}" 
                          placeholder="{{ trans('student::local.ar_document_name') }}"
                            name="ar_document_name" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                          <div class="col-md-9">
                          </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.en_document_name') }}</label>
                          <input type="text" class="form-control " value="{{old('en_document_name')}}" 
                          placeholder="{{ trans('student::local.en_document_name') }}"
                            name="en_document_name" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.registration_type') }}</label>                         
                          <select name="registration_type[]" class="select2 form-control" multiple="multiple" required>
                              <option value="new">{{ trans('student::local.new') }}</option>
                              <option value="transfer">{{ trans('student::local.transfer') }}</option>
                              <option value="returning">{{ trans('student::local.returning') }}</option>
                              <option value="arrival">{{ trans('student::local.arrival') }}</option>
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group">
                          <label>{{ trans('student::local.notes') }}</label>
                          <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes')}}</textarea>                          
                        </div>
                    </div>  
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('student::local.sort') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('sort')}}" 
                          placeholder="{{ trans('student::local.sort') }}"
                            name="sort" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>                  
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('admission-documents.index')}}';">
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
