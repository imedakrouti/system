<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="payroll" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.payrolls') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">   
            <div class="table-responsive">
              <table id="dynamic-table-payroll" class="table data-table" style="width: 100%">
                <thead class="bg-info white">
                    <tr>                              
                          <th>#</th>                              
                          <th>{{trans('staff::local.payroll_sheet_name')}}</th>
                          <th>{{trans('staff::local.month')}}</th>                                
                          <th>{{trans('staff::local.from')}}</th>                                
                          <th>{{trans('staff::local.to')}}</th>                                                                                                                       
                          <th>{{trans('staff::local.salary')}}</th>                                                                                                                       
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            </div>
         
              <div class="form-actions left">           
                  <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button> 
              </div>                                                   
          </div>        
        </div>
      </div>
    </div>
  </div>