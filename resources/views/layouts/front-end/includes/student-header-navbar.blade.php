<div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
role="navigation" data-menu="menu-wrapper">
<div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
  <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
    {{-- dashboard --}}
    <li class="dropdown nav-item">
      <a class="nav-link" href="{{route('student.dashboard')}}"><i class="la la-home"></i>
        <span>{{ trans('admin.dashboard') }}</span>
      </a>
    </li>
    {{-- subjects --}}
    <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('student.subjects')}}"><i class="la la-book"></i>
            <span>{{ trans('student.subjects') }}</span>
        </a>
    </li>  

    {{-- homeworks --}}
    <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('internal-regulations.teacher')}}"><i class="la la-eyedropper"></i>
            <span>{{ trans('student.homeworks') }}</span>
        </a>
    </li>      
    
    {{-- exams --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-tasks"></i>
        <span>{{ trans('student.exams') }}</span></a>
        <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="{{route('student.upcoming-exams')}}" data-toggle="dropdown"><i class="la 
                la-bullhorn"></i> {{ trans('student.upcoming_exams') }}</a></li>           
            <li data-menu=""><a class="dropdown-item" href="{{route('student.exams')}}" data-toggle="dropdown"><i class="la la-certificate"></i> {{ trans('student.my_exams') }}</a></li>                            
        </ul>
    </li>

    {{-- live --}}
    <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('internal-regulations.teacher')}}"><i class="la la-youtube-play"></i>
            <span>{{ trans('student.live') }}</span>
        </a>
    </li> 

    {{-- library --}}
    <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('internal-regulations.teacher')}}"><i class="la la-bank"></i>
            <span>{{ trans('student.library') }}</span>
        </a>
    </li>     



  </ul>
</div>
</div>