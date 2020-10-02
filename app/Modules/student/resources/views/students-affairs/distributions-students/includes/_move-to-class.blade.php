<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="moveToClass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('student::local.move_to_class') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <form action="" method="post" id="formMove">
              @csrf
              <div class="mb-2">
                  <h4 class="center purple">{{ trans('student::local.current_year') }} {{fullAcademicYear()}}</h4>
                  <h5>{{ trans('student::local.division') }}: <span class="red" id="divId"></span></h5>
                  <h5>{{ trans('student::local.grade') }}: <span class="blue" id="graId"></span></h5>
              </div>
              <div class="row mb-2"> 
                <div class="col-md-6">
                    <h5 class="center red">{{ trans('student::local.from') }}</h5>
                    <div class="form-group row">
                        <label class="col-md-3 label-control">{{ trans('student::local.year') }}</label>
                        <div class="col-md-9">
                          <select name="from_year_id" id="from_year_id" class="form-control" required>
                              <option value="">{{ trans('student::local.select') }}</option>
                              @foreach ($years as $year)                                  
                                      <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                                                      
                              @endforeach
                          </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label class="col-md-3 label-control">{{ trans('student::local.class_room') }}</label>
                        <div class="col-md-9">
                            <select name="from_room_id" class="form-control" id="from_room_id" disabled>
                                <option value="">{{ trans('student::local.classrooms') }}</option>                    
                            </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                      </div>                       
                </div>                    
                <div class="col-md-6">  
                    <h5 class="center red">{{ trans('student::local.to') }}</h5>
                      <div class="form-group row">
                        <label class="col-md-3 label-control">{{ trans('student::local.class_room') }}</label>
                        <div class="col-md-9">
                            <select name="to_room_id" class="form-control" id="to_room_id" disabled>
                                <option value="">{{ trans('student::local.classrooms') }}</option>                    
                            </select>
                          <span class="red">{{ trans('student::local.requried') }}</span>
                        </div>
                      </div>                      
                       
                </div>
            
              </div>              
  
                <div class="col-md-12">
                  <div class="form-group row">
                      {{-- <div class="col-md-4"></div> --}}
                      <div class="col-md-8">
                        <button type="button" id="btnMoveToClass" class="btn btn-success">{{ trans('student::local.migrate') }}</button>                   
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