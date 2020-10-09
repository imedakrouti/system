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
            <li class="breadcrumb-item"><a href="{{route('archives.index')}}">{{ trans('student::local.archive') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('archives.update',$archive->id)}}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.document_name') }}</label>
                          <div class="col-md-9">
                            <input type="text" class="form-control " value="{{old('document_name',$archive->document_name)}}" 
                            placeholder="{{ trans('student::local.document_name') }}"
                              name="document_name" required>
                              <span class="red">{{ trans('student::local.requried') }}</span>
                          </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                          <label class="col-md-3 label-control">{{ trans('student::local.student_name') }}</label>
                          <div class="col-md-9">
                            <select name="student_id" id="student_id" class="form-control select2" required>
                                <option value="">{{ trans('student::local.select') }}</option>
                                @foreach ($students as $student)
                                    <option {{old('student_id',$archive->student_id) == $student->id ? 'selected' :''}} value="{{$student->id}}">
                                    @if (session('lang') == 'ar')
                                    [{{$student->student_number}}] {{$student->ar_student_name}} {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}} {{$student->father->ar_th_name}}
                                    @else
                                    [{{$student->student_number}}] {{$student->en_student_name}} {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}} {{$student->father->en_th_name}}
                                    @endif
                                    </option>
                                @endforeach
                            </select>
                            <span class="red">{{ trans('student::local.requried') }}</span>                            
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
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('archives.index')}}';">
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
