<form action="{{route('cards.selected-students')}}" method="get" id="filterForm" target="_blank">
    <div class="row mt-1">       
        <div class="col-lg-2 col-md-3">
            <select style="width: 100%" name="division_id" class="form-control select2" id="filter_division_id">
                <option value="">{{ trans('student::local.divisions') }}</option>
                @foreach ($divisions as $division)
                    <option value="{{$division->id}}">
                        {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-3">
            <select style="width: 100%" name="grade_id" class="form-control select2" id="filter_grade_id">
                <option value="">{{ trans('student::local.grades') }}</option>
                @foreach ($grades as $grade)
                    <option value="{{$grade->id}}">
                        {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                @endforeach
            </select>
        </div>
        <div class="col-lg-2 col-md-3">
            <select style="width: 100%" name="filter_classroom_id" class="form-control select2" id="filter_classroom_id" disabled>
                <option value="">{{ trans('student::local.classrooms') }}</option>                    
              </select>
        </div>
        <div class="col-lg-2 col-md-3">
            <button onclick="filter()" formaction="#" class="btn btn-primary btn-sm"><i class="la la-search"></i></button>    
        </div>        
    </div>
    <div class="row mt-1">                                     
        <div class="col-lg-3 col-md-8 btn-group">
            <button formaction="{{route('cards.all-students')}}" class="btn btn-purple btn-md mr-2">{{trans('student::local.all_students') }}</button>
            <button style="width: 100%" type="button" class="btn btn-primary btn-min-width dropdown-toggle" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="true">{{ trans('student::local.students_no_photo') }}</button>
            <div class="dropdown-menu">
                <a onclick="noPhotoGrade()" class="dropdown-item" href="#">{{trans('student::local.with_grade') }}</a>                            
                <a onclick="noPhotoClass()" class="dropdown-item" href="#">{{trans('student::local.with_class') }}</a>              
            </div>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col-lg-4 col-md-6">
            <select style="width: 100%" name="student_id" class="form-control select2" id="filter_student_id">
                <option value="">{{ trans('student::local.select_student') }}</option>
                @foreach ($students as $student)
                    <option value="{{$student->id}}">
                        {{session('lang') =='ar' ? '['.$student->student_number.'] '. $student->ar_student_name 
                        . ' ' .$student->father->ar_nd_name. ' ' .$student->father->ar_rd_name:
                        '['.$student->student_number.'] '. $student->en_student_name 
                        . ' ' .$student->father->en_nd_name. ' ' .$student->father->en_rd_name
                       }}</option>                                    
                @endforeach
            </select>
        </div>
    </div>
</form>