<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<head>
@include('layouts.backEnd.teacher-layout.head')
</head>
<body class="horizontal-layout horizontal-menu horizontal-menu-padding content-detached-right-sidebar   menu-expanded"
data-open="click" data-menu="horizontal-menu" data-col="content-detached-right-sidebar" >
<div class="se-pre-con"></div>
  <!-- fixed-top-->
  @include('layouts.backEnd.teacher-layout.nav')
  
  @include('layouts.backEnd.teacher-layout.header-navbar')
  
  <div class="app-content container center-layout mt-2">
    <div class="content-wrapper">
        @yield('content')
    </div>
  </div>

  @include('layouts.backEnd.teacher-layout.scripts')
</body>
</html>