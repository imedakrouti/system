@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
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
<form action="{{route('emp-open.print')}}" id='formData' method="get">
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">                    
                            <label class="label-control" >{{ trans('student::local.emp_open_app') }}</label>
                        <select name="adminId" id="adminId" class="form-control" style="margin-top: 0">                            
                            @foreach ($admins as $admin)
                            <option {{old('employee_id') == $admin->id ?'select':''}} value="{{$admin->id}}">{{$admin->name}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="label-control">{{ trans('student::local.from') }}</label>
                          <input type="date" class="form-control" id="fromDate" name="fromDate">
                        </div>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label class="label-control">{{ trans('student::local.to') }}</label>
                          <input type="date" class="form-control" id="toDate" name="toDate">
                        </div>
                    </div>
                  </div>   
                  <div class="col-lg-3 col-md-6">
                    <button type="button" style="margin-top: 30px;" onclick="find()"class="btn btn-info  btn-md">
                        {{ trans('student::local.search') }}
                    </button>
                    <button type="submit" style="margin-top: 30px;" onclick="printReport()"class="btn btn-light  btn-md">
                        {{ trans('student::local.print') }}
                    </button>                        
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
            <div class="table-responsive">                               
                  <table id="dynamic-table" class="table data-table" >
                      <thead class="bg-info white">
                          <tr>
                              <th><input type="checkbox" class="ace" /></th>
                              <th>#</th>
                              <th>{{trans('student::local.application_date')}}</th>
                              <th>{{trans('student::local.student_number')}}</th>
                              <th>{{trans('student::local.student_name')}}</th>
                              <th>{{trans('student::local.registration_status')}}</th>
                              <th>{{trans('student::local.student_type')}}</th>
                              <th>{{trans('student::local.mother_name')}}</th>
                              <th>{{trans('student::local.grade')}}</th>                              
                              <th>{{trans('student::local.division')}}</th>                              
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>                
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</form>
@endsection
@section('script')
  <script>
       function find()
        {  
            $('#dynamic-table').DataTable().destroy();
            var myTable = $('#dynamic-table').DataTable({
            @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                {                    
                    "className": "hidden",      
                },
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
            ajax:{
                    type:'POST',
                    url:'{{route("employee-admission.find")}}',
                    data:function(data){
                        data._method                = 'PUT';
                        data._token                 = '{{ csrf_token() }}';
                        data.fromDate 		        = $('#fromDate').val();
                        data.toDate 		        = $('#toDate').val();
                        data.adminId 		        = $('#adminId').val();
                    }
                },
            columns: [
                {data: 'check',                 name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'application_date',      name: 'application_date'}, 
                {data: 'student_number',        name: 'student_number'}, 
                {data: 'studentName',           name: 'studentName'},
                {data: 'registration_status',   name: 'registration_status'},
                {data: 'student_type',          name: 'student_type'},                     
                {data: 'motherName',            name: 'motherName'},                     
                {data: 'grade',                 name: 'grade'},                     
                {data: 'division',              name: 'division'},                     
            ],
            @include('layouts.backEnd.includes.datatables._datatableLang')
        });
            @include('layouts.backEnd.includes.datatables._multiSelect')
        };   
        
        function printReport()
        {
            var adminId 		    = $('#adminId').val();
            var fromDate 		    = $('#fromDate').val();
            var toDate 		        = $('#toDate').val();
            window.location.href = "{{route('emp-open.print'," + adminId + ")}}" ;
        }
  </script>
  @include('layouts.backEnd.includes.datatables._datatable')
@endsection

 