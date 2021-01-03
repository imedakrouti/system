<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
role="navigation" data-menu="menu-wrapper">
<div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
  <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
    {{-- dashboard --}}
    <li class="dropdown nav-item">
      <a class="nav-link" href="{{route('dashboard.teacher')}}"><i class="la la-home"></i>
        <span>{{ trans('admin.dashboard') }}</span>
      </a>
    </li>
 
    {{-- my account human resource--}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-user"></i>
        <span>{{ trans('staff::local.my_account') }}</span></a>
      <ul class="dropdown-menu">
        <li data-menu=""><a class="dropdown-item" href="{{route('internal-regulations.teacher')}}" data-toggle="dropdown"><i class="la la-warning"></i> {{ trans('staff::local.internal_regulation') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.attendance')}}" data-toggle="dropdown"><i class="la la-clock-o"></i> {{ trans('staff::local.my_attendance') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.permissions')}}" data-toggle="dropdown"><i class="la la-road"></i> {{ trans('staff::local.my_permssions') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.vacations')}}" data-toggle="dropdown"><i class="la la-umbrella"></i> {{ trans('staff::local.my_vacation') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.loans')}}" data-toggle="dropdown"><i class="la la-minus-square"></i> {{ trans('staff::local.my_loans') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.deductions')}}" data-toggle="dropdown"><i class="la la-gavel"></i> {{ trans('staff::local.my_deductions') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.payrolls')}}" data-toggle="dropdown"><i class="la la-money"></i> {{ trans('staff::local.my_salries') }}</a></li>        
      </ul>
    </li>

    {{-- classrooms --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-book"></i>
        <span>{{ trans('staff::local.classrooms') }}</span></a>
        <ul class="dropdown-menu">
          @foreach (employeeClassrooms() as $classroom)         
            <li data-menu=""><a class="dropdown-item" href="{{route('students.name-list',$classroom->id)}}" data-toggle="dropdown">
              {{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}</a>
            </li>                                     
          @endforeach   
        </ul>
    </li>  

    {{-- posts --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-share-alt"></i>
        <span>{{ trans('staff::local.posts') }}</span></a>
        <ul class="dropdown-menu">
          @foreach (employeeClassrooms() as $classroom)         
            <li data-menu=""><a class="dropdown-item" href="{{route('posts.index',$classroom->id)}}" data-toggle="dropdown">
              {{session('lang') == 'ar' ? $classroom->ar_name_classroom : $classroom->en_name_classroom}}</a>
            </li>                                     
          @endforeach   
        </ul>
    </li>      

    {{-- e-learning --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-book"></i>
        <span>{{ trans('admin.e_learning') }}</span></a>
      <ul class="dropdown-menu">
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.playlists')}}" data-toggle="dropdown"><i class="la la-youtube-play"></i> {{ trans('learning::local.playlists') }}</a></li>           
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.view-lessons')}}" data-toggle="dropdown"><i class="la la-book"></i> {{ trans('learning::local.lessons') }}</a></li>           
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.view-exams')}}" data-toggle="dropdown"><i class="la la-tasks"></i> {{ trans('learning::local.exams') }}</a></li>           
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.homeworks')}}" data-toggle="dropdown"><i class="la la-eyedropper"></i> {{ trans('learning::local.class_work') }}</a></li>           
      </ul>
    </li>
    
    {{-- virtual classrooms --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-vimeo-square"></i>
      <span>{{ trans('admin.virtual_classrooms') }}</span></a>
    <ul class="dropdown-menu">
      <li data-menu=""><a class="dropdown-item" href="{{route('zoom.account')}}" data-toggle="dropdown"><i class="la la-gear"></i> {{ trans('learning::local.zoom_settings') }}</a></li>           
      <li data-menu=""><a class="dropdown-item" href="{{route('zoom-schedules.view')}}" data-toggle="dropdown"><i class="la la-calendar-check-o"></i> {{ trans('learning::local.view_zoom_schedule') }}</a></li>                          
      <li data-menu=""><a class="dropdown-item" href="{{route('zoom-schedules.index')}}" data-toggle="dropdown"><i class="la la-calendar"></i> {{ trans('learning::local.manage_zoom_schedule') }}</a></li>                          
    </ul>

    {{-- student --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-users"></i>
      <span>{{ trans('admin.students') }}</span></a>
    <ul class="dropdown-menu">
      <li data-menu=""><a class="dropdown-item" href="{{route('absences.index')}}" data-toggle="dropdown"><i class="la la-calendar"></i> {{ trans('learning::local.attendance') }}</a></li>           
      
      <li class="dropdown dropdown-submenu" data-menu="dropdown-submenu">
        <a class="dropdown-item dropdown-toggle" href="#" data-toggle="dropdown"><i class="la la-ban"></i>{{ trans('learning::local.behaviour') }}</a>
        <ul class="dropdown-menu">
          @foreach (employeeClassrooms() as $classroom)
              <li data-menu=""><a class="dropdown-item" href="{{route('behaviour-subjects',['classroom_id'=> $classroom->id,'class_name' => $classroom->class_name])}}"
                 data-toggle="dropdown">{{$classroom->class_name }}</a></li>              
          @endforeach
        </ul>
      </li>
      <li data-menu=""><a class="dropdown-item" href="{{route('zoom-schedules.index')}}" data-toggle="dropdown"><i class="la la-gear"></i> {{ trans('learning::local.manage_reports') }}</a></li>                          
    </ul>
  </li>
  
  </ul>
</div>
</div>