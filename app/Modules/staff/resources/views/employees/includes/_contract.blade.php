<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="contract" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.employees_contract') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <form target="blank" action="#" method="get" id="frm">
                <div class="col-lg-4">
                    <label>{{ trans('staff::local.contract_end_date') }}</label>
                    <input type="hidden" name="sector_id" id="sector_id" value="">
                    <input type="hidden" name="department_id" id="department_id" value="">
                    <input type="hidden" name="section_id" id="section_id" value="">
                    <div class="form-group">
                        <input type="date" class="form-control" name="end_date">                    
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group row">
                      {{-- <div class="col-md-4"></div> --}}
                      <div class="col-md-8">
                        <button type="button" onclick="contractSubmit()" class="btn btn-success">{{ trans('staff::local.ok') }}</button>                   
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