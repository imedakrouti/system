<div class="form-group">     
    <!-- Modal -->
    <div class="modal fade text-left" id="set_dates" tabindex="-1" role="dialog" aria-labelledby="myModalLabel18"
    aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel18"><i class="la la-calendar"></i> {{ trans('learning::local.attendance') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">  
              <form action="{{route('absences.create')}}" method="get">
                <div class="col-md-12">
                    <div class="form-group">
                        <select name="classroom_id" class="form-control" required>                            
                            @foreach ( employeeClassrooms() as $classroom)
                                <option value="{{$classroom->id}}">{{$classroom->class_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('learning::local.start_in') }}</label>
                        <input type="date" class="form-control" name="start_in" required>    
                    </div>
                </div>           
                <div class="col-md-12">
                    <div class="form-group">
                        <label>{{ trans('learning::local.end_in') }}</label>
                        <input type="date" class="form-control" name="end_in" required>    
                    </div>
                </div>   
                <div class="col-md-12">
                    <div class="form-group">
                        <button type="submit" class="btn btn-info">{{ trans('learning::local.ok') }}</button>
                    </div>
                </div> 
            </form>
          </div>        
        </div>
      </div>
    </div>
</div>