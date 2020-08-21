@if($errors->any())
<div class="alert alert-danger">
    @foreach($errors->all() as $error)
        <!-- print all errors -->
            {{$error}} . <br>
    @endforeach
</div>
@endif
