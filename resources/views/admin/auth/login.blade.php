<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
  <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
  <meta name="author" content="PIXINVENT">
  <title>{{ trans('admin.login') }}</title>
  <link rel="apple-touch-icon" href="{{asset('app-assets/images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('')}}app-assets/images/ico/favicon.ico">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Quicksand:300,400,500,700"
  rel="stylesheet">
  <link href="https://maxcdn.icons8.com/fonts/line-awesome/1.1/css/line-awesome.min.css"
  rel="stylesheet">
  <!-- BEGIN VENDOR CSS-->
  {{-- sweet alert style --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/vendors.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/forms/icheck/icheck.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/vendors/css/forms/icheck/custom.css')}}">
  <!-- END VENDOR CSS-->
  <!-- BEGIN MODERN CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/app.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/custom-rtl.css')}}">
  <!-- END MODERN CSS-->
  <!-- BEGIN Page Level CSS-->
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/core/colors/palette-gradient.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/app-assets/css-rtl/pages/login-register.css')}}">
  <!-- END Page Level CSS-->
  <!-- BEGIN Custom CSS-->
  <script src="{{ asset('js/app.js') }}"></script>
  <link rel="stylesheet" type="text/css" href="{{asset('cpanel/assets/css/style-rtl.css')}}">
  <!-- END Custom CSS-->
  <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">

  <style>
      body,h1,h2,h3,h4,h5,h6,a,li,p {
          font-family: 'Cairo', sans-serif;
      }
    .sweet-alert h2 {font-family: 'Cairo', sans-serif;font-weight: 500;}
    .sweet-alert p {font-family: 'Cairo', sans-serif;}
    .sweet-alert button {font-family: 'Cairo', sans-serif;}
    .sweet-alert {font-family: 'Cairo', sans-serif;}
  </style>
</head>
<body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page"
data-open="click" data-menu="vertical-menu" data-col="1-column">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body">
        <section class="flexbox-container">
          <div class="col-12 d-flex align-items-center justify-content-center">
            <div class="col-md-4 col-10 box-shadow-2 p-0">
              <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                  <div class="card-title text-center">
                    <div class="p-1">
                      <img src="{{asset('cpanel/app-assets/images/logo/logo-dark.png')}}" alt="branding logo">
                    </div>
                  </div>
                  <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                    <span>Login with Modern</span>
                  </h6>
                        @if($errors->any())
                            <div class="alert bg-danger alert-dismissible mb-2 text-center">
                                <strong>
                                    @foreach($errors->all() as $error)
                                        <!-- print all errors -->
                                            {{$error}} . <br>
                                    @endforeach
                                </strong>
                            </div>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert bg-danger alert-dismissible mb-2 text-center">
                                <strong>{{session('error')}}</strong>
                            </div>
                        @endif
                   </div>
                <div class="card-content">
                  <div class="card-body">
                    @include('admin.auth._form')
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <!-- BEGIN VENDOR JS-->
  <script src="{{asset('cpanel/app-assets/vendors/js/vendors.min.js')}}" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <script src="{{asset('cpanel/app-assets/vendors/js/forms/icheck/icheck.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('cpanel/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"
  type="text/javascript"></script>
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN MODERN JS-->
  <script src="{{asset('cpanel/app-assets/js/core/app-menu.js')}}" type="text/javascript"></script>
  <script src="{{asset('cpanel/app-assets/js/core/app.js')}}" type="text/javascript"></script>
  <!-- END MODERN JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <script src="{{asset('cpanel/app-assets/js/scripts/forms/form-login-register.js')}}" type="text/javascript"></script>
  <!-- END PAGE LEVEL JS-->
{{-- sweet alert --}}
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
{{-- message alerts --}}
@include('sweet::alert')
</body>
</html>
