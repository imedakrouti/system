<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="setModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
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
            <form action="" method="post" id="frm">
              @csrf              
                <div class="col-md-12 mb-1">
                    <label>{{ trans('student::local.grade') }}</label>
                    <select name="from_grade_id" class="form-control" required>
                        <option value="">{{ trans('student::local.grades') }}</option>
                        @foreach ($grades as $grade)
                            <option value="{{$grade->id}}">
                                {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                        @endforeach
                    </select>                    
                </div>
                <div class="col-md-12">
                    <label>{{ trans('student::local.next_grade') }}</label>
                    <select name="to_grade_id" class="form-control" required>
                        <option value="">{{ trans('student::local.grades') }}</option>
                        @foreach ($grades as $grade)
                            <option value="{{$grade->id}}">
                                {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                        @endforeach
                    </select>                    
                </div>                                                                          
                <button type="submit" id="btnSave" class="btn btn-success mt-1">{{ trans('admin.save') }}</button>                                             
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-light">{{ trans('admin.cancel') }}</button>              
          </div>
        </div>
      </div>
    </div>
  </div>