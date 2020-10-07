<form action="#" method="get" id="filterForm" target="_blank">
    <div class="row mt-1">
        <div class="col-md-2">
            <select name="year_id" class="form-control select2" id="filter_year_id" required>                
                @foreach ($years as $year)
                    <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                    
                @endforeach
            </select>
        </div>        
        <div class="col-md-2">
            <select name="division_id[]" class="form-control select2" multiple id="filter_division_id" required>
                {{-- <option value="">{{ trans('student::local.divisions') }}</option> --}}
                @foreach ($divisions as $division)
                    <option value="{{$division->id}}">
                        {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="grade_id" class="form-control select2" id="filter_grade_id">                
                @foreach ($grades as $grade)
                    <option value="{{$grade->id}}">
                        {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="status_id" class="form-control select2" id="filter_status_id">
                <option value="">{{ trans('student::local.register_status_id') }}</option>
                @foreach ($regStatus as $status)
                    <option value="{{$status->id}}">{{session('lang') == 'ar' ? $status->ar_name_status : $status->en_name_status}}</option>                                    
                @endforeach
            </select>
        </div>    
        <button onclick="filter()" formaction="#" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>        
        <div class="btn-group ml-1">
            <button type="button" class="btn btn-primary btn-min-width dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="true">{{ trans('student::local.reports') }}</button>
            <div class="dropdown-menu">
              <a onclick="printStatement()" class="dropdown-item" href="#">{{trans('student::local.print_statement') }}</a>              
              <a onclick="statistics()" class="dropdown-item" href="#">{{trans('student::local.print_statistics') }}</a>                            
            </div>
        </div>
        <button type="button" class="btn btn-info btn-min-width ml-1" data-toggle="modal" data-target="#large">
          {{ trans('student::local.instructions') }}
        </button>        
    </div>
</form>