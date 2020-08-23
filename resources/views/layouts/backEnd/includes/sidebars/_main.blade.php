<div class="main-menu menu-dark menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        {{-- dashboard --}}
        <li class=" nav-item {{request()->segment(2)=='dashboard'?'active':''}}">
            <a href="{{route('main.dashboard')}}"><i class="la la-home">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.dashboard') }}</span>
            </a>
        </li>
        {{-- user accounts --}}
        <li class=" nav-item {{request()->segment(2)=='accounts'?'active':''}}">
            <a target="blank" href="{{route('accounts.index')}}"><i class="la la-users">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.users_accounts') }}</span>
            </a>
        </li>
        {{-- main-settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}">
            <a target="blank" href="{{route('site.settings')}}"><i class="la la-gear">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.settings') }}</span>
            </a>
        </li>
        {{-- admissions --}}
        <li class=" nav-item {{request()->segment(2)=='admissions'?'active':''}}">
            <a target="blank" href="{{route('dashboard.admission')}}"><i class="la la-folder">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.admissions') }}</span>
            </a>
        </li>
        {{-- students --}}
        <li class=" nav-item {{request()->segment(2)=='students'?'active':''}}">
            <a target="blank" href="{{route('site.settings')}}"><i class="la la-folder">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_affairs') }}</span>
            </a>
        </li>      
        {{-- students fees --}}
        <li class=" nav-item {{request()->segment(2)=='students'?'active':''}}">
            <a target="blank" href="{{route('site.settings')}}"><i class="la la-folder">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.students_fees') }}</span>
            </a>
        </li>            
        {{-- bus --}}
        <li class=" nav-item {{request()->segment(2)=='buses'?'active':''}}">
            <a target="blank" href="{{route('site.settings')}}"><i class="la la-folder">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.bus') }}</span>
            </a>
        </li>  
        {{-- school control --}}
        <li class=" nav-item {{request()->segment(2)=='school_controls'?'active':''}}">
            <a target="blank" href="{{route('site.settings')}}"><i class="la la-folder">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.school_control') }}</span>
            </a>
        </li>        
        {{-- hr --}}
        <li class=" nav-item {{request()->segment(2)=='hr'?'active':''}}">
            <a target="blank" href="{{route('site.settings')}}"><i class="la la-folder">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.hr') }}</span>
            </a>
        </li>             
      </ul>
    </div>
  </div>
