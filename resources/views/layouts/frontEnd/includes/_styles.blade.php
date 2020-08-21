<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
rel="stylesheet">
<link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
rel="stylesheet">
<!-- BEGIN VENDOR CSS-->
@yield('styles')
<!-- END VENDOR CSS-->
<!-- BEGIN MODERN CSS-->
@if (session('lang') == trans('admin.ar') || session('lang') == 'ar')
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/vendors.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/app.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/custom-rtl.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/menu/menu-types/vertical-overlay-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/colors/palette-gradient.css')}}">
@else
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/vendors.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/app.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/custom.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/core/menu/menu-types/vertical-overlay-menu.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css/core/colors/palette-gradient.css')}}">
@endif

<!-- END MODERN CSS-->
<!-- BEGIN Page Level CSS-->


<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/cryptocoins/cryptocoins.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/fonts/line-awesome/css/line-awesome.min.css')}}">
<!-- END Page Level CSS-->
<!-- BEGIN Custom CSS-->
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/fonts/simple-line-icons/style.min.css')}}">
@if (session('lang') == trans('admin.ar') || session('lang') == 'ar')
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/assets/css/style-rtl.css')}}">
<link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/fonts/simple-line-icons/style.min.css')}}">
@else
<link rel="stylesheet" type="text/css" href="{{asset('cpanel/assets/css/style.css')}}">
@endif
{{-- <link rel="stylesheet" type="text/css" href="{{asset('cpanel/assets/css/style-rtl.css')}}"> --}}
<!-- END Custom CSS-->
  <!-- END Custom CSS-->
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

  <style>
      body,h1,h2,h3,h4,h5,h6,a,li,p,span {
          font-family: 'Cairo', sans-serif;
      }
  </style>
