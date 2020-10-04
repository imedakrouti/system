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
              <div class="col-md-8"> 
                <form class="form form-horizontal" action="{{route('leave-request.update')}}" method="post">
                    @csrf                    
                    <textarea class="form-control" name="endorsement" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('endorsement',$content->endorsement)}}</textarea>                          
                    <div class="form-actions left">
                        <button type="submit" class="btn btn-success">
                            <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                        </button>                     
                    </div>                  
                </form>               
              </div>
              <div class="col-md-4">
                <table class="table">
                  <thead>
                    <tr>
                      <th>{{ trans('student::local.item') }}</th>
                      <th>{{ trans('student::local.description') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>student_name</td>
                      <td>{{ trans('student::local.student_name') }}</td>
                    </tr>
                    <tr>
                      <td>father_name</td>
                      <td>{{ trans('student::local.father_name') }}</td>
                    </tr>  
                    <tr>
                      <td>father_national_id</td>
                      <td>{{ trans('student::local.father_id_number') }}</td>
                    </tr>  
                    <tr>
                      <td>mother_name</td>
                      <td>{{ trans('student::local.mother_name') }}</td>
                    </tr>  
                    <tr>
                      <td>mother_national_id</td>
                      <td>{{ trans('student::local.id_number_m') }}</td>
                    </tr>  
                    <tr>                      
                      <td>grade</td>
                      <td>{{ trans('student::local.grade') }}</td>
                    </tr>    
                    <tr>
                        <td>year</td>
                        <td>{{ trans('student::local.year') }}</td>
                    </tr>                                                                                                                                       
                    <tr>
                        <td>date</td>
                        <td>{{ trans('student::local.date') }}</td>
                    </tr>                     
                  </tbody>
                </table>
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
