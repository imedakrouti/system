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
            <li class="breadcrumb-item"><a href="{{route('parents.index')}}">{{ trans('student::local.parents') }}</a></li>
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
              <div class="col-md-12">
                  <h2 class="mb-2">{{$motherName}}</h2>
              </div>
            <div class="col-md-12">                
                <a href="{{route('fathers.addWife',$id)}}" class="btn btn-success white"><i class="la la-female"></i> {{ trans('student::local.add_father') }}</a>
                <a href="#" class="btn btn-primary white"><i class="la la-eye"></i> {{ trans('student::local.show_mother_data') }}</a>
                <a href="{{route('fathers.edit',$id)}}" class="btn btn-warning white"><i class="la la-edit"></i> {{ trans('student::local.edit_mother_data') }}</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection