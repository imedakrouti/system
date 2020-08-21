<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-dark bg-primary navbar-shadow navbar-brand-center">
    <div class="navbar-wrapper">
        @include('layouts.frontEnd.includes._nav._title')

      <div class="navbar-container content">
        <div class="collapse navbar-collapse" id="navbar-mobile">
          <ul class="nav navbar-nav mr-auto float-left">
            <li class="nav-item d-none d-md-block">
                <a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu"></i></a></li>
          </ul>
          <ul class="nav navbar-nav float-right">

            @include('layouts.frontEnd.includes._nav._lang')

            @include('layouts.frontEnd.includes._nav._profile')

            @include('layouts.frontEnd.includes._nav._cart')

          </ul>
        </div>
      </div>
    </div>
  </nav>
