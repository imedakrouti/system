@extends('layouts.backEnd.teacher')
@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/calendars/fullcalendar.min.css')}}">
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
            <div class="card-body">
                <div id='fc-basic-views'></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('cpanel/app-assets/vendors/js/extensions/moment.min.js')}}"></script>
<script src="{{asset('cpanel/app-assets/vendors/js/extensions/fullcalendar.min.js')}}"></script>
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
        events: "{{route('zoom-schedules.view')}}"
    });


    });
</script>
@endsection

 