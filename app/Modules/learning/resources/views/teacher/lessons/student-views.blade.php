@extends('layouts.backEnd.teacher')
@section('styles')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('cpanel/app-assets/vendors/css/tables/datatable/datatables.min.css') }}">
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ $title }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('teacher.playlists') }}">{{ trans('learning::local.playlist') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('teacher.show-lessons', $lesson->playlist_id) }}">{{ $lesson->playlist->playlist_name }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $title }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section id="basic-listgroup">
        <div class="row match-height">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4><strong>{{ $lesson->lesson_title }}</strong></h4>
                    </div>
                    <div class="row">
                        {{-- seen --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <h4 class="card-title blue">{{ trans('learning::local.seen_lesson') }}</h4>
                                    <ul class="list-group">
                                        @foreach ($seen as $student)
                                            @php
                                            $path_image = $student->gender == trans('student::local.male') ?
                                            'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';
                                            @endphp
                                            <li class="list-group-item">
                                                <div
                                                    class="{{ session('lang') == 'ar' ? 'pull-right mr-1' : 'pull-left mr-1' }}">
                                                    @empty($student->student_image)
                                                        <img class=" editable img-responsive student-image" alt="" id="avatar2"
                                                            src="{{ asset($path_image) }}" />
                                                    @endempty
                                                    @isset($student->student_image)
                                                        <img class=" editable img-responsive student-image" alt="" id="avatar2"
                                                            src="{{ asset('images/studentsImages/' . $student->student_image) }}" />
                                                    @endisset
                                                </div>
                                                <div class="{{ session('lang') == 'ar' ? 'pull-right' : 'pull-left' }}">
                                                    {{$student->student_name}}

                                                    {{-- classroom
                                                    --}}
                                                    @foreach ($student->classrooms as $classroom)
                                                        @if ($classroom->year_id == currentYear())
                                                            <span><strong>{{ $classroom->class_name }}</strong></span>
                                                        @endif
                                                    @endforeach
                                                    <br>
                                                    {{-- view time
                                                    --}}
                                                    @foreach ($student->user->lessonUser as $user)
                                                        @if ($user->lesson_id == $lesson->id)
                                                            <span
                                                                class="blue small">{{ \Carbon\Carbon::parse($user->created_at)->format('M d Y, D h:i a') }}</span>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        {{-- not seen --}}
                        <div class="col-lg-6 col-md-12">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <h4 class="card-title blue">{{ trans('learning::local.not_seen_lesson') }}</h4>
                                    <ul class="list-group">
                                        @foreach ($not_seen as $student)
                                            @php
                                            $path_image = $student->gender == trans('student::local.male') ?
                                            'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';
                                            @endphp
                                            <li class="list-group-item">
                                                <div
                                                    class="{{ session('lang') == 'ar' ? 'pull-right mr-1' : 'pull-left mr-1' }}">
                                                    @empty($student->student_image)
                                                        <img class=" editable img-responsive student-image" alt="" id="avatar2"
                                                            src="{{ asset($path_image) }}" />
                                                    @endempty
                                                    @isset($student->student_image)
                                                        <img class=" editable img-responsive student-image" alt="" id="avatar2"
                                                            src="{{ asset('images/studentsImages/' . $student->student_image) }}" />
                                                    @endisset
                                                </div>
                                                <div class="{{ session('lang') == 'ar' ? 'pull-right' : 'pull-left' }}">
                                                    {{-- student name --}}
                                                            <h4>{{$student->student_name}}</h4>

                                                    {{-- classroom --}}
                                                    @foreach ($student->classrooms as $classroom)
                                                        @if ($classroom->year_id == currentYear())
                                                            <span><strong>{{ $classroom->class_name }}</strong></span>
                                                        @endif
                                                    @endforeach
                                                    <br>
                                                    {{-- view time
                                                    --}}
                                                    @foreach ($student->user->lessonUser as $user)
                                                        @if ($user->lesson_id == $lesson->id)
                                                            <span
                                                                class="blue small">{{ \Carbon\Carbon::parse($user->created_at)->format('M d Y, D h:i a') }}</span>
                                                        @endif
                                                    @endforeach

                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
