@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>  
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">                      
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>          
    </div>     
</div>
<div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
            <form action="{{route('absences.store')}}" method="post">                
                <button type="submit" class="btn btn-success mb-1 float-right">{{ trans('admin.save') }}</button>                
                @csrf
                <div class="table-responsive">
                    <table class="table" id="dynamic-table">
                      <thead>
                        <tr class="center">
                          <th>{{ trans('learning::local.student_name') }}</th>
                          @foreach ($period as $value)
                              <th>{{date('l', strtotime($value->format('d-m-Y')))}} <br> {{$value->format('d-m-Y')}}</th>
                          @endforeach
                        </tr>
                      </thead>
                      <tbody>
                          @foreach ($students as $student)
                              <tr>
                                  <td>{{$student->student_name}}</td>                                  
                                  @foreach ($period as $value)
                                    <td>
                                        <input type="checkbox" class="form-control" name="data[]" value="[{{$student->id}}] {{$value->format('d-m-Y')}}">
                                    </td>
                                  @endforeach
                              </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
@endsection