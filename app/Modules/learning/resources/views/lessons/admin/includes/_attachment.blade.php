<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="attachments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('learning::local.attachments') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <form  action="{{route('lessons.attachment')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-4">                    
                    <input type="hidden" name="lesson_id" id="lesson_id" value="">                    
                </div>

                <div class="col-lg-12 col-md-12">
                    <div class="form-group">                          
                      <label>{{ trans('learning::local.file_title') }}</label>
                      <input  type="text" name="title" class="form-control" required>                
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                  <div class="form-group">                          
                    <label>{{ trans('learning::local.file_title') }}</label>
                    <input  type="file" name="file_name" class="form-control">                
                  </div>
              </div>
                <div class="col-md-12">
                  <div class="form-group row">
                      {{-- <div class="col-md-4"></div> --}}
                      <div class="col-md-8">
                        <button type="submit" class="btn btn-success">{{ trans('staff::local.ok') }}</button>                   
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