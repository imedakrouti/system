<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="multiple_choice" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('learning::local.multiple_choice') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">         
            <div class="alert alert-light mb-2" role="alert">
                {{ trans('learning::local.tip_feedback') }}    
            </div>                             
            <form  action="{{route('homework.store-question')}}" method="POST">
                @csrf
                <div class="col-lg-4">                    
                    <input type="hidden" name="homework_id" id="homework_id" value="">                    
                    <input type="hidden" name="question_type" value="multiple_choice">                    
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
                <div class="form-group col-12 contact-repeater">
                    <div data-repeater-list="repeater-group">
                        <div class="input-group mb-1" data-repeater-item>                        
                        <input type="text" name="answer_text" required  class="form-control" placeholder="{{ trans('learning::local.choices') }}" id="example-tel-input">                        
                        <input type="text" name="answer_note" required  class="form-control"placeholder="{{ trans('learning::local.answer_feedback') }}" id="example-tel-input">
                        <select name="right_answer" class="form-control" required>
                            <option value="false">{{ trans('learning::local.other') }}</option>
                            <option value="true">{{ trans('learning::local.right_answer') }}</option>
                        </select>
                        <span class="input-group-append" id="button-addon2">
                          <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                        </span>
                      </div>
                    </div>
                    <button type="button" data-repeater-create class="btn btn-primary">
                      <i class="ft-plus"></i> {{ trans('learning::local.add_choice') }}
                    </button>
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