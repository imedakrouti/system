<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="essay" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('learning::local.question_essay') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">              
            <form  action="{{route('teacher.store-question')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-lg-4">                    
                    <input type="hidden" name="exam_id" id="essay_exam_id" value="">                    
                    <input type="hidden" name="question_type" value="essay">                    
                </div>
                <div class="row">
                    <div class="col-lg-10 col-md-9">
                        <div class="form-group">
                            <label>{{ trans('learning::local.question_text') }}</label>                            
                            <textarea name="question_text" class="form-control" required cols="30" rows="5"></textarea>
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
                </div>
                <div class="col-lg-12 col-md-9">
                    <div class="form-group row">
                        <label>{{ trans('learning::local.correct_answer') }}</label>                            
                        <textarea name="answer_text" class="form-control" required cols="30" rows="5"></textarea>
                        <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                    </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-group row">
                    <label>{{ trans('learning::local.add_image') }}</label>
                    <input type="file" class="form-control" name="file_name" accept=".png, .jpg, .jpeg">
                  </div>
                </div>
    
                <div class="col-md-12">
                  <div class="form-group row">
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