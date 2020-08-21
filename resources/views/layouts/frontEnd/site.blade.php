<!DOCTYPE html>
<html class="loading" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
  <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="PIXINVENT">
  <title>{{session('lang')=='ar' || session('lang') == trans('admin.ar') ? settingHelper()->siteNameArabic :settingHelper()->siteNameEnglish}}</title>
    <link rel="apple-touch-icon" href="{{asset('cpanel/app-assets/images/ico/apple-icon-120.png')}}">
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('cpanel/app-assets/images/ico/favicon.ico')}}">

  @include('layouts.frontEnd.includes._styles')

</head>
<body class="vertical-layout vertical-overlay-menu 2-columns   menu-expanded fixed-navbar"
data-open="click" data-menu="vertical-overlay-menu" data-col="2-columns">
  <!-- fixed-top-->
  @include('layouts.frontEnd.includes._nav')
  {{-- sidebar --}}
  @include('layouts.frontEnd.includes._sidebar')
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
          <div class="container">
            @include('layouts.frontEnd.includes._search')
              @yield('content')
          </div>
      </div>
    </div>
  </div>
  @include('sweetalert::alert')
  {{-- footer --}}
  @include('layouts.frontEnd.includes._footer')

  @include('layouts.frontEnd.includes._scripts')
  @include('layouts.frontEnd.includes._autoCompleteSearch')
  @yield('script')

</body>
</html>
