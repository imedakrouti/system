@extends('layouts.backEnd.teacher')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ $title }}</h3>
        </div>
    </div>
    <div class="row">
        @foreach ($students as $student)
            @php
            $path_image = $student->gender == trans('student::local.male') ?
            'images/studentsImages/37.jpeg' : 'images/studentsImages/39.png';
            @endphp
            <div class="col-xl-3 col-md-6 col-12">
                <div class="card">
                    <div class="text-center">
                        <div class="card-body">
                            @empty($student->student_image)
                                <img src="{{ asset($path_image) }}" class="rounded-circle  height-150 width-150" alt="Card image">
                            @endempty
                            @isset($student->student_image)
                                <img class=" rounded-circle  height-150 width-150" alt="" id="Card image"
                                    src="{{ asset('images/studentsImages/' . $student->student_image) }}" />
                            @endisset
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">
                               {{$student->student_name}}
                            </h4>
                        </div>
                        <div class="text-center">
                            <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-facebook" data-toggle="tooltip"
                                data-placement="top" title="{{ trans('learning::local.profile') }}">
                                <span class="la la-user"></span>
                            </a>
                            <a href="#" class="btn btn-social-icon mr-1 mb-1 btn-outline-twitter" data-toggle="tooltip"
                            data-placement="top" title="{{ trans('learning::local.activity') }}">
                                <span class="la la-file-archive-o"></span>
                            </a>
                            <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin" data-toggle="tooltip"
                            data-placement="top" title="{{ trans('learning::local.report') }}">
                                <span class="la la-file-text font-medium-4"></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('script')
    <script src="{{ asset('cpanel/app-assets/js/scripts/tooltip/tooltip.js') }}"></script>
@endsection
