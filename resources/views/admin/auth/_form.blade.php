<form class="form-horizontal form-simple" action="{{route('setLogin')}}" novalidate method="POST">
    @csrf
    <input type="hidden" name="school" value="meis">
    {{-- <fieldset class="form-group position-relative has-icon-left mb-0">
        <select name="school" class="form-control">
            <option value="meis">{{session('lang') == 'ar' ? 'مدارس ميدل إيست' : 'Middle East Schools'}}</option>
            <option value="cgs">{{session('lang') == 'ar' ? 'مدرسة كابيتال جيت' : 'Capital Gate School'}}</option>
        </select>
    </fieldset> --}}
    <br>
    <fieldset class="form-group position-relative has-icon-left mb-0">
      <input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="{{trans('admin.username')}}"
      name="username">
      <div class="form-control-position">
        <i class="ft-user"></i>
      </div>
    </fieldset>
    <br>
    <fieldset class="form-group position-relative has-icon-left">
      <input type="password" class="form-control form-control-lg input-lg" id="user-password"
    placeholder="{{trans('admin.password')}}" name="password">
      <div class="form-control-position">
        <i class="la la-key"></i>
      </div>
    </fieldset>
    <div class="form-group row">
      <div class="col-md-6 col-12 text-center text-md-left">
        <fieldset>
          <input type="checkbox" id="remember-me" class="chk-remember" name="rememberMe" value="1">
          <label for="remember-me">{{trans('admin.rememberme')}}</label>
        </fieldset>
      </div>
      {{-- <div class="col-md-6 col-12 text-center text-md-right"><a href="recover-password.html" class="card-link">{{trans('admin.forgetPassword')}}</a></div> --}}
    </div>
    <button type="submit" class="btn btn-info btn-lg btn-block"><i class="ft-unlock"></i> {{trans('admin.login')}}</button>
  </form>
