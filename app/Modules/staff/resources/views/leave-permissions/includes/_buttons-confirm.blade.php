buttons: [ 
    // new accepted
   {
       "text": "{{trans('staff::local.accepted')}}",
       "className": "btn btn-success mr-1",
       action : function ( e, dt, node, config ) {
         var form_data = $('#formData').serialize();
           var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
           if (itemChecked == "0") {
               swal("{{trans('staff::local.leave_permissions')}}", "{{trans('msg.no_records_selected')}}", "info");
               return;
           }
           swal({
               title: "{{trans('staff::local.leave_permissions')}}",
               text: "{{trans('staff::local.leave_permissions_accept_confirm')}}",
               showCancelButton: true,
               confirmButtonColor: "#87B87F",
               confirmButtonText: "{{trans('msg.yes')}}",
               cancelButtonText: "{{trans('msg.no')}}",
               closeOnConfirm: false,
               },
               function() {
                   $.ajax({
                       url:"{{route('leave-permissions.accept-confirm')}}",
                       method:"POST",
                       data:form_data,
                       dataType:"json",
                       success:function(data)
                       {                                        
                           $('#dynamic-table').DataTable().ajax.reload();
                       }
                   })
                   // display success confirm message
                   .done(function(data) {
                       swal("{{trans('msg.success')}}", "{{trans('msg.updated_successfully')}}", "success");
                   })
               }
           );
           // end swal                        
       }
   },
   // new rejected
   {
       "text": "{{trans('staff::local.rejected')}}",
       "className": "btn btn-danger mr-1",
       action : function ( e, dt, node, config ) {
         var form_data = $('#formData').serialize();
           var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
           if (itemChecked == "0") {
               swal("{{trans('staff::local.leave_permissions')}}", "{{trans('msg.no_records_selected')}}", "info");
               return;
           }
           swal({
               title: "{{trans('staff::local.leave_permissions')}}",
               text: "{{trans('staff::local.leave_permissions_reject_confirm')}}",
               showCancelButton: true,
               confirmButtonColor: "#87B87F",
               confirmButtonText: "{{trans('msg.yes')}}",
               cancelButtonText: "{{trans('msg.no')}}",
               closeOnConfirm: false,
               },
               function() {
                   $.ajax({
                       url:"{{route('leave-permissions.reject-confirm')}}",
                       method:"POST",
                       data:form_data,
                       dataType:"json",
                       success:function(data)
                       {                                        
                           $('#dynamic-table').DataTable().ajax.reload();
                       }
                   })
                   // display success confirm message
                   .done(function(data) {
                       swal("{{trans('msg.success')}}", "{{trans('msg.updated_successfully')}}", "success");
                   })
               }
           );
           // end swal                        
       }
   },                 
   // default btns
   @include('layouts.backEnd.includes.datatables._datatableBtn')
]