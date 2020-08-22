<div class="main-menu menu-dark menu-fixed menu-light menu-accordion    menu-shadow " data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        {{-- dashboard --}}
        <li class=" nav-item {{request()->segment(2)=='dashboard'?'active':''}}">
            <a href="{{route('main.dashboard')}}"><i class="la la-home">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.dashboard') }}</span>
            </a>
        </li>
        {{-- website --}}
        <li class=" nav-item">
            <a target="blank" href="{{route('home')}}"><i class="la la-globe">
                </i><span class="menu-title" data-i18n="nav.support_raise_support.main">{{ trans('admin.website') }}</span>
            </a>
        </li>
        {{-- accounts --}}
        <li class=" nav-item"><a href="#"><i class="la la-users"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.accounts') }}</span></a>
            <ul class="menu-content">
                <li class="{{request()->segment(2)=='accounts'?'active':''}}"><a class="menu-item" href="{{route('accounts.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.admin_accounts') }}</a></li>
                {{-- <li class="{{request()->segment(2)=='users'?'active':''}}"><a class="menu-item" href="{{route('users.index')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.users_accounts') }}</a></li> --}}
            </ul>
        </li>

        {{-- settings --}}
        <li class=" nav-item"><a href="#"><i class="la la-gear"></i><span class="menu-title" data-i18n="nav.dash.main">{{ trans('admin.settings') }}</span></a>
            <ul class="menu-content">
            <li class="{{request()->segment(3)=='countries'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.countries') }}</a></li>
            <li class="{{request()->segment(3)=='cities'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.cities') }}</a></li>
            <li class="{{request()->segment(3)=='states'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.states') }}</a></li>
            <li class="{{request()->segment(3)=='categories'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.categories') }}</a></li>
            <li class="{{request()->segment(3)=='departments'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.departments') }}</a></li>
            <li class="{{request()->segment(3)=='specifications'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.specifications') }}</a></li>
            <li class="{{request()->segment(3)=='definitions'?'active':''}}"><a class="menu-item" href="{{route('main.dashboard')}}" data-i18n="nav.dash.ecommerce">{{ trans('admin.definitions') }}</a></li>
            </ul>
        </li>
      </ul>
    </div>
  </div>
