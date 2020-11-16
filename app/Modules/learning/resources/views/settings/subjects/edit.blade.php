@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('subjects.index')}}">{{ trans('learning::local.subjects') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('subjects.update',$subject->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')   
                
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.ar_name_subject') }}</label>
                              <input type="text" class="form-control " value="{{old('ar_name',$subject->ar_name)}}" 
                              placeholder="{{ trans('learning::local.ar_name') }}"
                                name="ar_name" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.en_name_subject') }}</label>
                              <input type="text" class="form-control " value="{{old('en_name',$subject->en_name)}}" 
                              placeholder="{{ trans('learning::local.en_name_subject') }}"
                                name="en_name" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>
                    </div>                    
                    <div class="row"> 
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group">
                              <label>{{ trans('learning::local.sort') }}</label>
                              <input type="number" min="0" class="form-control " value="{{old('sort',$subject->sort)}}" 
                              placeholder="{{ trans('learning::local.sort') }}"
                                name="sort" required>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div> 
                    </div> 
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('subjects.index')}}';">
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
