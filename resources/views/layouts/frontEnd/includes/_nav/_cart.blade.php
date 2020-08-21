<li class="dropdown dropdown-notification nav-item">
    <a class="nav-link nav-link-label" href="{{route('cart.show')}}"><i class="la la-shopping-cart"></i>
      <span class="badge badge-pill badge-default badge-danger badge-default badge-up badge-glow">
          {{(session()->has('cart')) ?session('cart')->totalQty: 0}}
      </span>
    </a>
</li>
