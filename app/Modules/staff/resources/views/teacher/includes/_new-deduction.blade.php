<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="new-deduction-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18"><i class="la la-plus"></i>
                        {{ trans('staff::local.new_deduction') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="alert"
                        class="hidden alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2"
                        role="alert">
                        <span class="alert-icon"><i class="la la-info-circle"></i></span>
                        <span id="msg"></span>
                    </div>
                    <form class="form form-horizontal" id="deductionForm" method="POST" action="">
                        @csrf
                        <div class="form-body">
                            @if (authInfo()->domain_role == trans('staff::local.super_visor'))
                                <div class="col-lg-4 col-md-12">                      
                                    <div class="form-group row">
                                        <select class="form-control" name="employee_id">                                    
                                            @foreach ($employees as $employee)
                                                <option {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                                                    value="{{ $employee->id }}">{{$employee->employee_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <hr>
                            @else
                                <input type="hidden" name="employee_id" value="{{employee_id()}}">
                            @endif
                            <div class="row">
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.date_deduction') }}</label>
                                      <input type="date" class="form-control " value="{{old('date_deduction')}}"                           
                                        name="date_deduction" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="form-group">
                                      <label>{{ trans('staff::local.deduction_amount') }}</label>
                                      <input type="number" min="0" step="0.25" class="form-control " value="{{old('amount')}}"                           
                                        name="amount" required>
                                        <span class="red">{{ trans('staff::local.required') }}</span>                          
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="form-group row">
                                  <label>{{ trans('staff::local.reason') }}</label>
                                  <textarea name="reason" class="form-control" cols="30" rows="5">{{old('reason')}}</textarea>
                                    <span class="red">{{ trans('staff::local.required') }}</span>                          
                                </div>
                            </div>    
                        </div>
                        <div class="form-actions left">
                            <button type="submit" class="btn btn-success" id="btn_save">
                                <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                            </button>
                            <button type="button" data-dismiss="modal"
                                class="btn btn-light">{{ trans('admin.cancel') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
