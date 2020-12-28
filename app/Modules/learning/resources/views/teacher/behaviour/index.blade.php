@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}} | {{$class_name}}</h3>  
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">                      
            <li class="breadcrumb-item active">{{$title}}
            </li>
          </ol>
        </div>
      </div>          
    </div>  
    <div class="content-header-right col-md-6 col-12 mb-1">      
    <div class="btn-group mr-1 mb-1 float-right">
        <button type="button" class="btn btn-success btn-min-width dropdown-toggle round" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false"><i class="la la-plus"></i> {{ trans('learning::local.add_behaviour') }}</button>
        <div class="dropdown-menu">
            @foreach (employeeClassrooms() as $classroom)
                <a class="dropdown-item"  href="{{route('behaviour.create',['classroom_id'=> $classroom->id,'class_name' => $classroom->class_name])}}">{{ $classroom->class_name }}</a>                
            @endforeach        
        </div>            
    </div>   
  </div>  
</div>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-body">
          <div class="table-responsive">
              <table class="table" id="dynamic-table">
                <thead>
                  <tr>
                    <th>{{ trans('learning::local.student_name') }}</th>
                    @foreach ($months as $month)
                      <th>                                            
                          <div class="btn-group mr-1 mb-1">
                            <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true">{{ $month->month_name }}</button>
                            <div class="dropdown-menu">
                              <a class="dropdown-item" href="#"><i class="la la-edit"></i> {{ trans('admin.edit') }}</a>
                              <form action="{{route('behaviour.destroy')}}" method="post">
                                <input type="hidden" name="classroom_id" value="{{$classroom_id}}">
                                <input type="hidden" name="month_id" value="{{$month->id}}">
                                <input type="hidden" name="year_id" value="{{currentYear()}}">
                                @csrf
                                <button class="dropdown-item" ><i class="la la-trash"></i> {{ trans('admin.delete') }}</button>                            
                              </form>
                 
                            </div>
                          </div>
                      </th>                  
                    @endforeach              
                  </tr>
                </thead>
                <tbody>
                  @foreach ($students as $student)
                      <tr>
                          <td>
                              {{$student->student_name}}
                          </td>
                          @foreach ($student->behaviours as $item)                        
                              <td>
                                  {{$item->behaviour_mark}}                            
                              </td>                            
                          @endforeach
                      </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>
</div>
@endsection
