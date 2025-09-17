<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{url('images/favicon.png')}}" type="image/x-icon">
    <title>Login - Vijay Kumar DVK</title>
    
    <link rel="stylesheet" type="text/css" href="{{url('admin-assets/css/fontawesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('admin-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('admin-assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{url('admin-assets/css/color-1.css')}}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{url('admin-assets/css/responsive.css')}}">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  </head>
  <body class="auth">
    
    <!-- page-wrapper Start-->
    <div class="page-wrapper">
      <div class="container-fluid p-0">
        <!-- login page start-->
        <div class="authentication-main no-bg">
            <div class="row">
                <div class="col-md-12">
                    <div class="auth-innerright">
                        <div class="authentication-box">
                            <div class="card-body">
                                <div class="cont">
                                    <img src="{{url('images/logo.jpg')}}" alt="">
                                    <form class="login" method="post" action="{{route('login')}}">
                                      @csrf

                                        <h4 class="text-center">LOGIN</h4>

                                        @if(session('error'))
                                        <div class="alert alert-danger alert-dismissible mt-3">
                                          <a href="javascript::void()" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                          <strong>{{session('error')}}</strong>
                                        </div>
                                        @endif

                                        <div class="form-group">
                                            <label class="col-form-label pt-0">Your Email</label>
                                            <input class="form-control" type="text" name="email" required="" value="{{ old('email') }}">
                                            @error('email')
                                            <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label class="col-form-label">Password</label>
                                            <input class="form-control" type="password" name="password" required="" value="{{ old('password') }}">
                                            @error('password')
                                            <span class="error-message">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="checkbox p-0" data-c="{{ request()->ip() }}">
                                            <input id="checkbox1" type="checkbox" name="remember">
                                            <label for="checkbox1">Remember me</label>
                                        </div>
                                        
                                        @if(request()->ip() != '127.0.0.1' && request()->ip() != '::1')
                                        <div class="g-recaptcha" data-sitekey="6LfLiwkdAAAAAKrLwoJgC5ZxHvzd3g8DBGtQmMQ5"></div>
                                        @endif

                                        <div class="form-group row mt-3 mb-0">
                                            <button class="btn btn-primary btn-block" type="submit">LOGIN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login page end-->
      </div>
    </div>
    
    <script src="{{url('admin-assets/js/jquery-3.5.1.min.js')}}"></script>
    <script src="{{url('admin-assets/js/bootstrap/popper.min.js')}}"></script>
    <script src="{{url('admin-assets/js/bootstrap/bootstrap.js')}}"></script>
	  <script src="{{url('plugins/jquery-validate/jquery.validate.min.js')}}"></script>

    <script>
		$(".login").validate({
			rules: {
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 5,
				},
			},
			messages: {
				email: {
					required: "Enter the Email Id",
					email: "Email Id is invalid"
				},
				password: {
					required: "Enter the Password",
					minlength: "Password should be minimum 5 characters"
				},
			},
			submitHandler: function(form) {
				form.submit();
			}
		});
	  </script>
  </body>

</html>