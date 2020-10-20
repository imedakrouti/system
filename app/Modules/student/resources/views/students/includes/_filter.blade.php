<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <form action="#" method="get" id="filterForm" >
                <div class="row mt-1">      
                    <div class="col-lg-2 col-md-6">
                        <select name="division_id" class="form-control" id="filter_division_id">
                            <option value="">{{ trans('student::local.divisions') }}</option>
                            @foreach ($divisions as $division)
                                <option value="{{$division->id}}">
                                    {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <select name="grade_id" class="form-control" id="filter_grade_id">
                            <option value="">{{ trans('student::local.grades') }}</option>
                            @foreach ($grades as $grade)
                                <option value="{{$grade->id}}">
                                    {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                            @endforeach
                        </select>
                    </div>
            
                    <div class="col-lg-2 col-md-6">
                        <select name="status_id" class="form-control" id="filter_status_id">
                            <option value="">{{ trans('student::local.register_status_id') }}</option>
                            @foreach ($regStatus as $status)
                                <option value="{{$status->id}}">{{session('lang') == 'ar' ? $status->ar_name_status : $status->en_name_status}}</option>                                    
                            @endforeach
                        </select>
                    </div>  
                    <div class="col-lg-2 col-md-6">
                        <select name="student_type" class="form-control" id="filter_student_type">
                            <option value="">{{ trans('student::local.student_type') }}</option>
                            <option value="applicant">{{ trans('student::local.applicant') }}</option>
                            <option value="student">{{ trans('student::local.student') }}</option>
            
                        </select>
                    </div> 
                    <div class="col-lg-2 col-md-6">
                        <button onclick="filter()" formaction="#" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>                                      
                    </div>   
                </div>
            </form>
            
          </div>
        </div>
      </div>
    </div>
</div>