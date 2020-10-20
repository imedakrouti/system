<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <form action="#" method="get" id="filterForm" >
                <div class="row mt-1">      
                    <div class="col-lg-2 col-md-6">
                        <select name="sector_id" class="form-control" id="filter_sector_id">
                            <option value="">{{ trans('staff::local.sectors') }}</option>
                            @foreach ($sectors as $sector)
                                <option value="{{$sector->id}}">
                                    {{session('lang') =='ar' ?$sector->ar_sector:$sector->en_sector}}</option>                                    
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <select name="department_id" class="form-control" id="filter_department_id">
                            <option value="">{{ trans('staff::local.departments') }}</option>
                         
                        </select>
                    </div>
            
                    <div class="col-lg-2 col-md-6">
                        <select name="section_id" class="form-control" id="filter_section_id">
                            <option value="">{{ trans('staff::local.sections') }}</option>
                            @foreach ($sections as $section)
                                <option value="{{$section->id}}">
                                    {{session('lang') =='ar' ?$section->ar_section:$section->en_section}}</option>                                    
                            @endforeach
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-6">
                        <select name="position_id" class="form-control" id="filter_position_id">
                            <option value="">{{ trans('staff::local.positions') }}</option>
                            @foreach ($positions as $position)
                                <option value="{{$position->id}}">
                                    {{session('lang') =='ar' ?$position->ar_position:$position->en_position}}</option>                                    
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <select name="leaved" class="form-control" id="filter_leaved">
                            <option value="">{{ trans('staff::local.leaved') }}</option>
                            <option value="no">{{ trans('staff::local.no') }}</option>
                            <option value="yes">{{ trans('staff::local.yes') }}</option>
            
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