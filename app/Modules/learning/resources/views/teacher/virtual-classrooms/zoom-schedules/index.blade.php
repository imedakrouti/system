@extends('layouts.backEnd.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
    </div>    
    <div class="content-header-right col-md-6 col-12">

        <div class="btn-group mr-1 mb-1 float-right">
            <a href="{{route('zoom-schedules.create')}}" class="btn btn-success">{{ trans('learning::local.add_zoom_schedule') }}</a>
        </div>
    </div>  
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
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
                              <th>{{trans('learning::local.topic')}}</th>                                
                              <th>{{trans('learning::local.date')}} &  {{trans('learning::local.time')}}</th>                                                                                            
                              <th>{{trans('learning::local.classroom')}}</th>                                                                
                              <th>{{trans('learning::local.start_class')}}</th>                                                                
                              <th>{{trans('student::local.edit')}}</th>
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
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'zoom-schedules.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('zoom-schedules.index') }}",
          columns: [
              {data: 'check',            name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',      name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'topic',            name: 'topic'},
              {data: 'start_date',       name: 'start_date'},                            
              {data: 'classroom',        name: 'classroom'},                      
              {data: 'start_class',      name: 'start_class'},                          
              {data: 'action', 	         name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
