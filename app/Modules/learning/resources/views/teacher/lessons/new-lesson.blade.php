@extends('layouts.backEnd.teacher')
@section('content')
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
      <h3 class="content-header-title">{{$title}}</h3>
      <div class="row breadcrumbs-top">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('teacher.playlists')}}">{{ trans('learning::local.playlist') }}</a>
            </li>       
            <li class="breadcrumb-item"><a href="{{route('teacher.show-lessons',$playlist->id)}}">{{$title}}</a>
            </li>       
            <li class="breadcrumb-item">{{ trans('learning::local.new_lesson') }}</li>     
          </ol>
        </div>
      </div>
    </div>    
</div>

<div class="row mt-1">
  <div class="col-12">
    <div class="card">
      <div class="card-content collapse show">
        <div class="card-body">
          <form class="form form-horizontal" method="POST" action="{{route('teacher.store-lessons')}}" enctype="multipart/form-data">
              @csrf
              <div class="form-body">
                  <h4 class="form-section"> {{ $title }}</h4>
                  @include('layouts.backEnd.includes._msg')   
                  <input type="hidden" name="playlist_id" value="{{$playlist->id}}">      
                  <div class="row">
                      <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('learning::local.lesson_title') }}</label>
                            <input type="text" class="form-control " value="{{old('lesson_title')}}" placeholder="{{ trans('learning::local.lesson_title') }}"
                              name="lesson_title" required>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                          </div>
                      </div>  
                      <div class="col-lg-6 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('learning::local.description') }}</label>
                            <textarea name="description" class="form-control" cols="30" rows="5">{{old('description')}}</textarea>                                
                          </div>
                      </div>                        
                  </div>                 
                  <div class="row">
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('learning::local.visibility') }}</label>                              
                              <select name="visibility" class="form-control">
                                  <option {{old('visibility') == 'show' ? 'selected' : ''}} value="show">{{ trans('learning::local.show') }}</option>
                                  <option {{old('visibility') == 'hide' ? 'selected' : ''}} value="hide">{{ trans('learning::local.hide') }}</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('learning::local.subject') }}</label>
                            <select name="subject_id" class="form-control" required>                                
                                @foreach (employeeSubjects() as $subject)
                                    <option {{old('subject_id') == $subject->id ? 'selected' : ''}} value="{{$subject->id}}">
                                        {{session('lang') =='ar' ?$subject->ar_name:$subject->en_name}}</option>                                    
                                @endforeach
                            </select>                            
                          </div>
                      </div>
                      <div class="col-lg-4 col-md-6">
                          <div class="form-group">
                            <label>{{ trans('learning::local.sort_in_playlist') }}</label>
                            <input type="number" min="0" step="1" class="form-control " value="{{old('sort')}}" placeholder="{{ trans('learning::local.sort') }}"
                              name="sort" required>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                          </div>
                      </div>   
                  </div>
                  <div class="row">
                      <div class="col-lg-6 col-md-6">
                          <div class="form-group">
                              <label>{{ trans('learning::local.division') }}</label>
                              <select name="division_id[]" class="form-control select2" required multiple>                                    
                                  @foreach ($divisions as $division)
                                      <option value="{{$division->id}}">
                                          {{session('lang') =='ar' ?$division->ar_division_name:$division->en_division_name}}</option>                                    
                                  @endforeach
                              </select>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                          </div>
                      </div>
                      <div class="col-lg-6 col-md-6">
                          <div class="form-group"> 
                              <label>{{ trans('learning::local.grade') }}</label>
                              <select name="grade_id[]" class="form-control select2" multiple required >                                    
                                  @foreach ($grades as $grade)
                                      <option value="{{$grade->id}}">
                                          {{session('lang') =='ar' ?$grade->ar_grade_name:$grade->en_grade_name}}</option>                                    
                                  @endforeach
                              </select>
                              <span class="red">{{ trans('learning::local.required') }}</span>                              
                          </div>
                      </div>   
    
                  </div>                     
                  <div class="col-lg-12">
                     <div class="form-group row">
                          <label>{{ trans('learning::local.video_url') }} </label>                           
                          <input type="text" name="video_url" class="form-control">
                      </div> 
                  </div>
                  <div class="col-lg-6">
                      <div class="form-group row">                                                        
                          <label>{{ trans('learning::local.upload_file_video') }}</label>                             
                          <input type="file" name="file_name" class="form-control">
                      </div>
                  </div>                    
                  <div class="row">
                      <div class="col-lg-12 col-md-12">
                          <div class="form-group">
                            <label>{{ trans('learning::local.explanation') }}</label>
                            <textarea class="form-control" name="explanation" id="ckeditor" cols="30" rows="10" class="ckeditor">{{old('explanation')}}</textarea>                                                      
                          </div>
                      </div>  
                  </div>                                                                                                
              </div>
              <div class="form-actions left">
                  <button type="submit" class="btn btn-success">
                      <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                    </button>
                  <button type="button" class="btn btn-warning mr-1" onclick="location.href='{{route('teacher.show-lessons',$playlist->id)}}';">
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
<script src="{{ asset('cpanel/app-assets/js/scripts/tooltip/tooltip.js') }}"></script>
{{-- use ckeditor --}}
<script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
<script>
    CKEDITOR.replace('ckeditor', {
        language: "{{session('lang')}}",
        toolbar: [{
                name: 'basicstyles',
                groups: ['basicstyles', 'cleanup'],
                items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-',
                    'RemoveFormat'
                ]
            },
            {
                name: 'paragraph',
                groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote',
                    'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',
                    '-', 'BidiLtr', 'BidiRtl', 'Language'
                ]
            },
            {
                name: 'styles',
                items: ['FontSize']
            },
            {
                name: 'colors',
                items: ['TextColor', 'BGColor']
            },
            {
                name: 'tools',
                items: ['Maximize']
            },
        ]
    });

    $(".editor").each(function() {
        let id = $(this).attr('id');
        CKEDITOR.replace(id, {
            toolbar: [{
                    name: 'basicstyles',
                    groups: ['basicstyles', 'cleanup'],
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
                        '-', 'RemoveFormat'
                    ]
                },
                {
                    name: 'paragraph',
                    groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                        'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter',
                        'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language'
                    ]
                },
                {
                    name: 'styles',
                    items: ['FontSize']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
            ]
        });
    });

</script>  
@endsection
