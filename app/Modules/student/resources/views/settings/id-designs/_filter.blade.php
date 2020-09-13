<form action="{{route('id-designs.filter')}}" method="get" id="formSearch">
    @csrf
    <div class="row mb-1 mt-1">
        <div class="col-md-1">
            <a href="{{route('id-designs.create')}}" class="btn btn-success buttons-print btn-success ">{{ trans('student::local.new_id_design') }}</a>
        </div>
        <div class="col-md-2">
            <select name="division_id" class="form-control">
                @foreach ($divisions as $division)
                    <option {{request('division_id') == $division->id ? 'selected' : ''}} value="{{$division->id}}">
                        {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                @endforeach
            </select>
        </div>    
        <div class="col-md-2">
            <select name="grade_id" class="form-control" >
                @foreach ($grades as $grade)
                    <option {{request('grade_id') == $grade->id ? 'selected' : ''}} value="{{$grade->id}}">
                        {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                @endforeach
            </select>
        </div>
        <button id="filter" type="submit" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>
    </div>
  </form>