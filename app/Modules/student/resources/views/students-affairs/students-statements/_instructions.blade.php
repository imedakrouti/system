<div class="form-group">
    <h5>Large Modal</h5>
    <p>Add class <code>.modal-lg</code> with <code>.modal-dialog</code>                            to use large size of modal.</p>
    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="modal fade text-left" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel17">{{ trans('student::local.instructions') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <ul>
                <li><strong>{{ trans('student::local.add_student_statement') }} : </strong> {{ trans('student::local.statement_instruction_1') }}</li>
                <li><strong>{{ trans('student::local.data_migration') }} : </strong> {{ trans('student::local.statement_instruction_2') }}
                    <ul>
                        <li>{{ trans('student::local.sub_statement_instruction_3') }}</li>
                    </ul>                
                </li>
                <li><strong>{{ trans('student::local.restore_migration') }} : </strong> {{ trans('student::local.statement_instruction_3') }}</li>
                <li><strong>{{ trans('student::local.set_migration') }} : </strong> {{ trans('student::local.statement_instruction_4') }}</li>
                <li><strong>{{ trans('admin.delete') }} : </strong> {{ trans('student::local.statement_instruction_5') }}
                    <ul>
                        <li>{{ trans('student::local.sub_statement_instruction_5') }}</li>
                    </ul>
                </li>                
            </ul>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">{{ trans('admin.cancel') }}</button>            
          </div>
        </div>
      </div>
    </div>
  </div>