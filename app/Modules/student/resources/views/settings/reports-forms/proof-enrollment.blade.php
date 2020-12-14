@extends('layouts.backEnd.cpanel')
@section('sidebar')
    @include('layouts.backEnd.includes.sidebars._admission')
@endsection
@section('styles')
    <style>
        .cke_skin_kama .cke_button_pluging_name .cke_label {
            display: inline;
        }
    </style>
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
                        <h3 class="red"><strong>{{ $title }}</strong></h3>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <form class="form form-horizontal" action="{{ route('proof-enrollment.update') }}"
                                    method="post">
                                    @csrf
                                    <textarea class="form-control" name="proof_enrollment" id="ckeditor" cols="30" rows="10"
                                        class="ckeditor">{{ old('proof_enrollment', $content->proof_enrollment) }}</textarea>
                                    <div class="form-actions left">
                                        <button type="submit" class="btn btn-success">
                                            <i class="la la-check-square-o"></i> {{ trans('admin.save') }}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')    
    <script src="//cdn.ckeditor.com/4.14.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'ckeditor', {
            language: "{{session('lang')}}",
            toolbarGroups: [
                { name: 'mode' },
                { name: 'basicstyles' },
                { name: 'colors' },
                { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
                { name: 'tools' },
                { name: 'styles' }        
        ]   ,
            on: {        
                pluginsLoaded: function() {
                    var editor = this,
                        config = editor.config;
                    
                    // Let the party on!            
                    editor.ui.addRichCombo( 'myCombo', {
                        label: "{{trans('student::local.elements')}}",
                        title: "{{trans('student::local.elements')}}",
                        toolbar: 'styles',
                        panel: {
                            css: [ CKEDITOR.skin.getPath( 'editor' ) ].concat( config.contentsCss ),
                            multiSelect: false
                        },
            
                        // Let's populate the list of available items.
                        init: function() {
                            this.startGroup( "{{trans('student::local.elements_title')}}" );
                            var ar_items = [ ' [[الجنسية]] ', ' [[اسم الطالب]] ' ,' [[الرقم القومي للطالب]] ',' [[الديانة]] ',' [[تاريخ الميلاد]] ',
                            ' [[القسم الاكاديمي]] ',' [[الصف الدراسي]] ',' [[العام الدراسي]] ',' [[اسم المدرسة]] ',' [[التاريخ]] ' ];
                            var en_items = [ ' [[Nationality]] ', ' [[Student name]] ' ,' [[Student national id number]] ',' [[Religion]] ',' [[Date of birth]] ',
                            ' [[Division]] ',' [[Grade]] ',' [[Academic Year]] ',' [[School name]] ',' [[Date]] ' ];
                            var lang = "{{session('lang') == 'ar' ? 'ar' : 'en'}}";
                            var items = lang == 'ar' ? ar_items : en_items;

                            for ( var i = 0; i < items.length; i++ ) {
                                var item = items[ i ];
                                // Add entry to the panel.
                                this.add( item, item );
                            }
                        },
                        // This is what happens when the item is clicked.
                        onClick: function( value ) {
                            editor.focus();
                            editor.fire( 'saveSnapshot' );
                            editor.insertHtml(value );                    
                            editor.fire( 'saveSnapshot' );
                        }
                    } );            
                }
            }
        } );
    </script> 
@endsection

