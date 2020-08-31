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
    <div class="col-6">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <div class="col-md-12">                
                <h2 class="mb-2">
                  @if (session('lang')==trans('admin.ar'))
                  <a href="{{route('father.show',$father->id)}}">{{$father->ar_st_name}} {{$father->ar_nd_name}} {{$father->ar_rd_name}} {{$father->ar_th_name}}</a>
                  @else
                  <a href="{{route('father.show',$father->id)}}">{{$father->en_st_name}} {{$father->en_nd_name}} {{$father->en_rd_name}} {{$father->en_th_name}}</a>
                  @endif                 
                </h2>
            </div>
              <div class="row">
                <div class="col-md-12">                
                  <h5> {{ trans('student::local.father_main_data') }}</h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h6>{{ trans('student::local.id_type') }} : {{$father->id_type}}</h6>
                      <h6>{{ trans('student::local.religion') }} : 
                        {{$father->religion == 'muslim' ? trans('student::local.muslim') : trans('student::local.non_muslim')}}</h6>
                      <h6>{{ trans('student::local.job') }} : {{$father->job}}</h6>
                      <h6>{{ trans('student::local.facebook') }} : {{$father->facebook}}</h6>
                    </div>
                    <div class="col-md-6">
                      <h6>{{ trans('student::local.id_number') }} : {{$father->id_number}}</h6>
                      <h6>{{ trans('student::local.nationality_id') }} : {{$father->nationalities->ar_name_nat_male}}</h6>
                      <h6>{{ trans('student::local.qualification') }} : {{$father->qualification}}</h6>
                      <h6>{{ trans('student::local.whatsapp_number') }} : {{$father->whatsapp_number}}</h6>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
              <div class="row">
                <div class="col-md-12">                
                  <h5> {{ trans('student::local.contacts_data') }}</h5>
                  <hr>
                  <div class="row">
                    <div class="col-md-6">
                      <h6>{{ trans('student::local.home_phone') }} : {{$father->home_phone}}</h6>
                      <h6>{{ trans('student::local.mobile1') }} : {{$father->mobile1}}</h6>
                      <h6>{{ trans('student::local.block_no') }} : {{$father->block_no}}</h6>
                      <h6>{{ trans('student::local.state') }} : {{$father->state}}</h6>
                    </div>
                    <div class="col-md-6">
                      <h6>{{ trans('student::local.email') }} : {{$father->email}}</h6>
                      <h6>{{ trans('student::local.mobile2') }} : {{$father->mobile2}}</h6>
                      <h6>{{ trans('student::local.street_name') }} : {{$father->street_name}}</h6>
                      <h6>{{ trans('student::local.government') }} : {{$father->government}}</h6>
                    </div>
                  </div>                
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <form class="form form-horizontal" method="POST" action="{{route('students.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-body">                    
                    @include('layouts.backEnd.includes._msg')
                    @include('student::students._form')                    
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('parents.index')}}';">
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
@section('script')
<script src="{{asset('public/cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('public/cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@endsection
