<div class="row mt-1">
    <div class="col-lg-2 col-md-3">
        <select name="division_id" class="form-control" id="division_id">
            @foreach ($divisions as $division)
                <option {{old('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                    {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
            @endforeach
        </select>
    </div>
    <div class="col-lg-2 col-md-3">
        <select name="grade_id" class="form-control" id="grade_id">
            @foreach ($grades as $grade)
                <option {{old('grade_id') == $grade->id ? 'selected' : ''}} value="{{$grade->id}}">
                    {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
            @endforeach
        </select>
    </div>    
    <div class="col-lg-2 col-md-3">
        <button id="filter" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>
    </div>
</div>