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
                    <thead class="bg-info white">
                        <tr>                              
                              <th>#</th>
                              <th>{{trans('student.exam_name')}}</th>                                                                                               
                              <th>{{trans('student.date')}}</th>                                                            
                              <th>{{trans('student.subject')}}</th>                                
                              <th>{{trans('student.total_mark')}}</th>                                                                                                                             
                              <th>{{trans('student.mark')}}</th>                                                                                                                             
                              <th>{{trans('student.answers')}}</th>                                                                                                                                                           
                              <th>{{trans('student.show_answers')}}</th>                                                                                                                                                           
                              <th>{{trans('student.report')}}</th>                                                                                                                                                           
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
  @include('layouts.front-end.student.exams.includes._show-report')                                    
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
            
          ajax: "{{ route('student.results') }}",
          columns: [                
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'exam_name',     name: 'exam_name'},
                {data: 'date_exam',     name: 'date_exam'},                
                {data: 'subject',       name: 'subject'},
                {data: 'total_mark',    name: 'total_mark'},                                                          
                {data: 'mark',          name: 'mark'},                                                          
                {data: 'answers',       name: 'answers'},                                                                          
                {data: 'show_answers',  name: 'show_answers'},                                                                          
                {data: 'report',        name: 'report'},                                                                          
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  
    function getReport(exam_id)
        {          
            $.ajax({
                url:'{{route("student.get-report")}}',
                type:"post",
                data: {
                    _method		    : 'PUT',                
                    exam_id 	    : exam_id,
                    _token		    : '{{ csrf_token() }}'
                    },
                dataType: 'json',
                success: function(data){
                    $('#report').val(data);			                                      
                    $('#addReportModal').modal({backdrop: 'static', keyboard: false})
                    $('#addReportModal').modal('show');
                }
            });            
        }
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
