@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('public/cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">                    
                    <div class="col-md-3">
                        <select name="division_id" class="form-control" id="division_id">
                            <option value="">{{ trans('student::local.division') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{$division->id}}">{{session('lang') == 'ar' ?$division->ar_division_name:$division->en_division_name}}</option>
                            @endforeach
                        </select>                    
                    </div>
                    <div class="col-md-3">
                      <select name="student_type" class="form-control" id="student_type">
                          <option value="">{{ trans('student::local.student_type') }}</option>
                          <option value="applicant">{{ trans('student::local.applicant') }}</option>
                          <option value="student">{{ trans('student::local.student') }}</option>                            
                      </select>                    
                  </div>                    
                </div>
            </div>          
          </div>
          <div class="row">
            <div class="table-responsive">
              <form action="" id='formData' method="post">
                @csrf
                <table id="dynamic-table" class="table data-table" >
                    <thead class="bg-info white">
                        <tr>                            
                            <th>#</th>
                            <th>{{trans('student::local.grades')}}</th>                                
                            <th>{{trans('student::local.applicants_count')}}</th>     
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
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
    <script>
      $('#division_id').on('change',function(){
        find();
      })
      $('#student_type').on('change',function(){
        find();
      })     
      function find()
      {
        $('#dynamic-table').DataTable().destroy();
        var student_type 		= $('#student_type').val();      
        var division_id 		= $('#division_id').val();
        var myTable         = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')
              buttons: [                                 
                {                    
                    "className": "hidden",                  
                },
                  @include('layouts.backEnd.includes.datatables._datatableBtn')              
              ],
              ajax:{
                  type:'POST',
                  url:'{{route("applicants.find")}}',
                  data: {
                      _method         : 'PUT',
                      student_type    : student_type,                    
                      division_id     : division_id,
                      _token          : '{{ csrf_token() }}'
                  }
                },
            columns: [            
                {data: 'DT_RowIndex',             name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'ar_grade_name',           name: 'ar_grade_name'},
                {data: 'applicants',              name: 'applicants'},              
            ],
            @include('layouts.backEnd.includes.datatables._datatableLang')
        });
        @include('layouts.backEnd.includes.datatables._multiSelect')
      } 
 
    </script>
@include('layouts.backEnd.includes.datatables._datatable')    
@endsection

 