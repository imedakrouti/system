<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="trueFalse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('learning::local.true_false') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">              
            <form  action="{{route('questions.store')}}" method="POST">
                @csrf
                <div class="col-lg-4">                    
                    <input type="hidden" name="exam_id" id="true_false_exam_id" value="">                    
                    <input type="hidden" name="question_type" value="true_false">                    
                </div>
                <div class="row">
                    <div class="col-lg-10 col-md-9">
                        <div class="form-group">
                            <label>{{ trans('learning::local.question_text') }}</label>
                            <input type="text" name="question_text" class="form-control" required>
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
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text"  name="answer_text[]" class="form-control" readonly value="{{ trans('learning::local.true') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text"  name="answer_note[]" class="form-control" value="" placeholder="{{ trans('learning::local.answer_feedback') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select name="right_answer[]" class="form-control" required>
                                <option value="false">{{ trans('learning::local.other') }}</option>
                                <option value="true">{{ trans('learning::local.right_answer') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text"  name="answer_text[]" class="form-control" readonly value="{{ trans('learning::local.false') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <input type="text"  name="answer_note[]" class="form-control" value="" placeholder="{{ trans('learning::local.answer_feedback') }}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select name="right_answer[]" class="form-control" required>
                                <option value="false">{{ trans('learning::local.other') }}</option>
                                <option value="true">{{ trans('learning::local.right_answer') }}</option>
                            </select>
                        </div>
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