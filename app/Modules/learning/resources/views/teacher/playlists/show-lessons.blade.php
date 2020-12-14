@extends('layouts.backEnd.teacher')

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ $title }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('teacher.playlists') }}">{{ trans('learning::local.playlist') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $title }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>

        <div class="content-header-right col-md-6 col-12">
            <div class="btn-group {{ session('lang') == 'ar' ? 'pull-left' : 'pull-right' }}">
                <button type="button" class="btn btn-success " data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false"> <i class="la la-angle-down"></i>
                </button>
                <div class="dropdown-menu xx">
                    <a class="dropdown-item" href="#" onclick="setClasses()"><i class="la la-graduation-cap"></i>
                        {{ trans('learning::local.set_classes') }}</a>
                    <a class="dropdown-item" href="{{ route('teacher.edit-playlists', $playlist->id) }}"><i
                            class="la la-edit"></i> {{ trans('learning::local.edit') }}</a>
                    <a class="dropdown-item" href="#" onclick="deletePlaylist()"><i class="la la-trash"></i>
                        {{ trans('learning::local.delete_playlist') }}</a>
                </div>
                <button type="button" onclick="location.href='{{ route('teacher.new-lessons', $playlist->id) }}';"
                    class="btn btn-success">{{ trans('learning::local.new_lesson') }}</button>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-12">
            <div class="card">
                <div class="card-content collapse show">
                    <div class="card-body">
                        @empty(count($lessons))
                            <div class="alert bg-info alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
                                <span class="alert-icon"><i class="la la-info-circle"></i></span>
                                {{ trans('learning::local.no_lessons') }}
                            </div>
                        @endempty
                        <div class="col-lg-12 col-md-12">
                            @foreach ($lessons as $index => $lesson)
                                <div class="card collapse-icon accordion-icon-rotate">

                                    <div id="headingCollapse_{{ $lesson->id }}" class="card-header "
                                        style="border: .2px solid #c0c0c07d;">
                                        <a style="color: #7f888f;font-size:20px;font-weight:800" data-toggle="collapse"
                                            href="#collapse_{{ $lesson->id }}" aria-expanded="false"
                                            aria-controls="collapse_{{ $lesson->id }}"
                                            class="card-title lead collapsed"><strong>{{ ++$index }} -
                                                {{ $lesson->lesson_title }}</strong>
                                        </a>
                                    </div>
                                    <div id="collapse_{{ $lesson->id }}" role="tabpanel"
                                        aria-labelledby="headingCollapse_{{ $lesson->id }}" class="card-collapse collapse "
                                        style="border: .2px solid #c0c0c07d;" aria-expanded="true">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <p>{{ $lesson->description }}</p>
                                                <div class="form-group">
                                                    <h6 class="small"><strong>{{ trans('learning::local.created_by') }} :
                                                        </strong>{{ session('lang') == 'ar' ? $lesson->admin->ar_name : $lesson->admin->name }}
                                                        | <strong>{{ trans('learning::local.created_at') }} :
                                                        </strong>{{ $lesson->created_at->diffForHumans() }}
                                                        | <strong>{{ trans('learning::local.last_updated') }} :</strong>
                                                        :{{ $lesson->updated_at->diffForHumans() }}
                                                    </h6>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="badge badge-danger">
                                                        <span><a
                                                                href="{{ route('teacher.view-lesson', ['id' => $lesson->id, 'playlist_id' => $lesson->playlist_id]) }}">{{ trans('learning::local.watch') }}</a></span>
                                                        <i class="la la-tv font-medium-3"></i>
                                                    </div>
                                                    <div class="badge badge-info">
                                                        <span><a href="{{ route('teacher.students-views', $lesson->id) }}">
                                                                {{ trans('learning::local.views') }} {{ $lesson->views }}
                                                            </a></span>
                                                        <i class="la la-eye font-medium-3"></i>
                                                    </div>
                                                    <div class="badge badge-warning">
                                                        <span><a href="{{ route('teacher.edit-lessons', $lesson->id) }}">
                                                                {{ trans('learning::local.edit') }}</a></span>
                                                        <i class="la la-edit font-medium-3"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $lessons->links() }}
                    </div>
                </div>
            </div>
        </div>
        <form action="" method="post" id="formData">
            @csrf
            <input type="hidden" value="{{ $playlist->id }}" name="playlist_id">
        </form>
    </div>
    @include('learning::teacher.includes._set-classes')
@endsection

@section('script')
    <script>
        function deletePlaylist() {
            var form_data = $('#formData').serialize();
            swal({
                    title: "{{ trans('msg.delete_confirmation') }}",
                    text: "{{ trans('learning::local.msg_delete_playlist') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#D15B47",
                    confirmButtonText: "{{ trans('msg.yes') }}",
                    cancelButtonText: "{{ trans('msg.no') }}",
                    closeOnConfirm: false,
                },
                function() {
                    $.ajax({
                        url: "{{ route('teacher.destroy-playlists') }}",
                        method: "POST",
                        data: form_data,
                        dataType: "json",
                        // display succees message
                        success: function(data) {
                            location.href = "{{ route('teacher.playlists') }}";
                        }
                    })
                }
            );
        }

        function setClasses() {
            $('#playlist_id').val("{{ $playlist->id }}");
            $('#setClasses').modal({
                backdrop: 'static',
                keyboard: false
            })
            $('#setClasses').modal('show');
        }

    </script>
@endsection
