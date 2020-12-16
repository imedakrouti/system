<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="new-permission-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18"><i class="la la-plus"></i>
                        {{ trans('staff::local.new_leave_permission') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alert"  class="hidden alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                        <span class="alert-icon"><i class="la la-info-circle"></i></span>               
                        <span id="msg" ></span>
                    </div>
                    <form class="form form-horizontal" id="permissionForm" method="POST" action="">
                        @csrf
                        <div class="form-body">
                            <input type="hidden" name="employee_id[]" value="{{employee_id()}}">

                            <div class="col-lg-6 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.leave_types') }}</label> <br>
                                    <select name="leave_type_id" id="leave_type_id" class="form-control" required>
                                        <option value="">{{ trans('staff::local.select') }}</option>
                                        @foreach ($leave_types as $leave_type)
                                            <option {{ old('leave_type_id') == $leave_type->id ? 'selected' : '' }}
                                                value="{{ $leave_type->id }}">
                                                {{ session('lang') == 'ar' ? $leave_type->ar_leave : $leave_type->en_leave }}
                                            </option>
                                        @endforeach
                                    </select> <br>
                                    <span class="red">{{ trans('staff::local.required') }}</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('staff::local.date_leave') }}</label>
                                        <input type="date" class="form-control " value="{{ old('date_leave') }}"
                                            name="date_leave" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-12">
                                    <div class="form-group">
                                        <label>{{ trans('staff::local.time_leave') }}</label>
                                        <input type="time" class="form-control " value="{{ old('time_leave') }}"
                                            name="time_leave" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions left">
                            <button type="submit" class="btn btn-success">
                                <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                            </button>
                            <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button>                                                                                              
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
