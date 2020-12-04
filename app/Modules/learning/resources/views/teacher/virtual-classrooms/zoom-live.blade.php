@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
    </div>    
</div>

<div class="row mt-1">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <div id="time" class="hidden">1</div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="iframe-container" style="overflow: hidden; padding-top: 56.25%; position: relative;">
  <iframe allow="microphone; camera" style="border: 0; height: 0%; left: 0; position: absolute; top: 0; width: 0%;" 
  src="https://us04web.zoom.us/j/{{zoomMeetingID()}}" frameborder="0"></iframe>
</div>

@endsection
@section('script')
    <script>
      $(document).ready(function(){        
        function startTimer(duration, display) {
            var timer = duration, minutes, seconds;
            setInterval(function () {
                minutes = parseInt(timer / 60, 10)
                seconds = parseInt(timer % 60, 10);

                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.text(minutes + ":" + seconds);

                if (--timer < 0) {
                    timer = duration;
                }
                var text = $('#time').text()
                if (text == '00:00') {
                  window.close();
                }
            }, 1000);
        }

        jQuery(function ($) {
            var min = 60 * 0.15,
            display = $('#time');                
            startTimer(min, display);

        });        
      })
    </script>
@endsection
