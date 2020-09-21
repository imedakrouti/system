buttons: [
                // add students to statement
                {
                    "text": "{{trans('student::local.add_student_statement')}}",
                    "className": "btn btn-info mr-1",
                    action : function ( e, dt, node, config ) {
                        event.preventDefault();                        
                        swal({
                            title: "{{trans('student::local.add_student_statement')}}",
                            text: "{{trans('student::local.cofirm_add_student')}}",
                            showCancelButton: true,
                            confirmButtonColor: "#87B87F",
                            confirmButtonText: "{{trans('msg.yes')}}",
                            cancelButtonText: "{{trans('msg.no')}}",
                            closeOnConfirm: false,
                            },
                            function() {
                                $.ajax({
                                    url:"{{route('statements.insert')}}",
                                    method:"get",                                    
                                    dataType:"json",
                                    // display succees message
                                    success:function(data)
                                    {
                                        $('#dynamic-table').DataTable().ajax.reload();
                                    }
                                })
                                // display success confirm message
                                .done(function(data) {                                    
                                    if(data.status == true)
                                    {
                                      swal("{{trans('msg.success')}}", "", "success");
                                    }else{
                                      swal("{{trans('msg.error')}}", data.msg, "error");
                                    }
                                })
                            }
                        );
                        // end swal                        
                    }
                },                
                // data_migration
                {
                    "text": "{{trans('student::local.data_migration')}}",
                    "className": "btn btn-success mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('statements.create')}}";
                    }
                },
                // restore_migration
                {
                    "text": "{{trans('student::local.restore_migration')}}",
                    "className": "btn btn-dark mr-1",
                    action : function ( e, dt, node, config ) {
                      $('#restoreMigration').modal({backdrop: 'static', keyboard: false})
				              $('#restoreMigration').modal('show');
                    }
                },                
                 
                // set_migration
                {
                    "text": "{{trans('student::local.set_migration')}}",
                    "className": "btn btn-light mr-1",
                    action : function ( e, dt, node, config ) {
                        window.location.href = "{{route('setMigration.index')}}";
                        }
                },                
                // delete btn
                @include('layouts.backEnd.includes.datatables._deleteBtn',['route'=>'statements.destroy'])                 
                // default btns
                @include('layouts.backEnd.includes.datatables._datatableBtn')
            ]