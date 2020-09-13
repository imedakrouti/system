<div class="form-group">     
  <!-- Modal -->
  <div class="modal fade text-left" id="addTest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
  aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel18"><i class="la la-plus"></i> {{ trans('student::local.add_test_result') }}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="post" id="formTest">
            @csrf
            <input type="hidden" name="assessment_id" value="{{$assessment->id}}">
              <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-md-4 label-control">{{ trans('student::local.assessment_type') }}</label>
                    <div class="col-md-8">
                      <select name="acceptance_test_id" required class="form-control" style="margin-left: 10px;margin-top:0px">
                        <option value="">{{ trans('student::local.subject_name') }}</option>
                        @foreach ($tests as $test)
                            <option value="{{$test->id}}">{{$test->ar_test_name}}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
              </div>  
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-md-4 label-control">{{ trans('student::local.evaluation') }}</label>
                  <div class="col-md-8">
                    <select name="test_result" required class="form-control" style="margin-left: 10px;margin-top:0px">
                        <option value="">{{ trans('student::local.evaluation') }}</option>
                        <option value="excellent">{{ trans('student::local.excellent') }}</option>
                        <option value="very good">{{ trans('student::local.very_good') }}</option>
                        <option value="good">{{ trans('student::local.good') }}</option>
                        <option value="weak">{{ trans('student::local.weak') }}</option>
                    </select>
                  </div>
                </div>
            </div> 
            <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-md-4 label-control">{{ trans('student::local.employee_name') }}</label>
                  <div class="col-md-8">
                    <select name="employee_id" required class="form-control" style="margin-top: 10px;">
                        <option value="">{{ trans('student::local.teacher_name') }}</option>
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->arEmployeeName}}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
            </div>                   
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSave" class="btn btn-success">{{ trans('admin.save') }}</button>              
        </div>
      </div>
    </div>
  </div>
</div>