<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="vacation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.vacations') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">   
            <div class="table-responsive">
                <form action="" id='formData' method="post">
                  @csrf
                  <table id="dynamic-table-vacation" class="table data-table" style="width: 100%">
                      <thead class="bg-info white">
                          <tr>                              
                                <th>#</th>                              
                                <th>{{trans('staff::local.vacation_type')}}</th>                                
                                <th>{{trans('staff::local.date_vacation')}}</th>                                                                
                                <th>{{trans('staff::local.vacation_period')}}</th>
                                <th>{{trans('staff::local.vacation_days')}}</th>                                                                
                                <th>{{trans('staff::local.approval1')}}</th>                                                                                                
                                <th>{{trans('staff::local.approval2')}}</th>                                                                                                
                                <th>{{trans('staff::local.attachments')}}</th>                                                                                                
                                <th>{{trans('staff::local.vacation_updated_at')}}</th>                                                                                                                                 
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