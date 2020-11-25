<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="matching" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('learning::local.question_matching') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">                                             
            <form  action="{{route('homework.store-question')}}" method="POST">
                @csrf
                <div class="col-lg-4">                    
                    <input type="hidden" name="homework_id" id="matching_homework_id" value="">                    
                    <input type="hidden" name="question_type" value="matching">                    
                    <input type="hidden" name="question_text" value="">                    
                </div>
                <div class="col-lg-2 col-md-3">
                    <div class="form-group ">
                        <label>{{ trans('learning::local.mark') }}</label>
                        <input type="number" min="0"  name="mark" class="form-control" required>
                        <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                    </div>
                </div>
                <div class="form-group col-12 contact-repeater">
                    <label>{{ trans('learning::local.column_a') }}</label>
                    <div data-repeater-list="repeater-group-a">
                        <div class="input-group mb-1" data-repeater-item>                        
                        <input type="text" name="matching_item" required  class="form-control" placeholder="{{ trans('learning::local.item_name') }}" id="example-tel-input">                                            
                        <input type="text" name="matching_answer" required  class="form-control" placeholder="{{ trans('learning::local.right_answer') }}" id="example-tel-input">                                            
                        <span class="input-group-append" id="button-addon2">
                          <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                        </span>
                      </div>
                    </div>
                    <button type="button" data-repeater-create class="btn btn-primary">
                      <i class="ft-plus"></i> {{ trans('learning::local.add_item') }}
                    </button>
                  </div>

                  <div class="form-group col-12 contact-repeater">
                    <label>{{ trans('learning::local.column_b') }}</label>
                    <div data-repeater-list="repeater-group-b">
                        <div class="input-group mb-1" data-repeater-item>                        
                        <input type="text" name="answer_text" required  class="form-control" placeholder="{{ trans('learning::local.item_name') }}" id="example-tel-input">                                                
                        <span class="input-group-append" id="button-addon2">
                          <button class="btn btn-danger" type="button" data-repeater-delete><i class="ft-x"></i></button>
                        </span>
                      </div>
                    </div>
                    <button type="button" data-repeater-create class="btn btn-primary">
                      <i class="ft-plus"></i> {{ trans('learning::local.add_item') }}
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