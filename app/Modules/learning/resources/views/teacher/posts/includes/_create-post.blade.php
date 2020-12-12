<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="create-post-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-share-alt"></i> {{ trans('learning::local.create_post') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">                          
            <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data" id="form_post">
                @csrf   
                <input type="hidden" name="classroom_id[]" value="{{$classroom->id}}">                       
                <input type="hidden" name="post_type" value="post">                       
                <textarea required name="post_text" class="form-control" cols="30" rows="5" id="ckeditor"
                 placeholder="{{ trans('learning::local.share_classroom') }}"></textarea>
                 <div id="file_name"></div>
                 <div id="url-link"></div>
                 <div id="youtube-url"></div>

                 @include('learning::teacher.posts.includes._upload-file')                                    
                 @include('learning::teacher.posts.includes._link')                                    
                 @include('learning::teacher.posts.includes._youtube-url')                                    
                <div class="form-control">
                    <label>{{ trans('learning::local.share_with_class') }}</label>
                    <select name="classroom_id[]" class="form-control select2" multiple>
                            @foreach (employeeClassrooms() as $class)
                                @if ($class->id != $classroom->id)
                                    <option value="{{$class->id}}">
                                        {{session('lang') == 'ar'? $class->ar_name_classroom : $class->en_name_classroom}}
                                    </option>                                
                                @endif
                            @endforeach
                    </select>           
                </div>                               
                 
                 <hr>
                <div class="form-group mt-1">
                    <div class="btn-group mr-1 mb-1">
                        <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">{{ trans('learning::local.attachments') }}</button>
                        <div class="dropdown-menu">
                            <a onclick="uploadFile()" class="dropdown-item" href="#"><i class="la la-upload"></i> {{ trans('learning::local.upload_file') }}</a>                                    
                            <a onclick="link()" class="dropdown-item" href="#"><i class="la la-external-link"></i> {{ trans('learning::local.link') }}</a>                                    
                            <a onclick="youtubeURL()" class="dropdown-item" href="#"><i class="la la-youtube"></i> {{ trans('learning::local.youtube_url') }}</a>                                                        
                        </div>                                
                        <button type="submit" class="btn btn-success btn-sm ml-1">{{ trans('learning::local.post') }}</button>
                    </div>
                    <button onclick="cancel()" data-dismiss="modal" class="btn btn-light btn-sm {{session('lang') == 'ar' ? 'pull-left' : 'pull-right'}}">{{ trans('learning::local.cancel') }}</button>
                </div>    
                
            </form>                                                         
          </div>        
        </div>
      </div>
    </div>
</div>
