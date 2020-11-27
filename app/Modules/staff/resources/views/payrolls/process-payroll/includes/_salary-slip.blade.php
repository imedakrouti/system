<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="salarySlip" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.salary_slip') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <form target="blank" action="{{route('salary-slip.employee')}}" method="get" id="frm">
              <input type="hidden" id="code-employee" name="code">
              <div class="col-lg-6 col-md-12">
                    <div class="form-group row">
                    <label>{{ trans('staff::local.employee_name') }}</label> <br>
                    <select name="employee_id" id="employee_id" class="form-control select2" required>
                        <option value="">{{ trans('staff::local.select') }}</option>
                        @foreach ($employees as $employee)
                            <option {{old('staff_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                            @if (session('lang') == 'ar')
                            [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                            @else
                            [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$employee->en_th_name}}
                            @endif
                            </option>
                        @endforeach
                    </select> <br>
                    <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group row">
                      {{-- <div class="col-md-4"></div> --}}
                      <div class="col-md-8">
                        <button type="submit" id="btnDepartment" class="btn btn-success">{{ trans('staff::local.ok') }}</button>                   
                        <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button>                                                                                              
                      </div>
                    </div>
              </div>                           
                
            </form>
          </div>        
        </div>
      </div>
    </div>
  </div>