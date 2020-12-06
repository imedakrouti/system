@extends('layouts.backEnd.teacher')
@section('styles')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      
    </div>  
    <div class="content-header-right col-md-6 col-12 mb-1">
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <a href="#"  onclick="deleteExam()" class="btn btn-danger box-shadow round mr-1">{{ trans('learning::local.delete_exam') }}</a>          
        </div>      
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <a href="{{route('teacher.new-exam')}}"  class="btn btn-success box-shadow round mr-1">{{ trans('learning::local.new_exam') }}</a>          
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
                      <thead>
                          <tr>
                                <th><input type="checkbox" class="ace" /></th>
                                <th>#</th>
                                <th>{{trans('learning::local.exam_name')}}</th>                                
                                <th>{{trans('learning::local.start_exam')}}</th>                                
                                <th>{{trans('learning::local.end_exam')}}</th>                                                                                                                               
                                <th>{{trans('learning::local.applicants')}}</th>                                                                                               
                                <th>{{trans('learning::local.show_questions')}}</th>                                                                                               
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
          processing: true,
          serverSide: false,
          "paging": true,
          "ordering": true,
          "info":     true,
          "pageLength": 10, // set page records
          "lengthMenu": [10,20, 50, 100, 200,500],
          "bLengthChange" : true,  
          dom: 'blfrtip',        
          ajax: "{{ route('teacher.view-exams') }}",
          columns: [
                {data: 'check',         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'exam_name',     name: 'exam_name'},
                {data: 'start_date',    name: 'start_date'},
                {data: 'end_date',      name: 'end_date'},                
                {data: 'applicants',    name: 'applicants'},                                          
                {data: 'show_questions',name: 'show_questions'},                                          
                {data: 'action', 	      name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

    function deleteExam() {
      var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
        if (itemChecked > 0) {
            var form_data = $('#formData').serialize();
            swal({
                    title: "{{trans('msg.delete_confirmation')}}",
                    text: "{{trans('learning::local.msg_delete_exam')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#D15B47",
                    confirmButtonText: "{{trans('msg.yes')}}",
                    cancelButtonText: "{{trans('msg.no')}}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('exams.destroy')}}",
                        method:"POST",
                        data:form_data,
                        dataType:"json",
                        // display succees message
                        success:function(data)
                        {
                            $('.data-table').DataTable().ajax.reload();
                        }
                    })
                    // display success confirm message
                    .done(function(data) {
                        if(data.status == true)
                        {
                            swal("{{trans('msg.delete')}}", "{{trans('msg.delete_successfully')}}", "success");
                        }else{
                            swal("{{trans('msg.delete')}}", data.msg, "error");                        
                        }
                    });
                }
            );
        }	else{
            swal("{{trans('msg.delete_confirmation')}}", "{{trans('msg.no_records_selected')}}", "info");
        }      
    }

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection
