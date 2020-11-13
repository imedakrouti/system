<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="loan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.loans') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">   
            <div class="table-responsive">
                <form action="" id='formData' method="post">
                  @csrf
                  <table id="dynamic-table-loan" class="table data-table" style="width: 100%">
                      <thead class="bg-info white">
                          <tr>                              
                              <th>#</th>                              
                              <th>{{trans('staff::local.amount')}}</th>                                
                              <th>{{trans('staff::local.date_loan')}}</th>                                                                
                              <th>{{trans('staff::local.approval1')}}</th>                                                                                                
                              <th>{{trans('staff::local.approval2')}}</th>                                                                                                
                              <th>{{trans('staff::local.loan_updated_at')}}</th>                                                                                                                              
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </form>
            </div>
         
              <div class="form-actions left">           
                  <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button> 
              </div>                                                   
          </div>        
        </div>
      </div>
    </div>
  </div>