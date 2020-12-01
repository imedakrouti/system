<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="addReportModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel18"><i class="la la-file"></i> {{ trans('learning::local.add_report') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-lg-12">
                    <div class="form-group row">                         
                        <textarea cols="30" name="report" id="report" rows="10" class="form-control answer"></textarea>
                    </div>
                    </div>    
                <div class="col-md-12">
                <div class="form-group row">
                    {{-- <div class="col-md-4"></div> --}}
                    <div class="col-md-8">                                                    
                        <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button>                                                                                              
                    </div>
                </div>                      
            </div>                                                       
          </div>        
        </div>
      </div>
    </div>
</div>