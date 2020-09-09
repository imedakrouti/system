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
        <div class="card-header">
          <h4 class="card-title">{{$title}}</h4>
          <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
          @include('student::settings.id-designs._filter')
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">            
                <div class="row">
                  @if (count($designs) > 0)
                    @foreach ($designs as $design)
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                            <div class="card-content">
                                <a href="{{$design->link}}"><img class="card-img-top img-fluid" src="{{asset('storage/id-designs/'.$design->design_name)}}"
                                alt="Card image cap"></a>
                                <div class="card-body">                                
                                <p>                                    
                                    <strong>{{ trans('student::local.division') }}</strong> : 
                                    {{session('lang') == trans('admin.ar') ? $design->division->ar_division_name : $design->division->en_division_name}} <br>
                                    <strong>{{ trans('student::local.grade') }}</strong> : 
                                    {{session('lang') == trans('admin.ar') ? $design->grade->ar_grade_name : $design->grade->en_grade_name}}
                                    
                                </p>

                                <form action="{{route('id-designs.destroy',$design->id)}}" method="post" class="formData">
                                    @csrf
                                    @method('DELETE')                                    
                                    <a href="{{route('id-designs.edit',$design->id)}}"class="btn btn-warning btn-sm ">{{ trans('student::local.editing') }}</a>
                                    <button id="btnDelete" type="submit" class="btn btn-danger btn-sm ">{{ trans('admin.delete') }}</button>
                                </form>

                                </div>
                            </div>
                            </div>
                        </div>
                    @endforeach                      
                  @else
                      <div class="col-md-12">
                        <div class="alert alert-danger">
                          <h5>{{ trans('student::local.no_results') }}</h5>
                        </div>
                      </div>
                  @endif

                </div>
                {{$designs->links()}}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script>
   $(".formData").submit(function(e){
        event.preventDefault();        
        swal({
            title: "{{trans('msg.delete_confirmation')}}",
            text: "{{trans('student::local.design_delete_ask')}}",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "{{trans('msg.yes')}}",
            cancelButtonText: "{{trans('msg.no')}}",
            closeOnConfirm: false
            },
            function(){
                $(".formData").submit();
        });       
    });

    $("#filter").click(function() {
       $('#formSearch').submit();
    });

</script>

@endsection