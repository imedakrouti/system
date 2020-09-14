@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.admission')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('assessment-result.index')}}">{{ trans('student::local.assessment_results') }}</a></li>
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
            <div class="card-body">
                <h3 class="mb-2">
                    @if (session('lang') == 'ar')
                    <a href="{{route('students.show',$assessment->students->id)}}">{{$assessment->students->ar_student_name}} 
                      {{$assessment->students->father->ar_st_name}} {{$assessment->students->father->ar_nd_name}} {{$assessment->students->father->ar_rd_name}}</a>
                    @else
                    <a href="{{route('students.show',$assessment->students->id)}}">{{$assessment->students->en_student_name}} 
                      {{$assessment->students->father->en_st_name}} {{$assessment->students->father->en_nd_name}} {{$assessment->students->father->en_rd_name}}</a> 
                    @endif
                </h3>
                <h5><strong>{{ trans('student::local.grade') }}</strong> : {{session('lang') == 'ar' ?$assessment->students->grade->ar_grade_name:$assessment->student->grade->en_grade_name}}</h5>
                <h5><strong>{{ trans('student::local.division') }}</strong> : {{session('lang') == 'ar' ?$assessment->students->division->ar_division_name:$assessment->students->division->en_division_name}}</h5>
                <h5><strong>{{ trans('student::local.application_date') }}</strong> : {{$assessment->students->application_date}}</h5>
            </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
  <div class="col-12">
  <div class="card">
      <div class="card-content collapse show">
          <div class="card-body">    
            <form action="{{route('assessment-result.update',$assessment->id)}}" method="post">
              @csrf
              @method('PUT')
              <div class="col-md-9">
                <div class="form-group row">
                  <label class="col-md-1 label-control"><strong>{{ trans('student::local.assessment_type') }}</strong></label>
                  <div class="col-md-4">
                    <select name="assessment_type" class="form-control" required>
                      <option {{old('assessment_type' ,$assessment->assessment_type) == trans('student::local.assessment') ? 'selected' : ''}} value="assessment">{{ trans('student::local.assessment') }}</option>
                      <option {{old('assessment_type' ,$assessment->assessment_type) == trans('student::local.re_assessment') ? 'selected' : ''}} value="re-assessment">{{ trans('student::local.re_assessment') }}</option>
                    </select>
                  </div>
                </div>
              </div> 
              <div class="col-md-9">
                <div class="form-group row">
                  <label class="col-md-1 label-control"><strong>{{ trans('student::local.acceptance') }}</strong></label>
                  <div class="col-md-4">
                    <select name="acceptance" class="form-control" required>
                      <option {{old('acceptance' ,$assessment->acceptance) == trans('student::local.accepted') ? 'selected' : ''}} value="accepted">{{ trans('student::local.accepted') }}</option>
                      <option {{old('acceptance' ,$assessment->acceptance) == trans('student::local.rejected') ? 'selected' : ''}} value="rejected">{{ trans('student::local.rejected') }}</option>
                    </select>                    
                  </div>
                </div>
              </div>   
              <h5 class="mb-1"><strong> {{ trans('student::local.assessmentDate') }}</strong> :{{$assessment->created_at}}</h5>
              <h5 class="mb-2"><strong> {{ trans('student::local.notes') }}</strong> :{{$assessment->notes}}</h5>
              <button class="btn btn-warning btm-sm">{{ trans('student::local.update') }}</button>                          
            </form>                 
          </div>
      </div>
  </div>
  </div>
</div>
<div class="row">
  <div class="col-12">
  <div class="card">
      <div class="card-content collapse show">
          <div class="card-body">                                
              <a href="#" class="btn btn-success mb-1" data-toggle="modal" data-target="#addTest">
                {{ trans('student::local.add_test_result') }}
              </a>
              <a href="#" id="btnDelete" class="btn btn-danger mb-1">{{ trans('admin.delete') }}</a>
              <a href="{{route('print-testReport.pdf',$assessment->id)}}" id="btnDelete" class="btn btn-info mb-1">{{ trans('admin.print') }}</a>
              <div class="table-responsive">
                <form action="" method="POST" id="formData">
                  @csrf
                  <table class="table">
                    <thead>                        
                      <th class="">{{ trans('student::local.subject_name') }}</th>
                      <th class="center">{{ trans('student::local.evaluation') }}</th>
                      <th class="center">{{ trans('student::local.teacher_name') }}</th>
                    </thead>
                    <tbody>
                      @foreach ($assessment->tests as $test)
                        <tr>                                                        
                          <td>
                            <label class="pos-rel">
                              <input type="checkbox" class="ace" name="id[]" value="{{$test->id}}">
                              <span class="lbl"></span>{{session('lang') == 'ar' ?$test->acceptTest->ar_test_name : $test->acceptTest->en_test_name}}
                          </label> 
                          </td>
                          <td class="center">{{$test->test_result}}</td>
                          <td class="center">{{$test->employee->arEmployeeName}}</td>
                        </tr>                                                
                      @endforeach                      
                    </tbody>
                  </table>
                </form>
              </div>
          </div>
      </div>
  </div>
  </div>
</div>

@include('student::admissions.assessment-results._test-model')

@endsection
@section('script')
    <script>
        $('#btnDelete').on('click',function(){         
          var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
          if (itemChecked > 0) {
              var form_data = $('#formData').serialize();
              swal({
                      title: "{{trans('msg.delete_confirmation')}}",
                      text: "{{trans('msg.delete_ask')}}",
                      showCancelButton: true,
                      confirmButtonColor: "#D15B47",
                      confirmButtonText: "{{trans('msg.yes')}}",
                      cancelButtonText: "{{trans('msg.no')}}",
                      closeOnConfirm: false,
                  },
                  function() {
                      $.ajax({
                          url:"{{route('test.destroy')}}",
                          method:"POST",
                          data:form_data,
                          dataType:"json",
                          // display succees message
                          success:function(data)
                          {
                            location.reload();
                          }
                      })                      
                    
                  }
              );
          }	else{
              swal("{{trans('msg.delete_confirmation')}}", "{{trans('msg.no_records_selected')}}", "info");
          }          
        })

        $('#btnSave').on('click',function(event){
          event.preventDefault();
          var form_data = $('#formTest').serialize();
          $.ajax({
                url:"{{route('test.store')}}",
                method:"POST",
                data:form_data,
                dataType:"json",
                // display succees message
                success:function(data)
                {
                  location.reload();
                },
                // display validations error in page
                error:function(data_error,exception){
                  if (exception == 'error'){
                    $('.classModal').show();
                    $.each(data_error.responseJSON.errors,function(index,value){
                      $('.classModal ul').append("<li>"+ value +"</li>");
                    })
                  }
                  else{
                    $('.classModal').hide();
                  }
                }
              })
          // end swal
        })
    </script>
@endsection
