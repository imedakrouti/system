<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="addToArchive" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-plus"></i> {{ trans('student::local.add_to_archive') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              
            <form action="{{route('archives.store')}}" enctype="multipart/form-data" method="post" id="frm">
              @csrf
                <input type="hidden" name="student_id" value="{{$student->id}}">
              <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-md-3 label-control">{{ trans('student::local.document_name') }}</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control " value="{{old('document_name')}}" 
                        placeholder="{{ trans('student::local.document_name') }}"
                        name="document_name" required>
                        <span class="red">{{ trans('student::local.requried') }}</span>
                    </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                      <label class="col-md-3 label-control" >{{ trans('student::local.attachements') }}</label>
                      <div class="col-md-9">                    
                        <input  type="file" name="file_name"/ required>
                        <span class="red">{{ trans('student::local.requried') }}</span>                            
                      </div>
                    </div>
                </div>  
                <div class="col-md-12">
                  <div class="form-group row">                      
                      <div class="col-md-8">
                        <button type="submit" id="btnMoveToClass" class="btn btn-success">{{ trans('admin.save') }}</button>                   
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