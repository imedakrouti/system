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
            <li class="breadcrumb-item"><a href="{{route('father-notes.index',$father->id)}}">{{ trans('student::local.notes') }}</a></li>
            <li class="breadcrumb-item">
                <a href="{{route('parents.index')}}">
                    @if (session('lang')=='ar')
                    <a href="{{route('father.show',$father->id)}}">{{$father->ar_st_name}} {{$father->ar_nd_name}} {{$father->ar_rd_name}} {{$father->ar_th_name}}</a>
                    @else
                    <a href="{{route('father.show',$father->id)}}">{{$father->en_st_name}} {{$father->en_nd_name}} {{$father->en_rd_name}} {{$father->en_th_name}}</a>
                    @endif               
                </a>
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
            <form class="form form-horizontal" method="POST" action="{{route('father-notes.update',$note->id)}}">
                @csrf                
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-md-1 label-control">{{ trans('student::local.notes') }}</label>
                        <div class="col-md-11">    
                            <input type="hidden" name="father_id" value="{{$father->id}}">                     
                            <textarea name="notes" class="form-control" required cols="30" rows="5">{{old('notes',$note->notes)}}</textarea>
                            <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                      </div>
                  </div>    
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('father-notes.index',$father->id)}}';">
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
