<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="departmentReport" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.department_payroll_report') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <form target="blank" action="{{route('payroll-report.department')}}" method="get" id="frm">
              <input type="hidden" id="code" name="code">
              <div class="form-group row">
                  <label class="col-lg-3 col-md-12 label-control">{{ trans('staff::local.sector_id') }}</label>
                  <div class="col-lg-6 col-md-12">                    
                      <select id="sector_id" name="sector_id" class="form-control select2">
                          <option value="">{{ trans('staff::local.select') }}</option>    
                          @foreach ($sectors as $sector)
                              <option value="{{$sector->id}}">
                              {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}</option>
                          @endforeach
                      </select>                              
                  </div>
              </div>

              <div class="form-group row">
                  <label class="col-lg-3 col-md-12 label-control">{{ trans('staff::local.department_id') }}</label>
                  <div class="col-lg-6 col-md-12">                    
                      <select id="department_id" disabled name="department_id" class="form-control select2">
                          <option value="">{{ trans('staff::local.select') }}</option>    
                      </select>                              
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