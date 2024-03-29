@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('departments.index')}}">{{ trans('staff::local.departments') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('departments.store')}}">
                @csrf
                <div class="form-body">
                    <h4 class="form-section"> {{ $title }}</h4>
                    @include('layouts.backEnd.includes._msg')
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.sector_id') }}</label>
                          <select name="sector_id[]" class="form-control select2" multiple required>
                                <option value="">{{ trans('staff::local.select') }}</option>
                                @foreach ($sectors as $sector)
                                    <option {{old('sector_id') == $sector->id ? 'selected' : ''}} value="{{$sector->id}}">
                                    {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}
                                    </option>
                                @endforeach
                          </select>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.ar_department') }}</label>
                          <input type="text" class="form-control " value="{{old('ar_department')}}" 
                          placeholder="{{ trans('staff::local.ar_department') }}"
                            name="ar_department" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>                    
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.en_department') }}</label>
                          <input type="text" class="form-control " value="{{old('en_department')}}" 
                          placeholder="{{ trans('staff::local.en_department') }}"
                            name="en_department" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.leave_allocate') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('leave_allocate')}}" 
                          placeholder="{{ trans('staff::local.leave_allocate') }}"
                            name="leave_allocate" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>  
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.sort') }}</label>
                          <input type="number" min="0" class="form-control " value="{{old('sort')}}" 
                          placeholder="{{ trans('staff::local.sort') }}"
                            name="sort" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                          
                        </div>
                    </div>                                                           
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('departments.index')}}';">
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
