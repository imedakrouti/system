<div class="row mt-1">
    <div class="col-md-2">
        <select name="stage_id" class="form-control" id="stage_id">
            @foreach ($stages as $stage)
                <option {{old('stage_id') == $stage->id ? 'selected' : ''}} value="{{$stage->id}}">
                    {{session('lang') =='ar' ?$stage->ar_stage_name:$stage->en_stage_name}}</option>                                    
            @endforeach
        </select>
    </div>
    <button id="filter" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>
</div>