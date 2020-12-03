@extends('layouts.backEnd.teacher')
@section('content')

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
                    <tbody>   
                        @php
                            $n=1;
                        @endphp                 
                        @foreach ($classes as $class)    
                            <tr>
                                <td>
                                    {{session('lang') == 'ar' ? $class->classroom->ar_name_classroom : $class->classroom->en_name_classroom}}
                                </td>
                                <td>
                                    <span class="blue">{{\Carbon\Carbon::parse( $class->start_date)->format('M d Y')}}<br>
                                        {{\Carbon\Carbon::parse( $class->start_time)->format('h:i a')}}
                                    </span>
                                </td>
                                <td>{!!startVirtualClass($class->start_date, $class->start_time)!!}</td>
                            </tr>
                            @php
                                $n++;
                            @endphp
                        @endforeach                     
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
                <tbody>                    
                    @foreach ($announcements as $announcement)    
                        <tr>
                            <td>
                                {!!$announcement->announcement!!}
                                <br>
                                {{session('lang') == 'ar' ? $announcement->admin->ar_name : $announcement->admin->name}} | 
                                <span style="font-size: 12px;">{{$announcement->updated_at->diffForHumans()}}</span>       
                            </td>
                        </tr>
                    @endforeach                     
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
                  <i class="icon-pencil font-large-2 text-white"></i>
                </div>
                <div class="media-body p-2">
                  <h4 id="classroom">Classroom</h4>
                  <span>{{ trans('staff::local.next_class') }}</span>
                </div>
                <div class="media-right p-2 media-middle">
                  <h1 class="info">
                    <div id="clockdiv">
                        <span class="hours"></span> :
                        <span class="minutes"></span> :
                        <span class="seconds"></span>                                      
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
                    <tbody>                    
                        <tr>
                            <td width="60"> <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                                src="{{asset('images/studentsImages/37.jpeg')}}" />
                            </td>    
                            <td>Amr Ali <br> 3-12-2020</td>
                        </tr> 
                        <tr>
                            <td width="60"> <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                                src="{{asset('images/studentsImages/37.jpeg')}}" />
                            </td>    
                            <td>Amr Ali <br> 3-12-2020</td>
                        </tr>  
                        <tr>
                            <td width="60"> <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                                src="{{asset('images/studentsImages/37.jpeg')}}" />
                            </td>    
                            <td>Amr Ali <br> 3-12-2020</td>
                        </tr> 
                        <tr>
                            <td width="60"> <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                                src="{{asset('images/studentsImages/37.jpeg')}}" />
                            </td>    
                            <td>Amr Ali <br> 3-12-2020</td>
                        </tr>  
                        <tr>
                            <td width="60"> <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                                src="{{asset('images/studentsImages/37.jpeg')}}" />
                            </td>    
                            <td>Amr Ali <br> 3-12-2020</td>
                        </tr> 
                        <tr>
                            <td width="60"> <img class=" editable img-responsive student-image" alt="" id="avatar2" 
                                src="{{asset('images/studentsImages/37.jpeg')}}" />
                            </td>    
                            <td>Amr Ali <br> 3-12-2020</td>
                        </tr>                                           
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
        $(document).ready(function(){
        
            var time = 10000;

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
            const deadline = new Date(Date.parse(new Date()) + time);

            initializeClock('clockdiv', deadline);                        
        })
    </script>
@endsection