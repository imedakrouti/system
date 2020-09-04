@extends('layouts.backEnd.cpanel')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('public/cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('public/cpanel/app-assets/vendors/css/calendars/fullcalendar.min.css')}}">
@endsection
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
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
@include('student::admissions.interviews-dates._form')
@endsection

@section('script')
<script src="{{asset('public/cpanel/app-assets/vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('public/cpanel/app-assets/vendors/js/extensions/fullcalendar.min.js')}}"></script>
<script>

    $(document).ready(function(){

    /****************************************
    *				Basic Views				*
    ****************************************/
    $('#fc-basic-views').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
        // defaultDate: '2016-06-12',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: "{{route('show.meetings')}}"
    });


    });
</script>
<script>
    $(function () {
        var myTable = $('#dynamic-table').DataTable({
        @include('layouts.backEnd.includes.datatables._datatableConfig')            
            buttons: [
                // new btn
                {
                    "text": "{{trans('student::local.new_meeting')}}",
                    "className": "btn btn-success buttons-print btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('meetings.create')}}";
                        }
                },
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'meetings.destroy'])

                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ],
          ajax: "{{ route('meetings.index') }}",
          columns: [
              {data: 'check',               name: 'check', orderable: false, searchable: false},
              {data: 'DT_RowIndex',         name: 'DT_RowIndex', orderable: false, searchable: false},
              {data: 'father_name',         name: 'father_name'},
              {data: 'start',               name: 'start'},
              {data: 'end',                 name: 'end'}, 
              {data: 'meeting_status',      name: 'meeting_status'}, 
              {data: 'interview_id',        name: 'interview_id'}, 
              {data: 'action', 	            name: 'action', orderable: false, searchable: false},
          ],
          @include('layouts.backEnd.includes.datatables._datatableLang')
      });
      @include('layouts.backEnd.includes.datatables._multiSelect')
    });
</script>
@include('layouts.backEnd.includes.datatables._datatable')
@endsection

 