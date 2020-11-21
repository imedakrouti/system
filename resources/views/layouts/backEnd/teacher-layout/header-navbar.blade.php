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
    {{-- internal regulation --}}
    <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('internal-regulations.teacher')}}"><i class="la la-warning"></i>
            <span>{{ trans('staff::local.internal_regulation') }}</span>
        </a>
    </li>    
    {{-- my account --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-user"></i>
        <span>{{ trans('staff::local.my_account') }}</span></a>
      <ul class="dropdown-menu">
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.attendance')}}" data-toggle="dropdown"><i class="la la-clock-o"></i> {{ trans('staff::local.my_attendance') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.permissions')}}" data-toggle="dropdown"><i class="la la-road"></i> {{ trans('staff::local.my_permssions') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.vacations')}}" data-toggle="dropdown"><i class="la la-umbrella"></i> {{ trans('staff::local.my_vacation') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.loans')}}" data-toggle="dropdown"><i class="la la-minus-square"></i> {{ trans('staff::local.my_loans') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.deductions')}}" data-toggle="dropdown"><i class="la la-gavel"></i> {{ trans('staff::local.my_deductions') }}</a></li>
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.payrolls')}}" data-toggle="dropdown"><i class="la la-money"></i> {{ trans('staff::local.my_salries') }}</a></li>        
      </ul>
    </li>

    {{-- e-learning --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-book"></i>
        <span>{{ trans('admin.e_learning') }}</span></a>
      <ul class="dropdown-menu">
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.playlists')}}" data-toggle="dropdown"><i class="la la-youtube-play"></i> {{ trans('learning::local.playlists') }}</a></li>           
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.view-lessons')}}" data-toggle="dropdown"><i class="la la-book"></i> {{ trans('learning::local.lessons') }}</a></li>           
        <li data-menu=""><a class="dropdown-item" href="{{route('teacher.view-exams')}}" data-toggle="dropdown"><i class="la la-tasks"></i> {{ trans('learning::local.exams') }}</a></li>           
      </ul>
    </li>

  </ul>
</div>
</div>