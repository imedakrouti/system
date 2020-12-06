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
        <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
          <a href="#"  onclick="deleteHW()" class="btn btn-danger box-shadow round mr-1">{{ trans('learning::local.delete_homework') }}</a>          
        </div> 
        <div class="btn-group mr-1 mb-1 float-right">
            <button type="button" class="btn btn-success btn-min-width dropdown-toggle round" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.add_homework') }}</button>
            <div class="dropdown-menu">
            <a class="dropdown-item" onclick="assignment()" href="#"><i class="la la-sticky-note"></i>{{ trans('learning::local.assignment') }}</a>
            <a class="dropdown-item" onclick="question()" href="#"><i class="la la-question"></i>{{ trans('learning::local.add_questions') }}</a>                  
            </div>            
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
                                <th>{{trans('learning::local.title')}}</th>                                
                                <th>{{trans('learning::local.subject')}}</th>                                                                                               
                                <th>{{trans('learning::local.total_mark')}}</th>                                                                                               
                                <th>{{trans('learning::local.due_date')}}</th>                                                                
                                <th>{{trans('learning::local.show_homework')}}</th>                                                                                                                               
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

@include('learning::teacher.posts.includes._homework-assignment')                                    
@include('learning::teacher.posts.includes._homework-question')                                    
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
          ajax: "{{ route('teacher.homeworks') }}",
          columns: [
                {data: 'check',         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'title',         name: 'title'},
                {data: 'subject',       name: 'subject'},
                {data: 'total_mark',    name: 'total_mark'},                                          
                {data: 'due_date',      name: 'due_date'},                
                {data: 'show_homework', name: 'show_homework'},                                                          
                {data: 'action', 	      name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

    function assignment()
    {            
        $('#assignment').modal({backdrop: 'static', keyboard: false})
        $('#assignment').modal('show');
    }

    function question()
    {            
        $('#question').modal({backdrop: 'static', keyboard: false})
        $('#question').modal('show');
    }

    function deleteHW() {
      var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
        if (itemChecked > 0) {
            var form_data = $('#formData').serialize();
            swal({
                    title: "{{trans('msg.delete_confirmation')}}",
                    text: "{{trans('learning::local.msg_delete_homework')}}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#D15B47",
                    confirmButtonText: "{{trans('msg.yes')}}",
                    cancelButtonText: "{{trans('msg.no')}}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('homeworks.destroy')}}",
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
