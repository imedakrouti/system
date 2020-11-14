@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._staff')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.staff')}}">{{ trans('admin.dashboard') }}</a></li>
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
        </div>
        <div class="card-content collapse show">
          <div class="card-body card-dashboard">
            <div class="form-group">
              <a href="{{route('announcements.create')}}" class="btn btn-success"><i class="la la-plus"></i> {{ trans('staff::local.new_announcement') }}</a>
              <a href="#" onclick="submit()" class="btn btn-danger"><i class="la la-trash"></i> {{ trans('admin.delete') }}</a>
            </div>
            @if (count($announcements) > 0)
                <form action="{{route('announcements.destroy')}}" method="POST" id="formData">
                  @csrf
                  @foreach ($announcements as $announcement)              
                      <div class="col-lg-12 col-md-12">
                        <div class="card box-shadow-0 border-info bg-transparent">
                          <div class="card-header bg-transparent">
                            <h4 class="card-title">
                              <label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="{{$announcement->id}}">
                                <span class="lbl"></span> 
                                  {{session('lang') == 'ar' ? $announcement->admin->ar_name : $announcement->admin->name}} | 
                                  <span class="blue" style="font-size: 12px;">{{$announcement->updated_at->diffForHumans()}}</span>
                              </label>                           
                            </h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                              <ul class="list-inline mb-0">
                                <li><a href="{{route('announcements.edit',$announcement->id)}}"><i class="la la-edit"></i></a></li>                 
                              </ul>
                            </div>
                          </div>
                          <div class="card-content collapse show">
                            <div class="card-body">                                                                                                               
                              <p class="card-text">{!!$announcement->announcement!!}</p>
                              <span class="black" style="font-size: 13px;">
                                <strong>{{ trans('staff::local.apper_to') }}</strong> :  {{$announcement->domain_role}} |
                              <strong> {{ trans('staff::local.start_at') }}</strong> : {{$announcement->start_at}} | 
                                <strong>{{ trans('staff::local.end_at') }} </strong>: {{$announcement->end_at}}
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>                
                  @endforeach
                </form>                 
            @else
                <div class="col-lg-12 col-md-12">
                    <div class="card box-shadow-0 border-info bg-transparent">
                    <div class="card-content collapse show">
                        <div class="card-body">                                                                                                               
                        <p class="card-text">{{ trans('staff::local.no_announcements') }}</p>                     
                        </div>
                    </div>
                    </div>
                </div>
            @endif
              {{$announcements->links()}}
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
@section('script')
<script>
function submit()
{
  event.preventDefault();
       swal({
           title: "{{trans('msg.delete_confirmation')}}",
           text: "{{trans('msg.delete_ask')}}",
           type: "warning",
           showCancelButton: true,
           confirmButtonClass: "btn-danger",
           confirmButtonText: "{{trans('msg.yes')}}",
           cancelButtonText: "{{trans('msg.no')}}",
           closeOnConfirm: false
           },
           function(){
               $("#formData").submit();
       });
}
</script>
@endsection
