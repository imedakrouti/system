@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2">
            <h3 class="content-header-title">{{ $title }}</h3>
            <div class="row breadcrumbs-top">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a
                                href="{{ route('dashboard.admission') }}">{{ trans('admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a
                                href="{{ route('stages.index') }}">{{ trans('student::local.stages') }}</a></li>
                        <li class="breadcrumb-item active">{{ $title }}
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
                        <form class="form form-horizontal" method="POST" action="{{ route('stages.update', $stage->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-body">
                                <h4 class="form-section"> {{ $title }}</h4>
                                @include('layouts.backEnd.includes._msg')
                                <div class="row">
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('student::local.ar_stage_name') }}</label> <br>

                                            <input type="text" class="form-control "
                                                value="{{ old('ar_stage_name', $stage->ar_stage_name) }}"
                                                placeholder="{{ trans('student::local.ar_stage_name') }}"
                                                name="ar_stage_name" required>
                                            <span class="red">{{ trans('student::local.requried') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('student::local.en_stage_name') }}</label> <br>

                                            <input type="text" class="form-control "
                                                value="{{ old('en_stage_name', $stage->en_stage_name) }}"
                                                placeholder="{{ trans('student::local.en_stage_name') }}"
                                                name="en_stage_name" required>
                                            <span class="red">{{ trans('student::local.requried') }}</span>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="form-group">
                                            <label>{{ trans('student::local.sort') }}</label> <br>

                                            <input type="number" min="0" class="form-control "
                                                value="{{ old('sort', $stage->sort) }}"
                                                placeholder="{{ trans('student::local.sort') }}" name="sort" required>
                                            <span class="red">{{ trans('student::local.requried') }}</span>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>{{ trans('student::local.signature_statement') }}</label>
                                    <textarea class="form-control" name="signature" id="ckeditor" cols="30"
                                        rows="10" class="ckeditor">{{ old('signature', $stage->signature) }}</textarea>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions left">
                                <button type="submit" class="btn btn-success">
                                    <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                                </button>
                                <button type="button" class="btn btn-warning mr-1"
                                    onclick="location.href='{{ route('stages.index') }}';">
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
    <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('ckeditor', {
            language: "{{ session('lang') }}",
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

    </script>
@endsection
