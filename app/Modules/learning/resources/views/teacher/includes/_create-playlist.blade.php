<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="playlist" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-sm " role="document">
        <div class="modal-content">
          <div class="modal-header bg-info ">
            <h4 class="modal-title white" id="myModalLabel18"><i class="la la-youtube-play"></i> {{ trans('learning::local.new_playlist') }}</h4>
            <button type="button" class="close white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">              
            <form  action="{{route('teacher.store-playlists')}}" method="POST">
                @csrf
                <div class="col-lg-12">
                    <div class="form-group row">
                        <select name="subject_id" class="form-control">
                            @foreach (employeeSubjects() as $subject)
                                <option value="{{$subject->id}}">
                                    {{session('lang')=='ar' ? $subject->ar_name : $subject->en_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-9 col-md-9">
                        <div class="form-group">
                            <label>{{ trans('learning::local.playlist_name') }}</label>                            
                            <input type="text" class="form-control" name="playlist_name" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-3">
                        <div class="form-group">
                            <label>{{ trans('learning::local.sort') }}</label>
                            <input type="number" min="0"  name="sort" class="form-control" required>
                            <span class="red">{{ trans('staff::local.required') }}</span>                                                      
                        </div>
                    </div>

                </div>
                <hr>
                <div class="col-md-12">
                  <div class="form-group row">
                      {{-- <div class="col-md-4"></div> --}}
                      <div class="col-md-8">
                        <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>                   
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