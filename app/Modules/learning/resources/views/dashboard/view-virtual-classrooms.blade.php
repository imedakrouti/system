@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">      
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>            
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
              <div class="card-body card-dashboard"> 
                <div class="table-responsive">
                    <h4><strong>{{ trans('staff::local.today_virtual_classes') }}</strong> | {{\Carbon\Carbon::today()->format('d-m-Y')}}</h4>              
                    
                    <table class="table table-hover">
                        <thead>
                            <tr class="center">
                                <th colspan="2">{{ trans('learning::local.teacher_name') }}</th>
                                <th>{{ trans('staff::local.classrooms') }}</th>
                                <th>{{ trans('learning::local.subject') }}</th>
                                <th>{{ trans('learning::local.time') }}</th>
                                <th>{{ trans('staff::local.start') }}</th>
                            </tr>
                        </thead>
                        <tbody id="schedule" class="center">   
                                        
                        </tbody>
                    </table>                              
                </div>           
              </div>
            </div>      
          </div>
    </div>
</div>
@endsection
@section('script')
    <script>
        virtualClassrooms()

        function virtualClassrooms()
        {
          $.ajax({
                type:'get',
                url:'{{route("view.virtual-classrooms")}}',
                dataType:'json',
                success:function(data){
                  $('#schedule').html(data.schedule);
                }
            });
                  
        }
    </script>
@endsection