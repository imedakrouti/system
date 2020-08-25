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
            <form class="form form-horizontal" method="POST" action="{{route('admission-documents.update',$admissionDoc->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.ar_document_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('ar_document_name',$admissionDoc->ar_document_name)}}" placeholder="{{ trans('student::local.ar_document_name') }}"
                              name="ar_document_name">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.en_document_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('en_document_name',$admissionDoc->en_document_name)}}" placeholder="{{ trans('student::local.en_document_name') }}"
                              name="en_document_name">
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.registration_type') }}</label>
                          <div class="col-md-9">
                            <select name="registration_type[]" class="form-control select2" multiple>
                                <option {{ preg_match('/\bnew\b/', $admissionDoc->registration_type) != 0 ?'selected':'' }}  value="new">{{ trans('student::local.new') }}</option>
                                <option {{ preg_match('/\btransfer\b/', $admissionDoc->registration_type) != 0 ?'selected':'' }}  value="transfer">{{ trans('student::local.transfer') }}</option>
                                <option {{ preg_match('/\breturning\b/', $admissionDoc->registration_type) != 0 ?'selected':'' }}  value="returning">{{ trans('student::local.returning') }}</option>
                                <option {{ preg_match('/\barrival\b/', $admissionDoc->registration_type) != 0 ?'selected':'' }}  value="arrival">{{ trans('student::local.arrival') }}</option>
                            </select>
                          </div>
                        </div>
                    </div> 
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.notes') }}</label>
                          <div class="col-md-9">                         
                              <textarea name="notes" class="form-control" cols="30" rows="5">{{old('notes',$admissionDoc->notes)}}</textarea>
                          </div>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.sort') }}</label>
                          <div class="col-md-9">
                            <input type="number" min="0" class="form-control " value="{{old('sort',$admissionDoc->sort)}}" placeholder="{{ trans('student::local.sort') }}"
                              name="sort">
                          </div>
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
