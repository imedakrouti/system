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
                <form class="form form-horizontal" action="{{route('footer.update')}}" method="post">
                    @csrf                    
                    <textarea class="form-control" name="footer" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('footer',$content->footer)}}</textarea>                          
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
@section('script')
<script src="{{asset('cpanel/app-assets/vendors/js/editors/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('cpanel/app-assets/js/scripts/editors/editor-ckeditor.js')}}"></script>    
@endsection
