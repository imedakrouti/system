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
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-eyedropper"></i>
        <span>{{ trans('student.homeworks') }}</span></a>
        <ul class="dropdown-menu">            
            <li data-menu=""><a class="dropdown-item" href="{{route('student.homeworks')}}" data-toggle="dropdown"><i class="la la-clock-o"></i> {{ trans('student.available_homeworks') }}</a></li>                            
            <li data-menu=""><a class="dropdown-item" href="{{route('homework.results')}}" data-toggle="dropdown"><i class="la la-check-circle"></i> {{ trans('student.results') }}</a></li>                            
        </ul>
    </li>
    
    {{-- exams --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-tasks"></i>
        <span>{{ trans('student.exams') }}</span></a>
        <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="{{route('student.upcoming-exams')}}" data-toggle="dropdown"><i class="la 
                la-bullhorn"></i> {{ trans('student.upcoming_exams') }}</a></li>           
            <li data-menu=""><a class="dropdown-item" href="{{route('student.exams')}}" data-toggle="dropdown"><i class="la la-certificate"></i> {{ trans('student.available_exams') }}</a></li>                            
            <li data-menu=""><a class="dropdown-item" href="{{route('student.results')}}" data-toggle="dropdown"><i class="la la-check-circle"></i> {{ trans('student.results') }}</a></li>                            
        </ul>
    </li>

    {{-- quzies --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-tasks"></i>
        <span>{{ trans('student.quizzes') }}</span></a>
        <ul class="dropdown-menu">            
            <li data-menu=""><a class="dropdown-item" href="{{route('student.exams')}}" data-toggle="dropdown"><i class="la la-certificate"></i> {{ trans('student.available_exams') }}</a></li>                            
            <li data-menu=""><a class="dropdown-item" href="{{route('student.results')}}" data-toggle="dropdown"><i class="la la-check-circle"></i> {{ trans('student.results') }}</a></li>                            
        </ul>
    </li>

    {{-- live --}}
    <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-vimeo-square"></i>
        <span>{{ trans('student.virtual-classroom') }}</span></a>
        <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="{{route('student.view-schedule')}}" data-toggle="dropdown"><i class="la la-calendar-check-o"></i> {{ trans('student.view_schedule') }}</a></li>                          
      <li data-menu=""><a class="dropdown-item" href="{{route('student.join-classroom')}}" data-toggle="dropdown"><i class="la la-paper-plane"></i> {{ trans('student.join_schedule') }}</a></li>                          
        </ul>
    </li>

    {{-- search --}}
    <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('student.subjects')}}"><i class="la la-search"></i>
            <span>{{ trans('student.search') }}</span>
        </a>
    </li>  

    {{-- library --}}
    {{-- <li class="dropdown nav-item">
        <a class="nav-link" href="{{route('internal-regulations.teacher')}}"><i class="la la-bank"></i>
            <span>{{ trans('student.library') }}</span>
        </a>
    </li>      --}}



  </ul>
</div>
</div>