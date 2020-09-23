<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">{{ trans('student::local.join_student') }}</h4>
        <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
      </div>
      
      <div class="card-content collapse show">
        <div class="card-body card-dashboard">
          <form class="form form-horizontal" action="" method="post" id="form">
            @csrf
            <div class="col-md-12">
              <input type="hidden" name="commissioner_id" value="{{$commissioner->id}}">
              <div class="form-group row">
                  <label class="col-md-1 label-control">{{ trans('student::local.student_name') }}</label>
                  <div class="col-md-3">                         
                      <select name="student_id" class="form-control select2">                          
                        @foreach ($students as $student)
                            @if (session('lang') == 'ar')
                            <option value="{{$student->id}}">
                              [ {{$student->student_number}} ] {{$student->ar_student_name}} {{$student->father->ar_st_name}}
                            {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}
                            </option>    
                            @else
                            <option value="{{$student->id}}">
                              [ {{$student->student_number}} ] {{$student->en_student_name}} {{$student->father->en_st_name}}
                            {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}
                            </option> 
                            @endif
                        @endforeach
                      </select>
                  </div>
              </div>
            </div>
            <div class="form-actions left">
                <button id="btnSave" class="btn btn-success">
                    <i class="la la-check-square-o"></i> {{ trans('admin.add') }}
                  </button>                  
            </div>                
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
