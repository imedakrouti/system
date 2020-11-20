<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="paragraph" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('learning::local.question_paragraph') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">              
            <form  action="{{route('questions.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-4">                    
                    <input type="hidden" name="exam_id" id="paragraph_exam_id" value="">                    
                    <input type="hidden" name="question_type" value="paragraph">                    
                </div>
            
                <div class="col-lg-12 col-md-12">
                    <div class="form-group ">
                        <label>{{ trans('learning::local.question_text') }}</label>                                                        
                        <textarea class="form-control" name="question_text" id="ckeditor" cols="30" rows="10" class="ckeditor"></textarea>                          
                        <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group">
                        <label>{{ trans('learning::local.mark') }}</label>
                        <input type="number" min="0"  name="mark" class="form-control" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                    </div>
                </div>
                <div class="col-lg-4">
                  <div class="form-group">
                    <label>{{ trans('learning::local.add_image') }}</label>
                    <input type="file" class="form-control" name="file_name">
                  </div>
                </div>
    
                <div class="col-md-12">
                  <div class="form-group">
                      {{-- <div class="col-md-4"></div> --}}
                      <div class="col-md-8">
                        <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>                   
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