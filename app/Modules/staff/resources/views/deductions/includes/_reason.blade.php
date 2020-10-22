<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="reason" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.reason') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">                        
            <div class="col-lg-12 col-md-12">
                <div class="form-group row">                  
                  <textarea id="reason_text" class="form-control" cols="30" rows="5"></textarea>                    
                </div>
            </div> 
              <div class="form-actions left">           
                  <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button> 
              </div>                                                   
          </div>        
        </div>
      </div>
    </div>
  </div>