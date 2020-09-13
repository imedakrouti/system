<div class="row mt-1">
    <div class="col-md-2">
        <select name="division_id" class="form-control" id="division_id">
            @foreach ($divisions as $division)
                <option {{old('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                    {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="grade_id" class="form-control" id="grade_id">
            @foreach ($grades as $grade)
                <option {{old('grade_id') == $grade->id ? 'selected' : ''}} value="{{$grade->id}}">
                    {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <select name="year_id" class="form-control" id="year_id">
            @foreach ($years as $year)
                <option {{old('year_id') == $year->id ? 'selected' : ''}} value="{{$year->id}}">
                    {{$year->name}}</option>                                    
            @endforeach
        </select>
    </div>
    <button id="filter" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>
</div>