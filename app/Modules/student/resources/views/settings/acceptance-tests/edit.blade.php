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
            <li class="breadcrumb-item"><a href="{{route('acceptance-tests.index')}}">{{ trans('student::local.acceptance_tests') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('acceptance-tests.update',$acceptanceTest->id)}}">
                @csrf
                @method('PUT')
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                          <label>{{ trans('student::local.ar_test_name') }}</label>
                          <input type="text" class="form-control " value="{{old('ar_test_name',$acceptanceTest->ar_test_name)}}" placeholder="{{ trans('student::local.ar_test_name') }}"
                            name="ar_test_name" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                          <label>{{ trans('student::local.en_test_name') }}</label>
                          <input type="text" class="form-control " value="{{old('en_test_name',$acceptanceTest->en_test_name)}}" placeholder="{{ trans('student::local.en_test_name') }}"
                            name="en_test_name" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                          <label>{{ trans('student::local.grade') }}</label>
                          <select name="grade_id" class="form-control" required>
                              @foreach ($grades as $grade)
                                  <option {{old('grade_id',$grade->id) == $grade->id ? 'selected' : ''}} value="{{$grade->id}}">
                                      {{session('lang') == 'ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>    
                    <div class="col-lg-4 col-md-8">
                        <div class="form-group">
                          <label>{{ trans('student::local.sort') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('sort',$acceptanceTest->sort)}}" placeholder="{{ trans('student::local.sort') }}"
                            name="sort" required>
                            <span class="red">{{ trans('student::local.requried') }}</span>                          
                        </div>
                    </div>                        
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('acceptance-tests.index')}}';">
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
