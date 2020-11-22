<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="setClasses" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-graduation-cap"></i> {{ trans('learning::local.set_classes') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">  
            <div class="alert alert-light mb-2" role="alert">
                {{ trans('learning::local.msg_exam_set_classes') }}    
            </div>            
            <form  action="{{route('set-exam-classes')}}" method="POST">
                @csrf
                
                <input type="hidden" id="exam_classes_id" value="" name="exam_id">
                      
                <div class="col-lg-12">
                    <div class="form-group row">
                      <label>{{ trans('learning::local.classrooms') }}</label>
                      <select name="classroom_id[]" class="form-control select2" id="filter_room_id" multiple required>
                            @foreach ($classes as $class)
                                <option  {{in_array( $class->id,$arr_classes) ? 'selected' : ''}}  value="{{$class->id}}">
                                {{session('lang') == 'ar'? $class->ar_name_classroom : $class->en_name_classroom}}
                                </option>
                            @endforeach
                      </select>
                      <span class="red">{{ trans('learning::local.required') }}</span>                              
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