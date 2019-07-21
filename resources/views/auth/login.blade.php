<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>
    @yield('title')
  </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('adminlte/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('adminlte/dist/css/skins/_all-skins.min.css')}}">

  <link rel="stylesheet" href="{{ asset('toastr.min.css') }}" type="text/css" />
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/iCheck/square/blue.css') }}">

  @yield('css')

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">



    <!-- jQuery 3 -->
    <script src="{{asset('adminlte/bower_components/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{asset('adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- SlimScroll -->
    <script src="{{asset('adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('adminlte/bower_components/fastclick/lib/fastclick.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('adminlte/dist/js/adminlte.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('adminlte/dist/js/demo.js')}}"></script>
    <script>
    $(document).ready(function () {
        $('.sidebar-menu').tree()
    })
    </script>

    <script src="{{asset('toastr.min.js')}}"></script>

    @yield('js')


</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin  </b>Back Office</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form method="POST" action="{{ route('login') }}">
    {{--  <form method="POST" action="{{ route('login_kem') }}">  --}}
      @csrf
      <div class="form-group has-feedback">
        <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autofocus placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        @if ($errors->has('email'))
            <span class="text-red" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif

     </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Password" name="password">

        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

        @if ($errors->has('password'))
            <span class="text-red" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

      </div>
      <div class="row">
        {{--  <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>  --}}
        <!-- /.col -->
        <div class="col-xs-4 pull-right">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    {{--  <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>  --}}
    <!-- /.social-auth-links -->

    {{-- <a href="#">I forgot my password</a><br> --}}
    {{--  <a href="{{ route('register') }}" class="text-center">Register a new membership</a>  --}}

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<script src="{{asset('adminlte/plugins/iCheck/icheck.min.js')}}"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
