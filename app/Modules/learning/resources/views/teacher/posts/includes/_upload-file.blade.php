<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="upload-file-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel18" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18"><i class="la la-upload"></i>
                        {{ trans('learning::local.upload_file') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <input type="file" class="form-control" name="file_name" id="file-name"
                            accept=".png, .jpg, .jpeg , .dox, .docx, .pdf, .xls, .xlsx, .ppt, .pptx">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            {{-- <div class="col-md-4"></div>
                            --}}
                            <div class="col-md-8">
                                <button type="button" onclick="getFile()"
                                    class="btn btn-success">{{ trans('admin.add') }}</button>
                                <button type="button" onclick="closeUploadFile()"
                                    class="btn btn-light">{{ trans('admin.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
