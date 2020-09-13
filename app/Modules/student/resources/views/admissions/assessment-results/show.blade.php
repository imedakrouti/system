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
                <h5><strong>{{ trans('student::local.application_date') }} : {{$assessment->students->application_date}}</strong></h5>
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
              <h5 class="mb-1"><strong> {{ trans('student::local.assessmentDate') }}</strong> :{{$assessment->created_at}}</h5>
              <h5 class="mb-1"><strong> {{ trans('student::local.assessment_type') }}</strong> :{{$assessment->assessment_type}}</h5>
              <h5 class="mb-1"><strong> {{ trans('student::local.acceptance') }}</strong> :{{$assessment->acceptance}}</h5>
              <h5 class="mb-2"><strong> {{ trans('student::local.notes') }}</strong> :{{$assessment->notes}}</h5>
                            
              <a href="#" class="btn btn-success mb-1" data-toggle="modal" data-target="#defaultSize">
                {{ trans('student::local.add_test_result') }}
              </a>
              <a href="#" id="btnDelete" class="btn btn-danger mb-1">{{ trans('admin.delete') }}</a>
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
                              <span class="lbl"></span> {{$test->acceptTest->ar_test_name}}
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
    </script>
@endsection
