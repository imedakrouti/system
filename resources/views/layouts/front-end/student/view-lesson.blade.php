@extends('layouts.front-end.student.index')
@section('content')

<div class="row">
    <div class="col-lg-8 col-md-12">
      <div class="card" style="min-height: 300px">
        <div class="card-content collapse show">
          <div class="card-body">
              <h4>{{$lesson->lesson_title}}</h4> 
              <p>{{$lesson->description}}</p>
              <div class="mb-1">
                @isset($lesson->video_url)              
                  <iframe width="100%"  style="min-height: 575px;" allowfullscreen
                      src="https://www.youtube.com/embed/{{prepareYoutubeURL($lesson->video_url)}}">
                  </iframe>
                @endisset
              </div>
              <div class="mb-2">
                @isset($lesson->file_name)                            
                  <video width="100%"  controls>
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
                <h5><strong>{{ trans('learning::local.playlist') }} :</strong> <a href="{{route('student.show-lessons',$lesson->playlist_id)}}">{{$lesson->playlist->playlist_name}}</a></h5>
                <ol>
                  @foreach ($lessons as $lesson_playlist)              
                      @if ($lesson_playlist->id != $lesson->id)
                      <li>
                        <a href="{{route('student.view-lesson',['id'=>$lesson_playlist->id,'playlist_id' =>$lesson_playlist->playlist_id])}}">
                          {{$lesson_playlist->lesson_title}}</a>
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
                          <span><a target="_blank" href="{{route('student.pre-start-exam',$exam->id)}}">{{$exam->exam_name}}</a></span>
                          <i class="la la-tasks font-medium-3"></i>
                      </div>
                  @endforeach
                </h5>                
            </div>
          </div>
        </div>
      </div>
</div>

@include('learning::teacher.includes._attachment')
@endsection

@section('script')
    <script>
        function attachments()
        {
            $('#lesson_id').val({{$lesson->id}});			
            $('#playlist_id').val({{$lesson->playlist_id}});			
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
                            url:"{{route('teacher-attachment.destroy')}}",
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
