@include('layouts.backEnd.layout-report.header')
<htmlpageheader name="page-header"> 
    <div class="left-header" style="margin-top: -20px">
        <img src="{{$logo}}" alt="" class="logo">
    </div>
    <div class="header-report">
        {!!$header!!}
    </div>
    <div class="clear"></div>
    
</htmlpageheader>
<p>{!!$content!!}</p>
<htmlpagefooter name="page-footer">
    {!!$footer!!}
</htmlpagefooter>
@include('layouts.backEnd.layout-report.footer')