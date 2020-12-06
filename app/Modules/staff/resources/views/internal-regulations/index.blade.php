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
          <h3 class="red"><strong>{{$title}}</strong></h3>
          <hr>
          <div class="row">                      
            <div class="col-lg-12 col-md-12"> 
                <form class="form form-horizontal" action="{{route('internal-regulations.update')}}" method="post">
                    @csrf                      
                      <div class="form-group">
                          <label>{{ trans('staff::local.ar_internal_regulation') }}</label>
                          <textarea class="form-control" name="internal_regulation_text" cols="30" rows="10" class="ckeditor">{!!old('internal_regulation_text',$internal->internal_regulation_text)!!}</textarea>                                                
                      </div> 
                      <div class="form-group">
                          <label>{{ trans('staff::local.en_internal_regulation') }}</label>
                          <textarea class="form-control" name="en_internal_regulation" cols="30" rows="10" class="ckeditor">{!!old('en_internal_regulation',$internal->en_internal_regulation)!!}</textarea>                                                
                      </div>                                       
                    <div class="form-actions left">
                        <button type="submit" class="btn btn-success">
                            <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                        </button>                     
                    </div>                  
                </form>               
            </div>          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
