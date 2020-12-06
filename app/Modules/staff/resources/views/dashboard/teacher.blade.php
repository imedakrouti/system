@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-2">
    <h3 class="content-header-title">{{ trans('admin.dashboard') }}</h3>
  </div>
</div>
<div class="row">
    <div class="col-lg-12 mb-1">
        <img src="{{asset('images/website/code.png')}}" width="100%" alt="cover">           
    </div>
</div> 

<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-info bg-darken-2 rounded-left">
              <i class="la la-graduation-cap font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-gradient-x-info text-white media-body rounded-right">
              <h5 class="text-white">{{ trans('staff::local.students') }}</h5>
              <h5 class="text-white text-bold-400 mb-0">{{$students}}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-danger bg-darken-2 rounded-left">
              <i class="la la-group font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-gradient-x-danger text-white media-body rounded-right">
              <h5 class="text-white">{{ trans('staff::local.classrooms') }}</h5>
              <h5 class="text-white text-bold-400 mb-0">{{$classrooms}}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-success bg-darken-2 rounded-left">
              <i class="la la-comment font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-gradient-x-success text-white media-body rounded-right">
              <h5 class="text-white">{{ trans('staff::local.posts') }}</h5>
              <h5 class="text-white text-bold-400 mb-0">{{$posts}}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
      <div class="card">
        <div class="card-content">
          <div class="media align-items-stretch">
            <div class="p-2 text-center bg-warning bg-darken-2 rounded-left">
              <i class="la la-book font-large-2 text-white"></i>
            </div>
            <div class="p-2 bg-gradient-x-warning text-white media-body rounded-right">
              <h5 class="text-white">{{ trans('staff::local.lessons') }}</h5>
              <h5 class="text-white text-bold-400 mb-0">{{$lessons}}</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 col-md-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">            
                <h4><strong>{{ trans('staff::local.today_virtual_classes') }}</strong></h4>              
                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ trans('staff::local.classrooms') }}</th>
                            <th>{{ trans('staff::local.date_time') }}</th>
                            <th>{{ trans('staff::local.start') }}</th>
                        </tr>
                    </thead>
                    <tbody id="schedule">   
                                    
                    </tbody>
                </table>                
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">                          
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ trans('staff::local.admin_message') }}</th>
                    </tr>
                </thead>
                <tbody id="announcements">                    
                    
                </tbody>
            </table>                
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-5 col-md-12">
        {{-- next virtual class --}}
        <div class="card overflow-hidden">
            <div class="card-content">
              <div class="media align-items-stretch">
                <div class="bg-info p-2 media-middle">
                  <i class="la la-video-camera font-large-2 text-white"></i>
                </div>
                <div class="media-body p-2">
                  <h4 id="classroom">{{ trans('admin.virtual_classrooms') }}</h4>
                  <span>{{ trans('staff::local.next_class') }}</span>
                </div>
                <div class="media-right p-2 media-middle">
                  <h1 class="info">
                    <div id="clockdiv">
                        <span class="hours">00</span> :
                        <span class="minutes">00</span> :
                        <span class="seconds">00</span>                                      
                    </div>                       
                  </h1>
                </div>
              </div>
            </div>
        </div>
        {{-- delver homework --}}
        <div class="card">
            <div class="card-content collapse show">
              <div class="card-body card-dashboard">
                {{-- get last 10 students deliverd homework --}}
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="2">{{ trans('staff::local.today_deliver_homework') }}</th>
                        </tr>
                    </thead>
                    <tbody id="homeworks">                    
                                          
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
      
        nextVirtualClassroom();
        announcements();
        homeworks();

        function getTimeRemaining(endtime) {
            const total = Date.parse(endtime) - Date.parse(new Date());
            const seconds = Math.floor((total / 1000) % 60);
            const minutes = Math.floor((total / 1000 / 60) % 60);
            const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
            const days = Math.floor(total / (1000 * 60 * 60 * 24));
            
            return {
                total,
                days,
                hours,
                minutes,
                seconds
            };
        }

        function initializeClock(id, endtime) {
            const clock = document.getElementById(id);            
            const hoursSpan = clock.querySelector('.hours');
            const minutesSpan = clock.querySelector('.minutes');
            const secondsSpan = clock.querySelector('.seconds');

            function updateClock() {
                const t = getTimeRemaining(endtime);

                hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
                minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
                secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

                if (t.total <= 0) {
                clearInterval(timeinterval);
                }
            }

            updateClock();
            const timeinterval = setInterval(updateClock, 1000);
        }
              
        function nextVirtualClassroom()
        {
          $.ajax({
                type:'get',
                url:'{{route("next-virtual-classroom")}}',
                dataType:'json',
                success:function(data){
                  if (data.time != 0) {
                    const deadline = new Date(Date.parse(new Date()) + data.time);
                    initializeClock('clockdiv', deadline);                   
  
                    $('#classroom').html(data.classroom);
                    $('#schedule').html(data.schedule);                                      
                  }
                }
            });
                  
        }

        function schedule()
        {
          $.ajax({
                type:'get',
                url:'{{route("next-virtual-classroom")}}',
                dataType:'json',
                success:function(data){
                  $('#schedule').html(data.schedule);   
                  if (data.time != 0) {
                    nextVirtualClassroom();                    
                  }else{
                    $('#clockdiv').html('00 : 00 : 00')
                  }               
                }
            }); 
        }

        setInterval(function()
        {
          let hours = $('.hours').text();
          let minutes = $('.minutes').text();
          let seconds = $('.seconds').text();
   
          if (hours == '00' && minutes == '00' && seconds == '00') {            
            schedule()
          }
        },5000); //1000 second

        function announcements()
        {
          $.ajax({
                type:'get',
                url:'{{route("announcements")}}',
                dataType:'json',
                success:function(data){
                  $('#announcements').html(data);   
                             
                }
            });  
        }

        function homeworks()
        {
          $.ajax({
                type:'get',
                url:'{{route("dashboard-homeworks")}}',
                dataType:'json',
                success:function(data){
                  $('#homeworks').html(data);   
                             
                }
            });  
        }

        setInterval(function()
        {
          announcements();
          homeworks();
          schedule()  
        },60000); //1000 second
                
    </script>
@endsection