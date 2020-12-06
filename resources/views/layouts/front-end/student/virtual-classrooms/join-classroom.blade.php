@extends('layouts.front-end.student.index')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
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
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>{{trans('learning::local.topic')}}</th>                                
                              <th>{{trans('learning::local.date')}} &  {{trans('learning::local.time')}}</th>                                                                                            
                              <th>{{trans('learning::local.subject')}}</th>                                                                
                              <th>{{trans('student.join_class')}}</th>                                                                
                              <th>{{trans('student.pass_code')}}</th>                                                                
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
        processing: true,
        serverSide: false,
        "paging": true,
        "ordering": false,
        "info":     true,
        "pageLength": 10, // set page records            
        "bLengthChange" : false,
          ajax: "{{ route('student.join-classroom') }}",
          columns: [
              {data: 'DT_RowIndex',      name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'topic',            name: 'topic'},
              {data: 'start_date',       name: 'start_date'},                            
              {data: 'subject',          name: 'subject'},                      
              {data: 'start_class',      name: 'start_class'},                          
              {data: 'pass_code',        name: 'pass_code'},                          
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
