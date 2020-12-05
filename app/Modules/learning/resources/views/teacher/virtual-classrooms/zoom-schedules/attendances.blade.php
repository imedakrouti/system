@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('zoom-schedules.index')}}">{{ trans('learning::local.manage_zoom_schedule') }}</a>
            </li>                        
            <li class="breadcrumb-item">{{ $title }}</li>     
          </ol>
        </div>
      </div>
    </div>     
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="bg-info white">
                            <tr>
                                <th colspan="2">{{ trans('learning::local.student_name') }}</th>
                                <th>{{ trans('learning::local.join_time') }}</th>
                            </tr>
                        </thead>
                        <tbody id="attendances">

                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
    <script>
        attendances()
        function attendances()
        {
            var zoom_schedule_id = "{{$zoom_schedule->id}}";
            
            $.ajax({
                    url:'{{route("zoom.join-time")}}',
                    type:"post",
                    data: {
                        _method		    : 'PUT',                
                        zoom_schedule_id: zoom_schedule_id,
                        _token		    : '{{ csrf_token() }}'
                    },
                    dataType:'json',
                    success:function(data){
                        $('#attendances').html(data);                                   
                    }
                });  
        }

        setInterval(function()
        {
            attendances();          
        },5000); //1000 second
    </script>
@endsection