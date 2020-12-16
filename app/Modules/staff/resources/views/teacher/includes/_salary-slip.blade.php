<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="salary-slip-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18"><i class="la la-money"></i>
                        {{ trans('staff::local.salary_slip') }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="salary_slip">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
