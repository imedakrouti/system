<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="question" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-info">
            <h4 class="modal-title white" id="myModalLabel18"><i class="la la-question"></i> {{ trans('learning::local.add_question') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span class="white" aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">              
            <form  action="{{route('homeworks.store')}}" method="POST">
                @csrf                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.title') }}</label>                                                        
                                <input type="text" name="title" class="form-control" required placeholder="{{ trans('learning::local.title') }}">
                                <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                            <label>{{ trans('learning::local.classrooms') }}</label>
                            <select name="classroom_id[]" class="form-control select2" id="filter_room_id" multiple required>
                                    @foreach ($classrooms as $class)
                                        <option value="{{$class->id}}">
                                        {{session('lang') == 'ar'? $class->ar_name_classroom : $class->en_name_classroom}}
                                        </option>
                                    @endforeach
                            </select>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>  

                        <div class="col-lg-12 col-md-12">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.lessons_related_assignment') }}</label>
                                <select name="lessons[]" class="form-control select2" multiple required>
                                    <option value="">{{ trans('staff::local.select') }}</option>
                                    @foreach ($lessons as $lesson)
                                        <option value="{{$lesson->id}}">{{$lesson->lesson_title}} 
                                            [{{session('lang') == 'ar' ? $lesson->subject->ar_name : $lesson->subject->en_name}}]</option>
                                    @endforeach
                                </select>
                                <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <div class="form-group row">
                            <label>{{ trans('learning::local.subject') }}</label>
                            <select name="subject_id" class="form-control" required>                                
                                @foreach (employeeSubjects() as $subject)
                                    <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                        {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                                @endforeach
                            </select>
                            <span class="red">{{ trans('learning::local.required') }}</span>                              
                            </div>
                        </div>                
                        <div class="row">
                          <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>{{ trans('learning::local.due_date') }}</label>                                                        
                                  <input type="date" name="due_date" class="form-control">                            
                              </div>
                          </div>
  
                          <div class="col-lg-6 col-md-6">
                              <div class="form-group">
                                  <label>{{ trans('learning::local.total_mark') }}</label>
                                  <input type="number" min="0"  name="total_mark" class="form-control" required>
                                  <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                              </div>
                          </div>

                        </div>
                  </div>
                </div>

                <hr>
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