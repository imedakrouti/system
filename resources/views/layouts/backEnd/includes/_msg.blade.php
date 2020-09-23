@if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert bg-danger alert-icon-left alert-arrow-left alert-dismissible mb-2" role="alert">
        <span class="alert-icon"><i class="la la-info-circle"></i></span>               
        {{$error}}
    </div>
    @endforeach
@endif
