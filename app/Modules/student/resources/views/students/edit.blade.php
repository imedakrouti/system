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
            <li class="breadcrumb-item"><a href="{{route('students.index')}}">{{ trans('student::local.students') }}</a></li>
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
            <form class="form form-horizontal" method="POST" action="{{route('students.update',$student->id)}}" enctype="multipart/form-data">            
                @csrf
                @method('put')
                <div class="form-body">                    
                    @include('layouts.backEnd.includes._msg')
                    @include('student::students._edit-form')                    
                </div>
                <div class="form-actions left">
                    <button type="submit" class="btn btn-success">
                        <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                      </button>
                    <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('students.show',$student->id)}}';">
                    <i class="ft-x"></i> {{ trans('admin.cancel') }}
                  </button>
                </div>
              </form>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
@section('script')

<script>
$(document).ready(function(){
  (function getDocumentSelected()
    {
      var id = "{{$student->id}}";
      
        $.ajax({
          type:'POST',
          url:'{{route("getDocumentSelected")}}',
      data: {
          _method : 'PUT',
          id      : id,
          _token  : '{{ csrf_token() }}'
        },
          dataType:'json',
          success:function(data){
            $('#documentId').html(data);
          }
        });
    }());

    (function getStepsSelected()
    {
      var id = "{{$student->id}}";
      
        $.ajax({
          type:'POST',
          url:'{{route("getStepsSelected")}}',
      data: {
          _method : 'PUT',
          id      : id,
          _token  : '{{ csrf_token() }}'
        },
          dataType:'json',
          success:function(data){
            $('#stepId').html(data);
          }
        });
    }());
})
</script>
<script src="{{asset('public/cpanel/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{asset('public/cpanel/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
@section('script')
    <script>
      $('#dob').on('change',function(){        
        var dob    = $('#dob').val();
        $.ajax({
          type:'POST',
          url:'{{route("student.age")}}',
          data: {
              _method     : 'PUT',
              dob         : dob,              
              _token      : '{{ csrf_token() }}'
          },
          success:function(response){
            $('#dd').val(response.data.dd);
            $('#mm').val(response.data.mm);
            $('#yy').val(response.data.yy);            
          }
        })
      })    
      $(document).ready(function(){
        (function(){
          var dob    = "{{$student->dob}}";
              $.ajax({
                type:'POST',
                url:'{{route("student.age")}}',
                data: {
                    _method     : 'PUT',
                    dob         : dob,              
                    _token      : '{{ csrf_token() }}'
                },
                success:function(response){
                  $('#dd').val(response.data.dd);
                  $('#mm').val(response.data.mm);
                  $('#yy').val(response.data.yy);            
                }
              })
        }())
      })      
    </script>
@endsection
