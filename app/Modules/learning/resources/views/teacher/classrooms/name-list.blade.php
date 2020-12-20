@extends('layouts.backEnd.teacher')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ $title }} | {{ $classroom->class_name }}</h3>
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
                            <img src="{{ asset($student->show_student) }}" class="rounded-circle  height-150 width-150" alt="Card image">                                                        
                        </div>
                        
                        <h4 class="card-title"><strong>{{ $student->student_name }}</strong></h4>
                        <div class="text-center">
                            <a href="#" onclick="studentData({{ $student->id }})" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"
                                data-toggle="tooltip" data-placement="top" data-html="true" title="{{ trans('learning::local.student_data') }}">
                              <span class="la la-user"></span>
                            </a>
                            <a href="#" onclick="homeworks({{ $student->user_id }})" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"
                                data-toggle="tooltip" data-placement="top" data-html="true" title="{{ trans('learning::local.class_work') }}">
                              <span class="la la-edit"></span>
                            </a>
                            <a href="#" onclick="exams()" class="btn btn-social-icon mr-1 mb-1 btn-outline-linkedin"
                            data-toggle="tooltip" data-placement="top" data-html="true" title="{{ trans('learning::local.exams') }}">
                                <span class="la la-tasks"></span>
                              </a>
                            <a href="#" class="btn btn-social-icon mb-1 btn-outline-linkedin"
                            data-toggle="tooltip" data-placement="top" data-html="true" title="{{ trans('learning::local.reports') }}">
                              <span class="la la-file font-medium-4"></span>
                            </a>
                            
                          </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('learning::teacher.classrooms.includes._student-data')
    @include('learning::teacher.classrooms.includes._homeworks')
@endsection
@section('script')
    <script>
        function studentData(student_id) {
            $.ajax({
                type: "GET",
                data: {
                    student_id: student_id
                },
                url: "{{ route('teacher.student-data') }}",
                dataType: "html",
                success: function(data) {
                    $('#student_data').html(data);
                    $('#student_data_modal').modal('show');
                }
            })


        }

        function homeworks(user_id) {
            $.ajax({
                type: "GET",
                data: {
                    user_id: user_id
                },
                url: "{{ route('teacher.homework') }}",
                dataType: "html",
                success: function(data) {
                    $('#homework').html(data);
                    $('#homework_modal').modal('show');
                }
            })


        }

    </script>
<script src="{{ asset('cpanel/app-assets/js/scripts/tooltip/tooltip.js') }}"></script>
@endsection
