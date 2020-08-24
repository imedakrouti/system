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
        <li class=" nav-item"><a href="#"><i class="la la-exchange"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.internal_admission') }}</span></a>
            <ul class="menu-content">
            <li class="{{request()->segment(3)=='countries'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.parents') }}</a></li>           
            <li class="{{request()->segment(3)=='countries'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.applicants') }}</a></li>           
            </ul>
        </li>
        {{-- settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}"><a href="#"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">
            <li class="{{request()->segment(3)=='years'?'active':''}}"><a class="menu-item" href="{{route('years.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.academic_years') }}</a></li>           
            <li class="{{request()->segment(3)=='divisions'?'active':''}}"><a class="menu-item" href="{{route('divisions.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.divisions') }}</a></li>           
            <li class="{{request()->segment(3)=='grades'?'active':''}}"><a class="menu-item" href="{{route('grades.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.grades') }}</a></li>           
            <li class="{{request()->segment(3)=='admission-documents'?'active':''}}"><a class="menu-item" href="{{route('admission-documents.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.admission_documents') }}</a></li>           
            <li class="{{request()->segment(3)=='countries'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.grade_documents') }}</a></li>           
            <li class="{{request()->segment(3)=='countries'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.admission_steps') }}</a></li>           
            <li class="{{request()->segment(3)=='countries'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.acceptance_tests') }}</a></li>           
            </ul>
        </li>        

          
      </ul>
    </div>
  </div>
