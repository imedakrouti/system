@extends('layouts.backEnd.teacher')
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
            <li class="breadcrumb-item"><a href="{{route('teacher.homeworks')}}">{{ trans('learning::local.class_work') }}</a>
            </li>           
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>          
    </div>  
    <div class="content-header-right col-md-6 col-12 mb-1">
      <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        <a href="#"  onclick="deleteAnswer()" class="btn btn-danger box-shadow round mr-1"><i class="la la-trash"></i> {{ trans('learning::local.delete_answers') }}</a>          
      </div>   
      <div class="btn-group float-md-right" role="group" aria-label="Button group with nested dropdown">
        <a href="#"  onclick="printReport()" class="btn btn-info box-shadow round mr-1"><i class="la la-print"></i> {{ trans('learning::local.print_report') }}</a>          
      </div>     
  </div>  
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-header">
            <h4 class="card-title mb-1"><strong>{{$homework->title}}</strong></h4>
            <p>{{$homework->instruction}}</p>
          </div>
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
                                <th>{{trans('student::local.student_image')}}</th>                                
                                <th>{{trans('learning::local.student_name')}}</th>                                
                                <th>{{trans('learning::local.deliver_date')}}</th>                                
                                <th>{{trans('student.mark')}}</th>                                                                                                                                                               
                                <th>{{trans('student.answers')}}</th>
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
          ajax: "{{ route('teacher.homework-applicants',$homework->id) }}",
          columns: [
                {data: 'check',         name: 'check', orderable: false, searchable: false},
                {data: 'DT_RowIndex',   name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'student_image', name: 'student_image'},
                {data: 'student_name',  name: 'student_name'},
                {data: 'updated_at',    name: 'updated_at'},
                {data: 'mark',          name: 'mark'},                                
                {data: 'answers',       name: 'answers'},                                          
                
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });  

    function deleteAnswer()
    {
        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
        if (itemChecked > 0) {
            var form_data = $('#formData').serialize();
            swal({
                    title: "{{trans('msg.delete_confirmation')}}",
                    text: "{!!trans('learning::local.msg_ask_del_student_mark')!!}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#D15B47",
                    confirmButtonText: "{{trans('msg.yes')}}",
                    cancelButtonText: "{{trans('msg.no')}}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route('homework.destroy-answers')}}",
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
