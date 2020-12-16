<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="new-vacation-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18"><i class="la la-plus"></i>
                        {{ trans('staff::local.new_vacation') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alert"  class="hidden alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                        <span class="alert-icon"><i class="la la-info-circle"></i></span>               
                        <span id="msg" ></span>
                    </div>
                    <form class="form form-horizontal" id="vacationForm" method="POST" action="">
                        @csrf
                        <div class="form-body">
                            <input type="hidden" name="employee_id[]" value="{{employee_id()}}">
                            
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('staff::local.date_vacation') }}</label>
                                        <input type="date" class="form-control " value="{{ old('date_vacation') }}"
                                            name="date_vacation" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('staff::local.vacation_type') }}</label>
                                        <select name="vacation_type" class="form-control" id="vacation_type" required>
                                            <option value="">{{ trans('staff::local.select') }}</option>                                            
                                            <option value="Sick leave">{{ trans('staff::local.sick_leave') }}</option>
                                            <option value="Regular vacation">
                                                {{ trans('staff::local.regular_vacation') }}</option>
                                            <option value="Vacation without pay">
                                                {{ trans('staff::local.vacation_without_pay') }}</option>                                            
                                        </select>
                                        <span class="red">{{ trans('staff::local.required') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('staff::local.vacation_from_date') }}</label>
                                        <input type="date" class="form-control " value="{{ old('from_date') }}"
                                            name="from_date" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                        <label>{{ trans('staff::local.vacation_to_date') }}</label>
                                        <input type="date" class="form-control " value="{{ old('to_date') }}"
                                            name="to_date" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.file_name') }}</label>
                                    <input type="file" class="form-control" name="file_name">

                                </div>
                            </div>
                            
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group row">
                                    <label>{{ trans('staff::local.notes') }}</label>
                                    <textarea name="notes" class="form-control" cols="30"
                                        rows="5">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                     
                        </div>
                        <div class="form-actions left">
                            <button type="submit" class="btn btn-success" id="btn_save">
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
