@extends('layouts.backEnd.cpanel')
@section('sidebar')
@include('layouts.backEnd.includes.sidebars._learning')
@endsection
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$lesson->lesson_title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.learning')}}">{{ trans('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('lessons.index')}}">{{ trans('learning::local.lessons') }}</a></li>
            <li class="breadcrumb-item active">{{$lesson->lesson_title}}
            </li>
          </ol>
        </div>
      </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="card" style="min-height: 300px">
        <div class="card-content collapse show">
          <div class="card-body">
              <h4>{{$lesson->lesson_title}} <span class="small"><a href="{{route('lessons.edit',$lesson->id)}}">{{ trans('learning::local.edit') }}</a></span></h4> 
              <p>{{$lesson->description}}</p>
              <div class="mb-1">                      
                @isset($lesson->video_url)              
                  <iframe width="100%" height="100%" style="min-height: 575px;" allowfullscreen
                      src="https://www.youtube.com/embed/{{prepareYoutubeURL($lesson->video_url)}}">
                  </iframe>
                @endisset
              </div>
              <div class="mb-2">
                @isset($lesson->file_name)                            
                  <video width="100%" height="100%" controls>
                        <source src="{{asset('images/lesson_attachments/'.$lesson->file_name)}}" type="video/mp4">
                        
                      Your browser does not support the video tag.
                      </video>
                @endisset
              </div>
                <div class="mt-2">
                    {!!$lesson->explanation!!}
                </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card" style="min-height: 300px">
          <div class="card-content collapse show">
            <div class="card-body">
                <h4>{{ trans('learning::local.attachments') }}</h4>
                <div class="form-group">
                    <a href="#" onclick="attachments()" class="btn btn-success btn-sm"><i class="la la-paperclip"></i> {{ trans('learning::local.add_attachments') }}</a>
                    <a href="#" onclick="attachmentDestroy()" class="btn btn-danger btn-sm"><i class="la la-trash"></i> {{ trans('admin.delete') }}</a>
                </div>
                {{-- attachments --}}
                @if (count($lesson->files) > 0)       
                    <form action="" method="post" id="formData">
                      @csrf        
                      <ul style="list-style: none">
                        @foreach ($lesson->files as $file)       
                          <li>
                            <label class="pos-rel">
                                <input type="checkbox" class="ace" name="id[]" value="{{$file->id}}">
                                <span class="lbl"></span>
                            </label> 
                            <a target="_blank" href="{{asset('images/lesson_attachments/'.$file->file_name)}}">{{$file->title}}</a>    
                          </li>                            
                        @endforeach                                                                                          
                      </ul>              
                    </form>             
                @else
                    <h6>{{ trans('learning::local.no_attachments') }}</h6>
                @endif
                <hr>
                {{-- playlist --}}
                <h5><strong>{{ trans('learning::local.playlist') }} :</strong> <a href="{{route('playlists.show',$lesson->playlist_id)}}">{{$lesson->playlist->playlist_name}}</a></h5>
                <ol>
                  @foreach ($lessons as $lesson_playlist)              
                      @if ($lesson_playlist->id != $lesson->id)
                      <li>
                        <a href="{{route('lessons.show',$lesson_playlist->id)}}">{{$lesson_playlist->lesson_title}}</a>
                        {!!$lesson_playlist->visibility == 'hide' ? '<i class="la la-eye-slash"></i>' : ''!!}
                      </li>
                      @else
                          <li><strong>
                            {{$lesson_playlist->lesson_title}}
                            {!!$lesson_playlist->visibility == 'hide' ? '<i class="la la-eye-slash"></i>' : ''!!}
                          </strong></li>
                      @endif
                  @endforeach
                </ol>
                <hr>
                <div class="form-group">
                  <h6><strong>{{ trans('learning::local.subject_type') }} : </strong>{{session('lang') == 'ar' ? $lesson->subject->ar_name : $lesson->subject->en_name}}</h6>
                  <h6><strong>{{ trans('learning::local.created_by') }} : </strong>{{session('lang') == 'ar' ? $lesson->admin->ar_name : $lesson->admin->name}}</h6>
                  <h6><strong>{{ trans('learning::local.created_at') }} : </strong>{{$lesson->created_at->diffForHumans()}}</h6>
                  <h6><strong>{{ trans('learning::local.last_updated') }} :</strong> :{{$lesson->updated_at->diffForHumans()}}</h6>
                </div>
                
                @foreach ($lesson->divisions as $division)                    
                    <div class="mb-1 badge badge-info">
                        <span>{{session('lang') == 'ar' ? $division->ar_division_name : $division->en_division_name}}</span>
                        <i class="la la-folder-o font-medium-3"></i>
                    </div>
                @endforeach
                @foreach ($lesson->grades as $grade)                    
                    <div class="mb-1 badge badge-success">
                        <span>{{session('lang') == 'ar' ? $grade->ar_grade_name : $grade->en_grade_name}}</span>
                        <i class="la la-folder-o font-medium-3"></i>
                    </div>
                @endforeach
                @foreach ($lesson->years as $year)                    
                    <div class="mb-1 badge badge-primary">
                        <span>{{$year->name}}</span>
                        <i class="la la-calendar font-medium-3"></i>
                    </div>
                @endforeach
                @foreach ($lesson->playlist->classes as $classroom)                    
                <div class="mb-1 badge badge-dark">
                        <span>{{session('lang') == 'ar' ? $classroom->ar_name_classroom: $classroom->en_name_classroom}}</span>
                        <i class="la la-calendar font-medium-3"></i>
                    </div>
                @endforeach
                <hr>
                <h5>
                  <strong>{{ trans('learning::local.exams') }} :</strong> 
                  @foreach ($lesson->exams as $exam)                            
                  <div class="mb-1 badge badge-info">
                          <span><a target="_blank" href="{{route('exams.preview',$exam->id)}}">{{$exam->exam_name}}</a></span>
                          <i class="la la-tasks font-medium-3"></i>
                      </div>
                  @endforeach
                </h5>
                <hr>
                <div class="col-md-12">
                  <form action="{{route('lessons.approval')}}" method="POST">
                    @csrf   
                    <input type="hidden" name="lesson_id" value="{{$lesson->id}}">                 
                    <label>{{ trans('learning::local.publish') }}</label>                      
                    <select name="approval" class="form-control" onchange="this.form.submit()">
                      <option {{$lesson->approval == 'pending' ? 'selected' : ''}} value="pending">{{ trans('learning::local.pending') }}</option>
                      <option {{$lesson->approval == 'accepted' ? 'selected' : ''}} value="accepted">{{ trans('learning::local.accepted') }}</option>
                    </select>
                  </form>
                </div>
            </div>
          </div>
        </div>
      </div>
