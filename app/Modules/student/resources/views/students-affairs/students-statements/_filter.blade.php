<form action="{{route('statistics.report')}}" method="get" id="filterForm">
    <div class="row mt-1">
        <div class="col-md-2">
            <select name="year_id" class="form-control" id="filter_year_id">
                <option value="">{{ trans('student::local.year') }}</option>
                @foreach ($years as $year)
                    <option {{currentYear() == $year->id ? 'selected' : ''}} value="{{$year->id}}">{{$year->name}}</option>                                    
                @endforeach
            </select>
        </div>        
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
            <select name="status_id" class="form-control" id="filter_status_id">
                <option value="">{{ trans('student::local.register_status_id') }}</option>
                @foreach ($regStatus as $status)
                    <option value="{{$status->id}}">{{session('lang') == 'ar' ? $status->ar_name_status : $status->en_name_status}}</option>                                    
                @endforeach
            </select>
        </div>    
        <button onclick="filter()" formaction="#" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>
        <button type="submit" formaction="{{route('statements.printStatement')}}" class="btn btn-warning btn-sm ml-1">{{trans('student::local.print_statement') }}</button>        
    </div>
</form>