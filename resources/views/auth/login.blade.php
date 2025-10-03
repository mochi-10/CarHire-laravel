<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Car Hire | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('backend/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('backend/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('backend/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('backend/dist/css/AdminLTE.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('backend/plugins/iCheck/square/blue.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  
  <!-- Custom Enhanced Styles -->
  <style>
    body.login-page {
      background: linear-gradient(135deg, rgba(0,0,0,0.7), rgba(0,0,0,0.4));
      font-family: 'Source Sans Pro', sans-serif;
    }
    
    .login-box {
      margin: 7% auto;
      animation: slideInUp 0.8s ease-out;
    }
    
    @keyframes slideInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .login-logo a {
      color: #fff !important;
      font-size: 45px;
      font-weight: 700;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .login-logo a:hover {
      color: #007bff !important;
      transform: scale(1.05);
    }
    
    .login-box-body {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      border-radius: 15px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
      padding: 30px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      transition: all 0.3s ease;
    }
    
    .login-box-body:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
      transform: translateY(-2px);
    }
    
    .login-box-msg {
      font-size: 18px;
      color: #333;
      text-align: center;
      margin-bottom: 25px;
      font-weight: 500;
    }
    
    .form-group {
      position: relative;
      margin-bottom: 25px;
    }
    
    .form-control {
      height: 50px;
      border: 2px solid #e1e5e9;
      border-radius: 10px;
      font-size: 16px;
      padding-left: 50px;
      transition: all 0.3s ease;
      background: rgba(255, 255, 255, 0.9);
    }
    
    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
      background: #fff;
      transform: translateY(-1px);
    }
    
    .form-control-feedback {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #6c757d;
      font-size: 18px;
      z-index: 2;
      transition: all 0.3s ease;
    }
    
    .form-group:focus-within .form-control-feedback {
      color: #007bff;
      transform: translateY(-50%) scale(1.1);
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #007bff, #0056b3);
      border: none;
      border-radius: 10px;
      height: 50px;
      font-size: 16px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .btn-primary::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }
    
    .btn-primary:hover::before {
      left: 100%;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, #0056b3, #004085);
      transform: translateY(-2px);
      box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4);
    }
    
    .btn-primary:active {
      transform: translateY(0);
    }
    
    .login-box-body a {
      color: #007bff;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
    }
    
    .login-box-body a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -2px;
      left: 0;
      background-color: #007bff;
      transition: width 0.3s ease;
    }
    
    .login-box-body a:hover::after {
      width: 100%;
    }
    
    .login-box-body a:hover {
      color: #0056b3;
      text-decoration: none;
    }
    
    .invalid-feedback {
      display: block;
      margin-top: 8px;
      padding: 8px 12px;
      background: rgba(220, 53, 69, 0.1);
      border-left: 3px solid #dc3545;
      border-radius: 4px;
    }
    
    .form-control.is-invalid {
      border-color: #dc3545;
      animation: shake 0.5s ease-in-out;
    }
    
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      25% { transform: translateX(-5px); }
      75% { transform: translateX(5px); }
    }
    
    /* Enhanced background overlay */
    body::before {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle at center, rgba(0,123,255,0.1) 0%, rgba(0,0,0,0.3) 100%);
      z-index: -1;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
      .login-box {
        margin: 5% auto;
        width: 90%;
      }
      
      .login-logo a {
        font-size: 35px;
      }
      
      .login-box-body {
        padding: 20px;
      }
    }
  </style>
</head>

<body class="hold-transition login-page">
  <img src="{{ asset('frontend/images/hero_1.jpg') }}" width="100%" height="100%" style="position:fixed; top:0; left:0; z-index:-1;">
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Car Hire</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>



      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group has-feedback">
          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" name="email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong style="color: red;">{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong style="color: red;">{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="row">
          <div class="col-xs-0">
            <div class="checkbox icheck">
              <!-- <label>
              <input type="checkbox"> Remember Me
            </label> -->
            </div>
          </div>
          <!-- /.col -->
          <div class="col-xs-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div> -->
      <!-- /.social-auth-links -->

      <a href="{{ route('forgotPassword') }}">I forgot my password</a><br>


      <a href="{{ route('register') }}" class="text-center">Register a new account</a>

    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('backend/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
  <!-- iCheck -->
  <script src="{{ asset('backend/plugins/iCheck/icheck.min.js') }}"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>

</html>