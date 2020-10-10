<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="monthly_statement" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('student::local.absence_statement') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">              
            <form action="#" method="get" id="formMonthStatement" target="_blank">
              <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-2 label-control">{{ trans('student::local.division') }}</label>
                    <div class="col-md-6">    
                        <select name="division_id" class="form-control" id="monthly_division_id">
                            <option value="">{{ trans('student::local.divisions') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{$division->id}}">
                                    {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                            @endforeach
                        </select>
                    </div>
                  </div>
              </div> 
              <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-2 label-control">{{ trans('student::local.grade') }}</label>
                    <div class="col-md-6">    
                        <select name="grade_id" class="form-control" id="monthly_grade_id">
                            <option value="">{{ trans('student::local.grades') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{$grade->id}}">
                                    {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                            @endforeach
                        </select>
                    </div>
                  </div>
              </div> 
              <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-2 label-control">{{ trans('student::local.classroom') }}</label>
                    <div class="col-md-6">    
                      <select name="classroom_id" class="form-control" id="monthly_classroom_id" disabled>
                          <option value="">{{ trans('student::local.classrooms') }}</option>                    
                      </select>
                    </div>
                  </div>
              </div>  
              <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-2 label-control">{{ trans('student::local.from') }}</label>
                    <div class="col-md-6">    
                      <input type="date" class="form-control" name="from_date">
                    </div>
                  </div>
              </div>                                            
              <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-2 label-control">{{ trans('student::local.to') }}</label>
                    <div class="col-md-6">    
                      <input type="date" class="form-control" name="to_date">
                    </div>
                  </div>
              </div>              
               
                <div class="col-md-12">
                  <div class="form-group row">                      
                    <div class="col-md-8">
                      <button type="button" onclick="getMonthStatement()" class="btn btn-primary">{{ trans('student::local.print') }}</button>                   
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