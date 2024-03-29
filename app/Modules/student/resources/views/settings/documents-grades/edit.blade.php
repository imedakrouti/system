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
            <li class="breadcrumb-item"><a href="{{route('documents-grades.index')}}">{{ trans('student::local.documents_grades') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('documents-grades.update',$documentGrade->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-3 col-md-8">
                        <div class="form-group">
                          <label>{{ trans('student::local.grade') }}</label> <br>
                          <select name="grade_id" class="form-control" required>
                              @foreach ($grades as $grade)
                                  <option {{old('grade_id',$documentGrade->grade_id) == $grade->id ? 'selected' : ''}} value="{{$grade->id}}">
                                      {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>   
                    <div class="col-lg-3 col-md-8">
                        <div class="form-group">
                          <label>{{ trans('student::local.document_name') }}</label> <br>
                          <select name="admission_document_id" class="form-control" required>
                              @foreach ($documents as $document)
                                  <option {{old('admission_document_id',$documentGrade->admission_document_id) == $document->id ? 'selected' : ''}} value="{{$document->id}}">
                                      {{session('lang') =='ar' ?$document->ar_document_name:$document->en_document_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('documents-grades.index')}}';">
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
