<div class="navbar-header">
    <ul class="nav navbar-nav flex-row">
      <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
      <li class="nav-item">
        <a class="navbar-brand" href="{{route('home')}}">
        <img class="brand-logo" alt="modern admin logo" src="{{asset('cpanel/app-assets/images/logo/logo.png')}}">
          <h3 class="brand-text">{{session('lang')=='ar' || session('lang') == trans('admin.ar') ? settingHelper()->siteNameArabic :settingHelper()->siteNameEnglish}}</h3>
        </a>
      </li>
      <li class="nav-item d-md-none">
        <a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="la la-ellipsis-v"></i></a>
      </li>
    </ul>
  </div>