</div>

@include('learning::lessons.admin.includes._attachment')
@endsection
@section('script')
    <script>
        function attachments()
        {
            $('#lesson_id').val({{$lesson->id}});			
            $('#attachments').modal({backdrop: 'static', keyboard: false})
            $('#attachments').modal('show');
        }

        function attachmentDestroy()
        {
            var itemChecked = $('input[class="ace"]:checkbox').filter(':checked').length;
            if (itemChecked > 0) {
                var form_data = $('#formData').serialize();
                swal({
                        title: "{{trans('msg.delete_confirmation')}}",
                        text: "{{trans('msg.delete_ask')}}",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#D15B47",
                        confirmButtonText: "{{trans('msg.yes')}}",
                        cancelButtonText: "{{trans('msg.no')}}",
                        closeOnConfirm: false,
                    },
                    function() {
                        $.ajax({
                            url:"{{route('lesson-attachment.destroy')}}",
                            method:"POST",
                            data:form_data,
                            dataType:"json",
                            // display succees message
                            success:function(data)
                            {
                              location.reload();
                            }
                        })
                        // display success confirm message
                        .done(function(data) {
                            if(data.status == true)
                            {
                                swal("{{trans('msg.delete')}}", "{{trans('msg.delete_successfully')}}", "success");
                            }else{
                                swal("{{trans('msg.delete')}}", data.msg, "error");                        
                            }
                        });
                    }
                );
            }	else{
                swal("{{trans('msg.delete_confirmation')}}", "{{trans('msg.no_records_selected')}}", "info");
            }    
        }

    </script>
@endsection
