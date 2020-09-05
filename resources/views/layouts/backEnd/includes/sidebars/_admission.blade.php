<div class="main-menu menu-dark menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        {{-- dashboard --}}
        <li class=" nav-item {{request()->segment(2)=='dashboard'?'active':''}}">
            <a href="{{route('dashboard.admission')}}"><i class="la la-home">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.dashboard') }}</span>
            </a>
        </li>
        {{-- dashboard --}}
        <li class=" nav-item">
            <a href="{{route('main.dashboard')}}"><i class="la la-undo">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.main_departments') }}</span>
            </a>
        </li>        
        {{-- internal addmissions --}}

        <li class=" nav-item {{request()->segment(2)=='parents'?'active':''}}">
            <a href="{{route('parents.index')}}"><i class="la la-users">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.parents') }}</span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='students'?'active':''}}">
            <a href="{{route('students.index')}}"><i class="la la-graduation-cap">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students') }}</span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='guardians'?'active':''}}">
            <a href="{{route('guardians.index')}}"><i class="la la-male">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.guardians') }}</span>
            </a>
        </li>  
        <li class=" nav-item {{request()->segment(2)=='meetings'?'active':''}}">
            <a href="{{route('meetings.index')}}"><i class="la la-calendar-check-o">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.interviews_dates') }}</span>
            </a>
        </li>   
        <li class=" nav-item {{request()->segment(2)=='parent-reports'?'active':''}}">
            <a href="{{route('parent-reports.index')}}"><i class="la la-commenting">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.parent_reports') }}</span>
            </a>
        </li> 
        <li class=" nav-item {{request()->segment(2)=='meetings'?'active':''}}">
            <a href="{{route('student-reports.index')}}"><i class="la la-commenting">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.student_reports') }}</span>
            </a>
        </li> 
        {{-- settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}"><a href="#"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">
            <li class="{{request()->segment(3)=='years'?'active':''}}"><a class="menu-item" href="{{route('years.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.academic_years') }}</a></li>           
            <li class="{{request()->segment(3)=='divisions'?'active':''}}"><a class="menu-item" href="{{route('divisions.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.divisions') }}</a></li>           
            <li class="{{request()->segment(3)=='grades'?'active':''}}"><a class="menu-item" href="{{route('grades.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.grades') }}</a></li>           
            <li class="{{request()->segment(3)=='admission-documents'?'active':''}}"><a class="menu-item" href="{{route('admission-documents.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.admission_documents') }}</a></li>           
            <li class="{{request()->segment(3)=='documents-grades'?'active':''}}"><a class="menu-item" href="{{route('documents-grades.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.grade_documents') }}</a></li>           
            <li class="{{request()->segment(3)=='steps'?'active':''}}"><a class="menu-item" href="{{route('steps.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.admission_steps') }}</a></li>           
            <li class="{{request()->segment(3)=='acceptance-tests'?'active':''}}"><a class="menu-item" href="{{route('acceptance-tests.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.acceptance_tests') }}</a></li>           
            <li class="{{request()->segment(3)=='registration-status'?'active':''}}"><a class="menu-item" href="{{route('registration-status.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.registration_status') }}</a></li>           
            <li class="{{request()->segment(3)=='nationalities'?'active':''}}"><a class="menu-item" href="{{route('nationalities.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.nationalities') }}</a></li>           
            <li class="{{request()->segment(3)=='interviews'?'active':''}}"><a class="menu-item" href="{{route('interviews.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.interviews') }}</a></li>           
            <li class="{{request()->segment(3)=='languages'?'active':''}}"><a class="menu-item" href="{{route('languages.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.languages') }}</a></li>           
            <li class="{{request()->segment(3)=='classrooms'?'active':''}}"><a class="menu-item" href="{{route('classrooms.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.classrooms') }}</a></li>           
            <li class="{{request()->segment(3)=='id-designs'?'active':''}}"><a class="menu-item" href="{{route('id-designs.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.id_designs') }}</a></li>           
            <li class="{{request()->segment(3)=='schools'?'active':''}}"><a class="menu-item" href="{{route('schools.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.schools_names') }}</a></li>           
            </ul>
        </li>        

          
      </ul>
    </div>
  </div>
