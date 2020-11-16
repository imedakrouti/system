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
            <li class="breadcrumb-item"><a href="{{route('division-subjects.index')}}">{{ trans('learning::local.division_subjects') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('division-subjects.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')

                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                          <label>{{ trans('learning::local.division') }}</label>
                          <select name="division_id[]" class="form-control select2" multiple required>
                              @foreach ($divisions as $division)
                                  <option {{old('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                                      {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                  
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                          <label>{{ trans('learning::local.subject') }}</label>
                          <select name="subject_id[]" class="form-control select2" multiple required>
                              @foreach ($subjects as $subject)
                                  <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                      {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('learning::local.required') }}</span>                              
                        </div>
                    </div>                                                 
                                                                             
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('division-subjects.index')}}';">
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
