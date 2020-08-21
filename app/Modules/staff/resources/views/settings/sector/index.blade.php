@extends('layouts.cpanel')
@section('sidebar')
    @include('layouts.includes.sidebars._staff')
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
            <li class="breadcrumb-item"><a href="{{aurl('dashboard')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('staff.setting')}}">{{ trans('staff::admin.settings') }}</a></li>
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
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
              <div class="table-responsive">
                  <form action="{{route('accounts.destroy')}}" id='formData' method="post">
                    @csrf
                    <table id="dynamic-table" class="table data-table" >
                        <thead class="bg-info white">
                            <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('staff::admin.arabic_sector')}}</th>
                                <th>{{trans('staff::admin.english_sector')}}</th>
                                <th>{{trans('staff::admin.sort')}}</th>
                                <th>{{trans('staff::admin.edit')}}</th>
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
        @include('layouts.includes.datatables._datatableConfig')
            dom: 'Bfrtip',
            buttons: [
                // new btn
                {
                    "text": "{{trans('staff::admin.new_sector')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('sector.create')}}";
                        }
                },
                // delete btn
                @include('layouts.includes.datatables._deleteBtn',['route'=>'sector.destroy'])

                // default btns
                @include('layouts.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('sector.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'arabicSector',        name: 'arabicSector'},
              {data: 'englishSector',       name: 'englishSector'},
              {data: 'sort', 		        name: 'sort'},
              {data: 'action', 	    name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.includes.datatables._datatableLang')
      });
      @include('layouts.includes.datatables._multiSelect')
    });
</script>
@include('layouts.includes.datatables._datatable')
@endsection
