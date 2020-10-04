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
            <li class="breadcrumb-item"><a href="{{route('commissioners.index')}}">{{ trans('student::local.commissioners') }}</a></li>
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
        <div class="card-content collapse show">
          <div class="card-body">            
            <div class="form-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="red"><strong>{{$commissioner->commissioner_name}}</strong></h3>
                        <h6><strong>{{ trans('student::local.mobile_number') }} : </strong>{{$commissioner->mobile}}</h6>
                        <h6><strong>{{ trans('student::local.id_number_card') }} : </strong>{{$commissioner->id_number}}</h6>
                        <h6><strong>{{ trans('student::local.relation') }} : </strong>{{$commissioner->relation}}</h6>
                        <h6><strong>{{ trans('student::local.created_by') }} : </strong>{{$commissioner->admin->name}}</h6>
                        <h6><strong>{{ trans('student::local.created_at') }} : </strong>{{$commissioner->created_at}}</h6>
                        <h6><strong>{{ trans('student::local.updated_at') }} : </strong>{{$commissioner->updated_at}}
                        </div></h6>
                    <div class="col-md-6">
                        <h6><strong>{{ trans('student::local.notes') }}</strong></h6>
                        <p>{{$commissioner->commissioner_name}}</p>
                        @if (!empty($commissioner->file_name))
                            <a target="blank" class="btn btn-success btn-sm" href="{{asset('storage/attachments/'.$commissioner->file_name)}}">
                               <i class="la la-download"></i> {{ trans('student::local.attachements') }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>              
          </div>
        </div>
      </div>
    </div>
</div>
@include('student::students-affairs.commissioners.includes._student-commissioner')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{ trans('student::local.students_names') }}</h4>
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
                                <th>{{trans('student::local.student_number')}}</th>
                                <th>{{trans('student::local.student_name')}}</th>
                                <th>{{trans('student::local.grade')}}</th>
                                <th>{{trans('student::local.division')}}</th>                                
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
                    // new btn
                    {
                        "text": "{{trans('student::local.join_student')}}",
                        "className": "btn btn-success buttons-print btn-success mr-1",
                        action : function ( e, dt, node, config ) {
                                $('#large').modal('show');
                            }
                    },
                    // new btn
                    {
                        "text": "{{trans('student::local.print_commissioner_report')}}",
                        "className": "btn btn-primary mr-1",
                        action : function ( e, dt, node, config ) {
                            window.location.href = "{{route('commissioners-students.print',$commissioner->id)}}";
                            }
                    },                
                    // delete btn
                    @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'commissioners-students.destroy'])

                    // default btns
                    @include('layouts.backEnd.includes.datatables._datatableBtn')
                ],
          ajax: "{{ route('commissioners.show',$commissioner->id) }}",
          columns: [   
              {data: 'check',               name: 'check', orderable: false, searchable: false},           
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'student_number',      name: 'student_number'},
              {data: 'student_name',        name: 'student_name'},
              {data: 'grade',               name: 'grade'}, 
              {data: 'division',            name: 'division'},               
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
    $('#btnSave').on('click',function(event){
        event.preventDefault();
        var form_data = $('#form').serialize();
        $.ajax({
            url:"{{route('commissioners-students.store')}}",
            method:"POST",
            data:form_data,
            dataType:"json",
            // display succees message
            success:function(data)
            {
                $('#dynamic-table').DataTable().ajax.reload();
                $('#large').modal('hide');
            }
        })        
    }) 
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection