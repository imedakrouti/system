<li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
    aria-haspopup="true" aria-expanded="false">
    @if (session('lang') == 'ar' || session('lang') == trans('admin.ar'))
    <i class="flag-icon flag-icon-eg"></i>
    @else
    <i class="flag-icon flag-icon-gb"></i>
    @endif
    <span class="selected-language"></span></a>
    <div class="dropdown-menu" aria-labelledby="dropdown-flag">
        <a class="dropdown-item" href="{{aurl('lang/ar')}}"><i class="flag-icon flag-icon-eg"></i> العربية</a>
        <a class="dropdown-item" href="{{aurl('lang/en')}}"><i class="flag-icon flag-icon-gb"></i> English</a>
    </div>
</li>
