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
                      <span class="red">{{ trans('staff::local.required') }}</span>                                                                 
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>{{ trans('staff::local.department_id') }}</label>
                      <select id="department_id" name="department_id" disabled class="form-control select2">
                        <option value="">{{ trans('staff::local.select') }}</option>    
                            
                      </select> 
                      <span class="red">{{ trans('staff::local.required') }}</span>                                                                   
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
                      <span class="red">{{ trans('staff::local.required') }}</span>                                                                    
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
                      <span class="red">{{ trans('staff::local.required') }}</span>                                                                   
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