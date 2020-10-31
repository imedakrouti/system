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
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">            
            <form action="{{route('attendances.report')}}" method="GET" target="blank" id="sheetReport">
              <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="form-group">                      
                      <select name="attendance_id" id="attendance_id" class="form-control select2" required>
                          <option value="">{{ trans('staff::local.employee_name') }}</option>
                          @foreach ($employees as $employee)
                              <option {{old('attendance_id') == $employee->id ? 'selected' :''}} value="{{$employee->attendance_id}}">
                              @if (session('lang') == 'ar')
                              [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                              @else
                              [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$staff->en_th_name}}
                              @endif
                              </option>
                          @endforeach
                      </select> <br>                  
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">                        
                        <input type="date" class="form-control" name="from_date" id="from_date">                 
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="form-group">                        
                        <input type="date" class="form-control" name="to_date" id="to_date">                 
                    </div>
                </div>

                <div class="col-lg-2 col-md-6">
                    <div class="form-group">                           
                        <a href="#" class="btn btn-primary" onclick="searchFilter()">{{ trans('staff::local.search') }}</a>
                    </div>
                </div>
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
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">            
          <table class="table table-striped" >
            <thead class="bg-info white">
                <tr class="center">                                                                                      
                      <th width="120px">{{trans('staff::local.employee_name')}}</th>
                      <th width="120px">{{trans('staff::local.working_data')}}</th>
                      <th width="120px">{{trans('staff::local.timetable_id')}}</th>
                      <th width="120px">{{trans('staff::local.hiring_date')}}</th>
                      <th width="120px">{{trans('staff::local.leave_date')}}</th>
                      <th width="120px">{{trans('staff::local.attend_days')}}</th>
                      <th width="120px">{{trans('staff::local.absent_days')}}</th>                                                      
                      <th width="120px">{{trans('staff::local.total_lates')}}</th>
                      <th width="120px">{{trans('staff::local.vacation_days_count')}}</th>                                                        
                      <th width="120px">{{trans('staff::local.leave_permissions_count')}}</th>                                                                   
                </tr>
            </thead>
            <tbody id="summary">

            </tbody>
        </table>
         
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
                <table id="dynamic-table" class="table table-bordered" >
                    <thead class="bg-info white">
                        <tr>                                                                
                              <th width="65px">#</th>  
                              <th width="120px">{{trans('staff::local.week')}}</th>
                              <th width="120px">{{trans('staff::local.date')}}</th>                                                      
                              <th width="120px">{{trans('staff::local.on_duty_time')}}</th>
                              <th width="120px">{{trans('staff::local.off_duty_time')}}</th>                                                        
                              <th width="120px">{{trans('staff::local.clock_in')}}</th>
                              <th width="120px">{{trans('staff::local.clock_out')}}</th>                            
                              <th width="120px">{{trans('staff::local.no_attend_fp')}}</th>
                              <th width="120px">{{trans('staff::local.no_leave_fp')}}</th>
                              <th width="120px">{{trans('staff::local.vacation_type')}}</th>
                              <th width="120px">{{trans('staff::local.holiday')}}</th>
                              <th width="120px">{{trans('staff::local.absent')}}</th>
                              <th width="120px">{{trans('staff::local.date_leave')}}</th>
                              <th width="120px">{{trans('staff::local.time_leave')}}</th>
                              <th width="120px">{{trans('staff::local.lates_after_request')}}</th>
                              <th width="120px">{{trans('staff::local.early_after_request')}}</th>
                              <th width="120px">{{trans('staff::local.absent_value')}}</th>                                                              
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
    function searchFilter()
    {
        summary()
        var attendance_id   = $('#attendance_id').val();
        var from_date       = $('#from_date').val();
        var to_date         = $('#to_date').val();
        
        $('#dynamic-table').DataTable().destroy();

        var myTable = $('#dynamic-table').DataTable({
            processing: true,
            serverSide: false,
            "paging": false,
            "ordering": false,
            "info":     false,
            "pageLength": 31, // set page records
            "lengthMenu": [10,20, 50, 100, 200,500],
            "bLengthChange" : false,
            dom: 'Blfrtip',
            buttons: [
                {
                "text": "{{trans('admin.print')}}",
                "className": "btn btn-primary mr-1",
                action: function ( e, dt, node, config ) {
                  $('#sheetReport').submit();
                }
            },
            // default btns
            @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],          

            ajax:{
                type:'POST',
                url:'{{route("attendances.logs-sheet")}}',
                data: {
                    _method         : 'PUT',
                    attendance_id   : attendance_id,
                    from_date       : from_date,
                    to_date         : to_date,
                    _token          : '{{ csrf_token() }}'
                }
              },
          columns: [              
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'week',                name: 'week'},
              {data: 'selected_date',       name: 'selected_date'},
              {data: 'on_duty_time',        name: 'on_duty_time'},                             
              {data: 'off_duty_time',       name: 'off_duty_time'},                             
              {data: 'clock_in',            name: 'clock_in'},                             
              {data: 'clock_out',           name: 'clock_out'},                             
              {data: 'no_attend',           name: 'no_attend'},                             
              {data: 'no_leave',            name: 'no_leave'},                             
              {data: 'vacation_type',       name: 'vacation_type'},                             
              {data: 'date_holiday',        name: 'date_holiday'},                             
              {data: 'absent',              name: 'absent'},                             
              {data: 'date_leave',          name: 'date_leave'},                             
              {data: 'time_leave',          name: 'time_leave'},                             
              {data: 'main_lates',          name: 'main_lates'},                             
              {data: 'leave_mins',          name: 'leave_mins'},                             
              {data: 'absentValue',         name: 'absentValue'},                             
          ],
          columnDefs: [
                    // default column not visibilty
                    { visible: false, targets: [3,4,12,13,15] },
                    { orderable: false, targets: [0 ] }, 
                    { width: 65, targets: 0 },
                    { width: 100, targets: 1 },
                    { width: 100, targets: 2 },
                    { width: 100, targets: 3 },
                    { width: 100, targets: 4 },
                    { width: 100, targets: 5 },
                    { width: 100, targets: 6 },
                    { width: 100, targets: 7 },
                    { width: 100, targets: 8 },
                    { width: 100, targets: 9 },
                    { width: 100, targets: 10 },
                    { width: 100, targets: 11 },
                    { width: 100, targets: 12 },
                    { width: 100, targets: 13 },
                    { width: 100, targets: 14 },
                    { width: 100, targets: 15 },
                    { width: 100, targets: 16 }                    
                ],
          fixedColumns: true ,
            'rowCallback': function(row, data, index){                        
                if(data.absent ){                        
                    $('td', row).css('background-color', '#bc0a0a');                        
                    $('td', row).css('color', 'white');                        
                }
                if(data.vacation_type ){                        
                    $('td', row).css('background-color', '#0f7b93');                        
                    $('td', row).css('color', 'white');                        
                }
                if(data.date_holiday ){                        
                    $('td', row).css('background-color', '#edb32e');                        
                    $('td', row).css('color', 'white');                        
                }
                if(data.date_leave ){                        
                    $('td', row).css('background-color', 'green');                        
                    $('td', row).css('color', 'white');                        
                }
            },
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')

       
    }
    function summary()
    {
      var attendance_id   = $('#attendance_id').val();
      var from_date       = $('#from_date').val();
      var to_date         = $('#to_date').val();
      $.ajax({
            url:'{{route("attendances.summary")}}',
            type:"post",
            data: {
              _method		    : 'PUT',                
              attendance_id : attendance_id,
              from_date 	  : from_date,
              to_date 	    : to_date,
              _token		    : '{{ csrf_token() }}'
              },
            dataType: 'json',
            success: function(data){
              var tbody = `<tr>                  
                  <td class="center">`+(data.employee_name)+`</td>
                  <td class="center">`+(data.working_data)+`</td>
                  <td class="center">`+(data.timetable_id)+`</td>
                  <td class="center">`+(data.hiring_date)+`</td>
                  <td class="center">`+(data.leave_date)+`</td>
                  <td class="center">`+(data.attend_days)+`</td>
                  <td class="center">`+(data.absent_days)+`</td>
                  <td class="center">`+(data.total_lates)+`</td>
                  <td class="center">`+(data.vacation_days_count)+`</td>
                  <td class="center">`+(data.leave_permissions_count)+`</td>
                </tr>`
              $('#summary').html(tbody);
            }
        });
    }

</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection