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
            <li class="breadcrumb-item"><a href="{{route('archives.index')}}">{{ trans('student::local.archive') }}</a></li>
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
        <div class="card-content collapse show">
          <div class="card-body">            
            <div class="form-body">
                  <div class="row">
                      <div class="col-md-12">
                        @if (session('lang') == 'ar')
                        <h3><a href="{{route('students.show',$student->id)}}">{{$student->ar_student_name}}
                            {{$student->father->ar_st_name}} {{$student->father->ar_nd_name}} {{$student->father->ar_rd_name}}</a></h3>                            
                        @else
                        <h3><a href="{{route('students.show',$student->id)}}">{{$student->en_student_name}}
                            {{$student->father->en_st_name}} {{$student->father->en_nd_name}} {{$student->father->en_rd_name}}</a></h3>                            
                        @endif

                  </div>                  
                </div>              
              </div>
            </div>
          </div>
      </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-content collapse show">
          <div class="card-body">
            <a href="#" onclick="addToArchive()" class="btn btn-success mb-1"><i class="la la-plus"></i> {{ trans('student::local.add_to_archive') }}</a>
            <div class="table-responsive">
                <table id="dynamic-table" class="table data-table" >
                    <thead class="bg-info white">
                        <tr>                            
                            <th style="width: 100px">#</th>
                            <th>{{trans('student::local.document_name')}}</th>
                            <th style="width: 100px">{{trans('student::local.view')}}</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $n=1;
                        @endphp
                        @foreach ($archives as $archive)
                            <td>{{$n}}</td>
                            <td>{{$archive->document_name}}</td>
                            <td><a target="blank" class="btn btn-warning btn-sm" 
                              href="{{asset('images/attachments/'.$archive->file_name)}}">
                              <i class=" la la-download"></i>
                          </a></td>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@include('student::students-affairs.archive.includes._add-from-student')
@endsection
@section('script')
    <script>
        function addToArchive()
        {
          $('#addToArchive').modal({backdrop: 'static', keyboard: false})
          $('#addToArchive').modal('show');   
        }
    </script>
@endsection
