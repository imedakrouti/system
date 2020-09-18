<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="restoreMigration" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share"></i> {{ trans('student::local.restore_migration') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="bs-callout-primary callout-border-left mt-1 mb-1 p-1">                
                <p>{{ trans('student::local.restore_tip') }}</p>
            </div>
              
            <form action="" method="post" id="formTest">
              @csrf
              
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-4 label-control">{{ trans('student::local.current_year') }}</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" value="{{fullAcademicYear()}}" readonly>                                                          
                          </div>
                      </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-4 label-control">{{ trans('student::local.select_year') }}</label>
                        <div class="col-md-8">
                            <select name="to_year_id" class="form-control" id="year_id" required>                                
                                @foreach ($years as $year)
                                    @if (currentYear() != $year->id)
                                      <option value="{{$year->id}}">{{$year->name}}</option>                                                                          
                                    @endif
                                @endforeach
                            </select>                                                                                  
                        </div>
                      </div>
                </div>
                

              

                 
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" id="btnSave" class="btn btn-success">{{ trans('admin.restore') }}</button>              
            <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button>              
          </div>
        </div>
      </div>
    </div>
  </div>