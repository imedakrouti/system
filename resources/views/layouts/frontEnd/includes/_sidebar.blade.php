<div class="main-menu menu-dark menu-fixed menu-light menu-accordion menu-shadow menu-border"
    data-scroll-to-active="true">
    <div class="main-menu-content">
      <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
        <li class=" nav-item">
            <a href="{{route('home')}}">
                <span class="menu-title" data-i18n="">{{ trans('admin.dashboard') }}</span>
            </a>
        </li>
        <li class=" nav-item">
            <a href="{{route('user.orders')}}">
            <span class="menu-title" data-i18n="">{{ trans('admin.profile') }}</span>
            </a>
        </li>
        <li class=" nav-item">
            <a href="email-application.html">
            <span class="menu-title" data-i18n="">{{ trans('admin.customersService') }}</span>
            </a>
        </li>
        <li class=" nav-item">
            <a href="email-application.html">
            <span class="menu-title" data-i18n="">{{ trans('admin.recentlyArrived') }}</span>
            </a>
        </li>
        <li class=" navigation-header">
            <span data-i18n="nav.category.layouts">{{ trans('admin.categories') }}</span><i class="la la-ellipsis-h ft-minus" data-toggle="tooltip"
            data-placement="right" data-original-title="Layouts"></i>
        </li>
        @if (count($categories) > 0)
        @foreach ($categories as $category)
        <li class=" nav-item"><a href="#"><span class="menu-title" data-i18n="nav.dash.main">{{session('lang') == 'ar' ?$category->ar_category_name : $category->en_category_name}}</span></a>
            <ul class="menu-content">
                @foreach ($category->departments as $department)
                    <li>
                        <a class="menu-item" href="{{route('all.products',$department->id)}}" data-i18n="nav.dash.ecommerce">{{session('lang') =='ar' ?$department->ar_department_name:$department->en_department_name}}</a>
                    </li>
                @endforeach
            </ul>
        </li>
        @endforeach
        @endif

      </ul>
    </div>
  </div>
