{
    "text": "{{trans('admin.cancelation')}}",
    "className": "btn btn-danger buttons-print btn-danger mr-1",
    action: function ( e, dt, node, config ) {
        var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
        if (itemChecked > 0) {
            var form_data = $('#formData').serialize();
            swal({
                    title: "{{trans('msg.cancel_invoice_confirmation')}}",
                    text: "{{trans('msg.cancel_invoice_ask')}}",
                    showCancelButton: true,
                    confirmButtonColor: "#D15B47",
                    confirmButtonText: "{{trans('msg.yes')}}",
                    cancelButtonText: "{{trans('msg.no')}}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url:"{{route($route)}}",
                        method:"POST",
                        data:form_data,
                        dataType:"json",
                        // display succees message
                        success:function(data)
                        {
                            $('.data-table').DataTable().ajax.reload();
                        }
                    })
                    // display success confirm message
                    .done(function(data) {
                        swal("{{trans('msg.cancel_invoice_confirmation')}}", "{{trans('msg.cancel_invoice_successfully')}}", "success");
                    })
                    // display error message
                    .error(function(data) {
                        swal("{{trans('msg.error')}}", "{{trans('msg.fail')}}", "error");
                    });
                }
            );
        }	else{
            swal("{{trans('msg.cancel_invoice_confirmation')}}", "{{trans('msg.no_records_selected')}}", "info");
        }
    }
},
