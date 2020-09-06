@extends('layouts.backEnd.cpanel')
@section('styles')

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
<div id='fc-basic-views'></div>
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
        events: "{{route('calendar.index')}}"
    });


    });
</script>
@endsection

 