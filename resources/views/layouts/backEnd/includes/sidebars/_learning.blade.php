<div class="main-menu menu-dark menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
          {{-- back --}}
          <li class=" nav-item">
              <a href="{{route('main.dashboard')}}"><i class="la la-undo">
                  </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.main_departments') }}</span>
              </a>
          </li>        
        {{-- dashboard --}}
        <li class=" nav-item {{request()->segment(2)=='dashboard'?'active':''}}">
            <a href="{{route('dashboard.learning')}}"><i class="la la-home">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.dashboard') }}</span>
            </a>
        </li> 
        {{-- playlists --}}
        <li class=" nav-item {{request()->segment(2)=='playlists'?'active':''}}">
            <a href="{{route('playlists.index')}}"><i class="la la-youtube-play">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('learning::local.playlists') }}</span>
            </a>
        </li>     
        {{-- lessons --}}
        <li class=" nav-item {{request()->segment(2)=='lessons'?'active':''}}">
            <a href="{{route('lessons.index')}}"><i class="la la-book">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('learning::local.lessons') }}</span>
            </a>
        </li> 
        {{-- exams --}}
        <li class=" nav-item {{request()->segment(2)=='exams'?'active':''}}">
            <a href="{{route('exams.index')}}"><i class="la la-tasks">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('learning::local.exams') }}</span>
            </a>
        </li>            
        {{-- employees --}}
        {{-- <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}"><a href="#">
            <i class="la la-users"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('staff::local.employees') }}</span></a>
            <ul class="menu-content">                
                <li class=" nav-item {{request()->segment(2)=='employees'?'active':''}}">
                    <a href="{{route('employees.index')}}"><i class="la la-database">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.employees_data') }}</span>
                    </a>
                </li>
                <li class=" nav-item {{request()->segment(2)=='advanced-search'?'active':''}}">
                    <a href="{{route('employees.advanced-search')}}"><i class="la la-search">
                        </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('staff::local.advanced_search') }}</span>
                    </a>
                </li>  

            </ul>
        </li>    --}}
     
        {{-- settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}"><a href="#"><i class="la la-gears"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">                                                 
                <li class="{{request()->segment(3)=='subjects'?'active':''}}"><a class="menu-item" href="{{route('subjects.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('learning::local.subjects') }}</a></li>                         
                <li class="{{request()->segment(3)=='student-subjects'?'active':''}}"><a class="menu-item" href="{{route('student-subjects.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('learning::local.student_subjects') }}</a></li>                                         
                <li class="{{request()->segment(3)=='teacher-subjects'?'active':''}}"><a class="menu-item" href="{{route('teacher-subjects.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('learning::local.teacher_subject') }}</a></li>                         
                <li class="{{request()->segment(3)=='teacher-classes'?'active':''}}"><a class="menu-item" href="{{route('teacher-classes.index')}}" ><i class="la la-angle-{{session('lang') =='ar' ?'left':'right'}}"></i> {{ trans('learning::local.teacher_classes') }}</a></li>                         
                
            </ul>
        </li>                                                      
      </ul>
    </div>
  </div>
