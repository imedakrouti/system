<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
  <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="PIXINVENT">
  <title>
    {{session('lang') == 'ar' || session('lang') == trans('admin.ar') ?settingHelper()->ar_school_name:settingHelper()->en_school_name}}
  </title>
  <link rel="apple-touch-icon" href="{{asset('cpanel/app-assets/images/ico/apple-icon-120.png')}}">
  {{-- <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico"> --}}
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  @yield('styles')

  @if (session('lang') == trans('admin.ar') || session('lang') == 'ar')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/vendors.css')}}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/app.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/custom-rtl.css')}}">
  @else
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/vendors.css')}}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/app.css')}}">
  {{-- <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/custom.css')}}"> --}}
  @endif
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/forms/selects/select2.min.css')}}">

  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->

  @if (session('lang') == trans('admin.ar') || session('lang') == 'ar')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/colors/palette-gradient.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/colors/palette-callout.css')}}">
  @else
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/core/colors/palette-gradient.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/core/colors/palette-callout.css')}}">
  @endif

  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/cryptocoins/cryptocoins.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/fonts/line-awesome/css/line-awesome.min.css')}}">
  {{-- sweet alert style --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->

  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/fonts/simple-line-icons/style.min.css')}}">
  @if (session('lang') == trans('admin.ar') || session('lang') == 'ar')
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/assets/css/style-rtl.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
  @else
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/assets/css/style.css')}}">
  @endif
  <!-- END Custom CSS-->
  @if (session('lang') == trans('admin.ar') || session('lang') == 'ar')
    <style>
        body,h1,h2,h3,h4,h5,h6,a,li,p,span {font-family: 'Cairo', sans-serif;}

      .sweet-alert h2 {font-family: 'Cairo', sans-serif;font-weight: 500;}
      .sweet-alert p {font-family: 'Cairo', sans-serif;}
      .sweet-alert button {font-family: 'Cairo', sans-serif;}
      .sweet-alert {font-family: 'Cairo', sans-serif;}
    </style>
  @endif
  @yield('map')
  <style>
            .se-pre-con {
          position: fixed;
          left: 0px;
          top: 0px;
          width: 100%;
          height: 100%;
          z-index: 9999;
          background: url("{{url('cpanel/app-assets/loader-64x/4.gif')}}") center no-repeat #fff;        }
          .message{
          position: absolute;width: 100%;height: 50px;background-color: #11c011;color: white;line-height: 50px;
          z-index: 1200;text-align: center;opacity: 1;top: -50px ;
      }
  </style>
</head>
<body class="horizontal-layout horizontal-menu horizontal-menu-padding content-detached-right-sidebar   menu-expanded"
data-open="click" data-menu="horizontal-menu" data-col="content-detached-right-sidebar" >
<div class="se-pre-con"></div>
  <!-- fixed-top-->
  <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow navbar-static-top navbar-light navbar-brand-center">
    <div class="navbar-wrapper">
      <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
          <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
          <li class="nav-item">
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
      <div class="navbar-container container center-layout">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>   
          </ul>
          <ul class="nav navbar-nav float-right">
            <li class="dropdown dropdown-user nav-item">
              <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                <span class="mr-1">{{ trans('admin.hello') }},
                    {{session('lang') == 'ar'? authInfo()->ar_name : authInfo()->name}}  
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
                <a class="dropdown-item" href="{{route('teacher.account')}}"><i class="ft-user"></i>{{ trans('admin.profile') }}</a>
                <a class="dropdown-item" href="{{route('teacher.password')}}"><i class="ft-lock"></i> {{ trans('admin.change_password') }}</a>                
                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('logout')}}"><i class="ft-power"></i> {{ trans('admin.logout') }}</a>
              </div>
            </li>
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
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-bell"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">5</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Notifications</span>
                  </h6>
                  <span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                </li>
                <li class="scrollable-container media-list w-100">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-plus-square icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">You have new order!</h6>
                        <p class="notification-text font-small-3 text-muted">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">30 minutes ago</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-download-cloud icon-bg-circle bg-red bg-darken-1"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading red darken-1">99% Server load</h6>
                        <p class="notification-text font-small-3 text-muted">Aliquam tincidunt mauris eu risus.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Five hour ago</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-alert-triangle icon-bg-circle bg-yellow bg-darken-3"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading yellow darken-3">Warning notifixation</h6>
                        <p class="notification-text font-small-3 text-muted">Vestibulum auctor dapibus neque.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-check-circle icon-bg-circle bg-cyan"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">Complete the task</h6>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last week</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                      <div class="media-body">
                        <h6 class="media-heading">Generate monthly report</h6>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Last month</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all notifications</a></li>
              </ul>
            </li>
            <li class="dropdown dropdown-notification nav-item">
              <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon ft-mail">             </i></a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                  <h6 class="dropdown-header m-0">
                    <span class="grey darken-2">Messages</span>
                  </h6>
                  <span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>
                </li>
                <li class="scrollable-container media-list w-100">
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-online rounded-circle">
                          <img src="../../../app-assets/images/portrait/small/avatar-s-19.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Margaret Govan</h6>
                        <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Today</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-busy rounded-circle">
                          <img src="../../../app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Bret Lezama</h6>
                        <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Tuesday</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-online rounded-circle">
                          <img src="../../../app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Carie Berra</h6>
                        <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">Friday</time>
                        </small>
                      </div>
                    </div>
                  </a>
                  <a href="javascript:void(0)">
                    <div class="media">
                      <div class="media-left">
                        <span class="avatar avatar-sm avatar-away rounded-circle">
                          <img src="../../../app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span>
                      </div>
                      <div class="media-body">
                        <h6 class="media-heading">Eric Alsobrook</h6>
                        <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p>
                        <small>
                          <time class="media-meta text-muted" datetime="2015-06-11T18:29:20+08:00">last month</time>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center" href="javascript:void(0)">Read all messages</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-dark navbar-without-dd-arrow navbar-shadow"
    role="navigation" data-menu="menu-wrapper">
    <div class="navbar-container main-menu-content container center-layout" data-menu="menu-container">
      <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="{{route('main.dashboard')}}"><i class="la la-home"></i>
            <span>{{ trans('admin.dashboard') }}</span>
          </a>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link" href="#" data-toggle="dropdown"><i class="la la-user"></i>
            <span>{{ trans('staff::local.my_account') }}</span></a>
          <ul class="dropdown-menu">
            <li data-menu=""><a class="dropdown-item" href="{{route('teacher.attendance')}}" data-toggle="dropdown"><i class="la la-clock-o"></i> {{ trans('staff::local.my_attendance') }}</a></li>
            <li data-menu=""><a class="dropdown-item" href="{{route('teacher.permissions')}}" data-toggle="dropdown"><i class="la la-road"></i> {{ trans('staff::local.my_permssions') }}</a></li>
            <li data-menu=""><a class="dropdown-item" href="{{route('teacher.vacations')}}" data-toggle="dropdown"><i class="la la-umbrella"></i> {{ trans('staff::local.my_vacation') }}</a></li>
            <li data-menu=""><a class="dropdown-item" href="{{route('teacher.loans')}}" data-toggle="dropdown"><i class="la la-minus-square"></i> {{ trans('staff::local.my_loans') }}</a></li>
            <li data-menu=""><a class="dropdown-item" href="{{route('teacher.deductions')}}" data-toggle="dropdown"><i class="la la-gavel"></i> {{ trans('staff::local.my_deductions') }}</a></li>
            <li data-menu=""><a class="dropdown-item" href="{{route('teacher.payrolls')}}" data-toggle="dropdown"><i class="la la-money"></i> {{ trans('staff::local.my_salries') }}</a></li>
            
          </ul>
        </li>
        <li class="dropdown nav-item" data-menu="dropdown">
          <a class="dropdown-toggle nav-link" href="{{route('internal-regulations.teacher')}}"><i class="la la-warning"></i>
            <span>{{ trans('staff::local.internal_regulation') }}</span>
          </a>
        </li>
      </ul>
    </div>
  </div>


  <div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        @yield('content')
    </div>
  </div>

  <!-- BEGIN VENDOR JS-->
  <script src="{{asset('cpanel/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('cpanel/app-assets/vendors/js/ui/jquery.sticky.js')}}" type="text/javascript"></script>
  
  <script src="{{asset('cpanel/app-assets/vendors/js/forms/select/select2.full.min.js')}}" type="text/javascript"></script>
  
  @yield('script')
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{asset('cpanel/app-assets/vendors/js/charts/chart.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('cpanel/app-assets/vendors/js/charts/echarts/echarts.js')}}" type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{asset('cpanel/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
  <script src="{{asset('cpanel/app-assets/js/core/app.js')}}" type="text/javascript"></script>
  <script src="{{asset('cpanel/app-assets/js/scripts/customizer.js')}}" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  
  {{-- sweet alert --}}
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  {{-- message alerts --}}
  <script src="{{asset('cpanel/app-assets/js/scripts/forms/select/form-select2.js')}}" type="text/javascript"></script>
  <script>
            
    (function()
    {
        $.ajax({
            type:'get',
            url:'{{route("user.notifications")}}',
            dataType:'json',
            success:function(data){
                $('#count').html(data.count);
                $('#countTitle').html(data.countTitle);
                $('#notifications').html(data.notifications);
                $('#view').html(data.view);
            }
        });
    }());
    setInterval(function()
    {
        $.ajax({
            type:'get',
            url:'{{route("user.notifications")}}',
            dataType:'json',
            success:function(data){
                $('#count').html(data.count);
                $('#countTitle').html(data.countTitle);
                $('#notifications').html(data.notifications);
                $('#view').html(data.view);
            }
        });
    },60000); //1000 second

</script>
<script>$(".se-pre-con").fadeOut("slow");</script>

</body>
</html>