<div class="form-group">
    <!-- Modal -->
    <div class="modal fade text-left" id="youtube-url-modal" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel18" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel18"><i class="la la-youtube"></i>
                        {{ trans('learning::local.youtube_url') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <input type="text" class="form-control" name="youtube_url" id="url">
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <h6 id="video_url" class="center"><i class="la la-youtube"></i>
                                {{ trans('learning::local.video_url') }}</h6>
                            <iframe id="youtube" class="hidden" width="100%" style="min-height: 500px;" allowfullscreen
                                src="">
                            </iframe>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            {{-- <div class="col-md-4"></div>
                            --}}
                            <div class="col-md-8">
                                <button type="button" onclick="getUrl()"
                                    class="btn btn-success">{{ trans('admin.add') }}</button>
                                <button type="button" onclick="closeYoutubeModal()"
                                    class="btn btn-light">{{ trans('admin.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
