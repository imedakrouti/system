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
            <a href="{{route('accounts.index')}}"><i class="la la-users">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.users_accounts') }}</span>
            </a>
        </li>
        {{-- main-settings --}}
        <li class=" nav-item {{request()->segment(2)=='settings'?'active':''}}">
            <a href="{{route('site.settings')}}"><i class="la la-gear">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.settings') }}</span>
            </a>
        </li>
        {{-- mobile notification --}}
        <li class=" nav-item {{request()->segment(2)=='students'?'active':''}}">
            <a href="{{route('dashboard.admission')}}"><i class="la la-send">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.mobile_notification') }}</span>
            </a>
        </li>      
        
      </ul>
    </div>
  </div>
