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
        <li class=" nav-item {{request()->segment(2)=='parents'?'active':''}}"><a href="#"><i class="la la-exchange"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.internal_admission') }}</span></a>
            <ul class="menu-content">
            <li class="{{request()->segment(2)=='parents'?'active':''}}"><a class="menu-item" href="{{route('parents.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.parents') }}</a></li>           
            <li class="{{request()->segment(2)=='applicants'?'active':''}}"><a class="menu-item" href="{{route('applicants.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.applicants') }}</a></li>           
            {{-- <li class="{{request()->segment(2)=='students'?'active':''}}"><a class="menu-item" href="{{route('students.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.students') }}</a></li>            --}}
            </ul>
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
            </ul>
        </li>        

          
      </ul>
    </div>
  </div>
