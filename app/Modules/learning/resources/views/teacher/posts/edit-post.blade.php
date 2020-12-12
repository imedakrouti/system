@extends('layouts.backEnd.teacher')
@section('styles')
    <style>
            /* Top left text */
            .top-left {
            position: absolute;
            top: 50px;
            left: 70px;
            color: aliceblue
            }    
            .comment-form{
                padding:5px;                
                width:100%;
            }               
         
    </style>
@endsection
@section('content')
{{-- images --}}
<div class="row">
    <div class="col-lg-12 mb-1">
        <img src="{{asset('images/website/img_code.jpg')}}" width="100%" alt="cover">    
        <h1 class="top-left"><strong>{{session('lang') == 'ar' ? $post->classroom->ar_name_classroom : $post->classroom->en_name_classroom}}</strong></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-content collapse show">
            <div class="card-body">
                <form class="form form-horizontal" method="POST" action="{{route('posts.update',$post->id)}}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-body">
                        <h4 class="form-section"> {{ $title }}</h4>
                        @include('layouts.backEnd.includes._msg')  
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea required name="post_text" class="form-control" cols="30" rows="10" id="ckeditor"
                                placeholder="{{ trans('learning::local.share_classroom') }}">{{old('post_text',$post->post_text)}}</textarea>                                                                
                            </div>
                                                            
                        </div>   
                        <div class="col-lg-12">
                            <div class="form-group row">
                                <label>{{ trans('learning::local.link') }}</label>
                                <input type="text" name="url" class="form-control" value="{{old('url',$post->url)}}">
                            </div>
                        </div>                          
                        <div class="col-lg-12">
                            <div class="form-group row">  
                                <label>{{ trans('learning::local.video_url') }}</label>
                                <input type="text" class="form-control" name="youtube_url" id="url" value="{{old('url',$post->youtube_url)}}">
                            </div>
                        </div>
                        @isset($post->youtube_url)
                            <div class="col-lg-12">
                            <div class="form-group">                                
                                <iframe id="youtube" width="100%"  style="min-height: 500px;" allowfullscreen
                                src="https://www.youtube.com/embed/{{prepareYoutubeURL($post->youtube_url)}}">>
                                </iframe>  
                            </div>    
                            </div>                                                            
                        @endisset
                        
                        <hr>
                        <div class="form-group mt-1">
                            <button class="btn btn-success btn-sm ml-1">{{ trans('learning::local.post') }}</button>
                            <button  type="button" onclick="location.href='{{route('posts.index',$post->classroom_id)}}';"
                                class="btn btn-light btn-sm">{{ trans('learning::local.cancel') }}</button>
                        </div>                             
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
    CKEDITOR.replace( 'ckeditor', {
        toolbar: [
                    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                    { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },                   
                    { name: 'styles', items: ['FontSize' ] },
                    { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                    { name: 'tools', items: [ 'Maximize' ] },                
                ]        
        });
</script>
@endsection
