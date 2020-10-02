// new btn
{
    "text": "{{trans('student::local.add_to_statement')}}",
    "className": "btn btn-primary buttons-print btn-primary mr-1",
    action : function ( e, dt, node, config ) {
        var form_data = $('#formData').serialize();
        swal({
                title: "{{trans('student::local.add_to_statement')}}",
                text: "{{trans('student::local.store_to_statement')}}",
                showCancelButton: true,
                confirmButtonColor: "#87B87F",
                confirmButtonText: "{{trans('msg.yes')}}",
                cancelButtonText: "{{trans('msg.no')}}",
                closeOnConfirm: false,
            },
            function() {
                $.ajax({
                    url:"{{route('statements.storeToStatement')}}",
                    method:"POST",
                    data:form_data,
                    dataType:"json",
                    // display succees message
                    success:function(data)
                    {
                        
                    },
                    // display validations error in page
                    error:function(data_error,exception){
                        if (exception == 'error'){
                            $('.classModal').show();
                            $.each(data_error.responseJSON.errors,function(index,value){
                                $('.classModal ul').append("<li>"+ value +"</li>");
                            })
                        }
                    }
                })
                // display success confirm message
                .done(function(data) {
                    swal("{{trans('msg.success')}}", "", "success");
                })
            }
        );        
      }
},  