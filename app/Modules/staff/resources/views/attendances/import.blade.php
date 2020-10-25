@extends('layouts.backEnd.cpanel')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-lg-6 col-md-6 col-12 mb-2">
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
      <div class="card-header">
        <h4 class="card-title">{{ trans('staff::local.instructions') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
       
        <h4>{{ trans('staff::local.attend_note_1') }}</h4>
        <h4>{{ trans('staff::local.attend_note_2') }}</h4>
        <h4>{{ trans('staff::local.attend_note_3') }}</h4>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <div class="alert bg-primary alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                <span class="alert-icon"><i class="la la-info-circle"></i></span>               
                <h4 class="white">{{ trans('staff::local.import_attendance_tip') }}</h4>
            </div>
              <div class="table-responsive">   
                    <table class="table center" >
                        <thead class="bg-info white">
                            <tr">                              
                                <th>attendance_id</th>
                                <th>status</th>
                                <th>time</th>                                                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>31-01-2020 07:13:00</td>
                                <td>In</td>
                                <td>1</td>
                            </tr>
                            <tr>
                                <td>31-01-2020 07:13:00</td>
                                <td>Out</td>
                                <td>0</td>
                            </tr>
                        </tbody>
                    </table>              
              </div>

                <form action="{{route('attendances.import-excel')}}" method="post"  enctype="multipart/form-data">
                    @csrf
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group row">
                        <label >{{ trans('staff::local.file_name') }}</label>
                        <input  type="file" class="form-control" name="import_file">                  
                        </div>
                    </div>   
                    <div class="form-actions left">
                        <button type="submit" class="btn btn-success">
                            <i class="la la-upload"></i> {{ trans('admin.import') }}
                          </button>                        
                    </div>                              
                </form>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{ trans('staff::local.attendance_files') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      </div>
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
            <div class="table-responsive">
                <form action="" id='formData' method="post">
                  @csrf
                  <table id="dynamic-table" class="table data-table" >
                      <thead class="bg-info white">
                          <tr>
                              <th><input type="checkbox" class="ace" /></th>
                              <th>#</th>
                              <th>{{trans('staff::local.sheet_name')}}</th>
                              <th>{{trans('staff::local.created_at')}}</th>
                              <th>{{trans('staff::local.upload_by')}}</th>                                                              
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

@endsection
@section('script')
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [

                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'attendances.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('attendances.import') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'sheet_name',          name: 'sheet_name'},
              {data: 'created_at',          name: 'created_at'},
              {data: 'admin',               name: 'admin'},                             
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection