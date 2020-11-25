<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{asset('user-login/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('user-login/css/main.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
<!--===============================================================================================-->
</head>
<body style="background-color: #666666;font-family: 'Cairo', sans-serif;">
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" method="POST" action="{{route('user.login')}}">
                    @csrf
                    <input type="hidden" name="school" value="mysql">
					<span class="login100-form-title p-b-43">
						Login to continue
					</span>
                    @if($errors->any())
                        <div class="alert bg-danger  text-center" style="color:#fff;">
                            <strong>
                                @foreach($errors->all() as $error)
                                    <!-- print all errors -->
                                        {{$error}} . <br>
                                @endforeach
                            </strong>
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert bg-danger  text-center" style="color:#fff;">
                            <strong>{{session('error')}}</strong>
                        </div>
                    @endif					
					
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="username">
						<span class="focus-input100"></span>
						<span class="label-input100">Username</span>
					</div>
					
					
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password">
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
							<input class="input-checkbox100" id="ckb1" type="checkbox" name="rememberMe" value="1">
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>
					</div>
			

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
										
				</form>

				<div class="login100-more" style="background-image: url('{{asset('user-login/images/10.jpeg')}}');">
				</div>
			</div>
		</div>
	</div>
	
	

	
	
<!--===============================================================================================-->
	<script src="{{asset('user-login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('user-login/vendor/animsition/js/animsition.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('user-login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('user-login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->

<!--===============================================================================================-->
	<script src="{{asset('user-login/js/main.js')}}"></script>

</body>
</html>