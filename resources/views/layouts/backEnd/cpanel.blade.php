<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
  <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="PIXINVENT">
  <title>{{$title}}</title>
  <link rel="apple-touch-icon" href="{{asset('cpanel/app-assets/images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/website/'.settingHelper()->icon)}}">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
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
          background: url("{{url('cpanel/app-assets/loader-64x/red-1.gif')}}") center no-repeat #fff;        }
          .message{
          position: absolute;width: 100%;height: 50px;background-color: #11c011;color: white;line-height: 50px;
          z-index: 1200;text-align: center;opacity: 1;top: -50px ;
      }
  </style>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-menu" data-col="2-columns">
<div class="se-pre-con"></div>
  <!-- fixed-top-->
    @include('layouts.backEnd.includes._nav')
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  @yield('sidebar')
  {{-- {{dd(Config('app.locale'))}} --}}
    {{-- {{dd(session('lang'))}} --}}
  <div class="app-content content">
    <div class="content-wrapper">

        @yield('content')
        
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  @include('layouts.backEnd.includes._footer')
  @include('sweetalert::alert')

  <!-- BEGIN VENDOR JS-->
  <script src="{{asset('cpanel/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
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
