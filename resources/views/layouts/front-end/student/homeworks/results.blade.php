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
                <table id="dynamic-table" class="table data-table" >
                    <thead>
                        <tr>                              
                              <th>#</th>
                              <th width="220">{{trans('student.title')}}</th>                                                                                               
                              <th>{{trans('student.subject')}}</th>                                
                              <th>{{trans('student.date')}}</th>                                
                              <th>{{trans('student.mark')}}</th>                                                                                                                             
                              <th>{{trans('student.show_answers')}}</th>                                                                                              
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
            "bLengthChange" : true,
            dom: 'blfrtip',
          ajax: "{{ route('homework.results') }}",
          columns: [                
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title',         name: 'title'},
                {data: 'subject',       name: 'subject'},                                
                {data: 'due_date',      name: 'due_date'},
                {data: 'mark',          name: 'mark'},                                                                          
                {data: 'show_answers',  name: 'show_answers'},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection