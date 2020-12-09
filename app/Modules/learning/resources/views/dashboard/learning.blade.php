@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">      
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>            
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
{{-- statistics --}}
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
            <h5 class="text-white text-bold-400 mb-0">{{$teachers}}</h5>
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

{{-- virtual classrooms & recent lessons --}}
<div class="row">
  {{-- virtual classrooms --}}
  <div class="col-lg-7 col-md-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body card-dashboard"> 
          <div class="table-responsive">
              <h4><strong>{{ trans('staff::local.today_virtual_classes') }}</strong> | {{\Carbon\Carbon::today()->format('d-m-Y')}}
                <span class="small {{session('lang') == 'ar'?'pull-left':'pull-right'}}">
                  <a href="{{route('virtual-classrooms.page')}}">{{ trans('learning::local.view_all') }}</a></span>
              </h4>              
              
              <table class="table table-hover">
                  <thead>
                      <tr class="center">
                          <th colspan="2">{{ trans('learning::local.teacher_name') }}</th>
                          <th>{{ trans('staff::local.classrooms') }}</th>
                          <th>{{ trans('learning::local.subject') }}</th>
                          <th>{{ trans('learning::local.time') }}</th>
                          <th>{{ trans('staff::local.start') }}</th>
                      </tr>
                  </thead>
                  <tbody id="schedule" class="center">   
                                  
                  </tbody>
              </table>                              
          </div>           
        </div>
      </div>      
    </div>
  </div>

  {{-- recent lessons --}}
  <div class="col-lg-5 col-md-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body card-dashboard"> 
          <div class="table-responsive">
              <h4><strong>{{ trans('learning::local.recent_lessons') }}</strong>
                <span class="small {{session('lang') == 'ar'?'pull-left':'pull-right'}}">
                  <a href="{{route('lessons.index')}}">{{ trans('learning::local.view_all') }}</a></span>
              </h4>              
              <table class="table table-hover">
                  <thead>
                      <tr>
                          <th>{{ trans('learning::local.lesson_title') }}</th>
                          <th>{{ trans('learning::local.subject') }}</th>                          
                      </tr>
                  </thead>
                  <tbody id="lessons">   
                                  
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
        virtualClassrooms();
        recentLessons();

        function virtualClassrooms()
        {
          $.ajax({
                type:'get',
                url:'{{route("dashboard.virtual-classrooms")}}',
                dataType:'json',
                success:function(data){
                  $('#schedule').html(data.schedule);
                }
            });
                  
        }
        

        function recentLessons()
        {
          $.ajax({
                type:'get',
                url:'{{route("dashboard.recent-lessons")}}',
                dataType:'json',
                success:function(data){
                  $('#lessons').html(data);
                }
            });
                  
        }
    </script>
@endsection
