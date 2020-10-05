<form action="{{route('cards.selected-students')}}" method="get" id="filterForm" >
    <div class="row mt-1">       
        <div class="col-md-2">
            <select name="division_id" class="form-control" id="filter_division_id">
                <option value="">{{ trans('student::local.divisions') }}</option>
                @foreach ($divisions as $division)
                    <option value="{{$division->id}}">
                        {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="grade_id" class="form-control" id="filter_grade_id">
                <option value="">{{ trans('student::local.grades') }}</option>
                @foreach ($grades as $grade)
                    <option value="{{$grade->id}}">
                        {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="filter_classroom_id" class="form-control" id="filter_classroom_id" disabled>
                <option value="">{{ trans('student::local.classrooms') }}</option>                    
              </select>
        </div>        
  
        <button onclick="filter()" formaction="#" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>        
        <button formaction="{{route('cards.all-students')}}" class="btn btn-purple btn-sm ml-1">{{trans('student::local.all_students') }}</button>                     
    </div>
</form>