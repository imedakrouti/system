
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
