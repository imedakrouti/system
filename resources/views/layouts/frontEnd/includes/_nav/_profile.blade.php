  <li class="dropdown dropdown-user nav-item">
    @if (Auth::guard('web')->check())
    <a class="dropdown-toggle nav-link dropdown-user-link" href="{{route('users.signIn')}}" data-toggle="dropdown">
        <span class="mr-1">{{ trans('admin.hello') }},
            <span class="user-name text-bold-700">{{userInfo()->name}}</span>
        </span>
    </a>
    @else
    <a class="nav-link dropdown-user-link" href="{{route('users.signIn')}}">
       <span class="mr-1">
          <span class="user-name text-bold-700">{{trans('admin.login')}}</span>
        </span>
    </a>
    @endif
  <div class="dropdown-menu dropdown-menu-right">
    <a class="dropdown-item" href="{{route('user.logout')}}"><i class="ft-power"></i> {{ trans('admin.logout') }}</a>
  </div>
</li>
