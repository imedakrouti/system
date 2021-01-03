@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}} | {{$class_name}} | {{fullAcademicYear()}}</h3>  
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

<div class="row mt-1">
    <div class="col-lg-12 col-md-12">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            @include('layouts.backEnd.includes._msg')
            <ul class="list-group">
                @foreach (employeeSubjects() as $index => $subject) 
                    <li class="list-group-item">                                                      
                        <a style="color: #7f888f;font-size:20px;font-weight:800" href="{{route('behaviour.index',['classroom_id'=> $classroom_id])}}">
                         {{$index + 1}} - {{$subject->subject_name}}</a>
                        <br>
                        @foreach ($subject->behaviours as $item) 
                            @if ($item->classroom_id == $classroom_id)
                                <div class="mb-1 badge badge-info">
                                    <span>{{$item->month}}</span>
                                    <i class="la la-calendar font-medium-3"></i>
                                </div>                            
                            @endif                         
                        @endforeach
                    </li>
              @endforeach  
            </ul>
          </div>
        </div>
      </div>
  </div>
</div>
@endsection