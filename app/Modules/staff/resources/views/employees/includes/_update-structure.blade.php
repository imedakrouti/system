<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="updateStructure" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('staff::local.update_structure') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">                        
              @csrf              
              <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.sector_id') }}</label>
                      <select id="sector_id" name="sector_id" class="form-control select2">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                        @foreach ($sectors as $sector)
                            <option value="{{$sector->id}}">
                            {{session('lang') == 'ar' ? $sector->ar_sector:$sector->en_sector}}</option>
                        @endforeach
                      </select>      
                      
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.department_id') }}</label>
                      <select id="department_id" name="department_id" disabled class="form-control select2">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                            
                      </select> 
                        
                    </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.section_id') }}</label>
                      <select name="section_id" class="form-control select2">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                          @foreach ($sections as $section)
                              <option value="{{$section->id}}">
                              {{session('lang') == 'ar' ? $section->ar_section:$section->en_section}}</option>
                          @endforeach
                      </select>   
                         
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.position_id') }}</label>
                      <select name="position_id" class="form-control select2">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                          @foreach ($positions as $position)
                              <option value="{{$position->id}}">
                              {{session('lang') == 'ar' ? $position->ar_position:$position->en_position}}</option>
                          @endforeach
                      </select> 
                        
                    </div>
                </div>
              </div> 

              <div class="row">
                <div class="col-lg-6 col-md-6">
                  <div class="form-group">
                    <label>{{ trans('staff::local.timetable_id') }}</label>
                    <select id="timetable_id" name="timetable_id" class="form-control select2">
                      <option value="">{{ trans('staff::local.select') }}</option>    
                      @foreach ($timetables as $timetable)
                          <option value="{{$timetable->id}}">
                          {{session('lang') == 'ar' ? $timetable->ar_timetable:$timetable->en_timetable}}</option>
                      @endforeach
                    </select>      
                    
                  </div> 
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.bus_value') }}</label>
                      <input type="number" min="0" class="form-control " value="{{old('bus_value')}}" 
                      placeholder="{{ trans('staff::local.bus_value') }}"
                        name="bus_value">                                            
                    </div>
                </div>               
              </div>
              <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="form-group">
                          <label>{{ trans('staff::local.direct_manager_id') }}</label>
                          <select name="direct_manager_id" " class="form-control select2">
                              <option value="">{{ trans('staff::local.select') }}</option>
                              @foreach ($employees as $employee)
                                  <option {{old('staff_id') == $employee->id ? 'selected' :''}} value="{{$employee->id}}">
                                  @if (session('lang') == 'ar')
                                  [{{$employee->attendance_id}}] {{$employee->ar_st_name}} {{$employee->ar_nd_name}} {{$employee->ar_rd_name}} {{$employee->ar_th_name}}
                                  @else
                                  [{{$employee->attendance_id}}] {{$employee->en_st_name}} {{$employee->en_nd_name}} {{$employee->en_rd_name}} {{$staff->en_th_name}}
                                  @endif
                                  </option>
                              @endforeach
                          </select> <br>                                        
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                      <div class="form-group row">
                        <label>{{ trans('staff::local.holiday_id') }}</label>
                        <ul style="list-style: none">
                            @foreach ($holidays as $holiday)
                                <h5>
                                    <li>
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace" name="holiday_id[]" value="{{$holiday->id}}">
                                    <span class="lbl"></span> {{session('lang') == 'ar'?$holiday->ar_holiday:
                                    $holiday->en_holiday}}
                                        </label>                                                            
                                    </li>
                                </h5>
                            @endforeach
                        </ul>
                      </div>
                    </div>                    

              </div>
              <div class="form-actions left">
                <button onclick="updateStructure()" class="btn btn-success">
                    <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                  </button>
                  <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button> 
            </div>      
                                  
           
          </div>        
        </div>
      </div>
    </div>
  </div>