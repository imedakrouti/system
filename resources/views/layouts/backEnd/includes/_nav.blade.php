<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item ">
            <a class="navbar-brand" href="{{route('main.dashboard')}}">
              @isset(settingHelper()->logo)
                <img class="brand-logo" alt="logo" src="{{asset('images/website/'.settingHelper()->logo)}}">                  
              @endisset
              @empty(settingHelper()->logo)
                <img class="brand-logo" alt="logo" src="{{asset('images/website/logo.png')}}">                  
              @endempty
            <h4 class="brand-text">{{session('lang') == 'ar' || session('lang') == trans('admin.ar') ?settingHelper()->ar_school_name:settingHelper()->en_school_name}}</h4>
            </a>
          </li>
          <li class="nav-item d-md-none">
            <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
          </li>
        </ul>
      </div>
      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
          </ul>
          <ul class="nav navbar-nav float-right">

            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown" id="count"><i class="ficon ft-bell"></i>
                {{-- <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">5</span> --}}
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">{{ trans('admin.notifications') }}</span>
                  </h6>                  
                </li>
                <li class="scrollable-container media-list w-100"  id="notifications">

                </li>
                <li class="dropdown-menu-footer" id="view">
                  <a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a>
                </li>
              </ul>
            </li>

            {{-- modules --}}
              <li class="dropdown dropdown-user nav-item">
                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                    <span class="mr-1">
                        <span class="user-name text-bold-700">{{ trans('admin.administrative_departments') }}</span>
                    </span>
                    <span class="avatar avatar-online">
                        <img src="{{asset('images/website/department.png')}}" alt="avatar">
                    </span>
                </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{route('dashboard.admission')}}"><i class="la la-graduation-cap"></i>{{ trans('admin.students_affairs') }}</a>
                <a class="dropdown-item" href="{{route('dashboard.staff')}}"><i class="ft-user"></i>{{ trans('admin.hr') }}</a>                
              </div>
            </li>
            {{-- end modules --}}

            <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                @if (session('lang') == 'ar' || session('lang') == trans('admin.ar'))
                <i class="flag-icon flag-icon-eg"></i>
                @else
                <i class="flag-icon flag-icon-gb"></i>
                @endif
                <span class="selected-language"></span></a>
                <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                    <a class="dropdown-item" href="{{aurl('lang/ar')}}"><i class="flag-icon flag-icon-eg"></i> العربية</a>
                    <a class="dropdown-item" href="{{aurl('lang/en')}}"><i class="flag-icon flag-icon-gb"></i> English</a>
                </div>
            </li>

            {{-- user --}}
            <li class="dropdown dropdown-user nav-item">
                <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                    <span class="mr-1">{{ trans('admin.hello') }},
                        <span class="user-name text-bold-700">{{authInfo()->name}}</span>
                    </span>
                    <span class="avatar avatar-online">
                      @isset(authInfo()->image_profile)
                        <img src="{{asset('images/imagesProfile/'.authInfo()->image_profile)}}" alt="avatar">                          
                      @endisset
                      @empty(authInfo()->image_profile)                          
                        <img src="{{asset('images/website/male.png')}}" alt="avatar">                          
                      @endempty
                    </span>

                </a>
              <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{ route('site.settings') }}"><i class="ft-settings"></i>{{ trans('admin.settings') }}</a>
                <a class="dropdown-item" href="{{route('user-profile')}}"><i class="ft-user"></i>{{ trans('admin.profile') }}</a>
                <a class="dropdown-item" href="{{route('accounts.index')}}"><i class="ft-users"></i> {{ trans('admin.users_accounts') }}</a>
                <a class="dropdown-item" href="{{aurl('password')}}"><i class="ft-lock"></i> {{ trans('admin.change_password') }}</a>
                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('logout')}}"><i class="ft-power"></i> {{ trans('admin.logout') }}</a>
              </div>
            </li>



          </ul>
        </div>
      </div>
    </div>
  </nav>
