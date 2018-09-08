<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">	
        <title>Login</title>
        <!-- All Css -->
        <link rel="stylesheet" type="text/css" href="{{ url('css/app.css') }}">
        <!-- Img Setting -->
        <link rel="stylesheet" type="text/css" href="{{ url('css/set_img.css') }}">
        <!-- animate -->
        <link rel="stylesheet" type="text/css" href="{{ url('css/animate.css') }}">
        <!-- Icheck-2 -->
        <link rel="stylesheet" type="text/css" href="{{ url('node_modules/icheck-bootstrap/icheck-bootstrap.css') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">		
</head>
<body class="hold-transition login-page">
@if (Session::has('Login'))
<script>window.location = "{{ url('/Dashboard') }}";</script>
@else
@endif 
<div class="login-box">
  <div class="login-logo">
    <b>Fitness</b> V 0.1
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">ลงชื่อเข้าใช้เพื่อเริ่มต้นเซสชันของคุณ</p>
      <form action="{{ url('/Do_login') }}" method="post" accept-charset="utf-8">
        @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" placeholder="Username" autofocus oninvalid="this.setCustomValidity('กรุณากรอก Username')" oninput="this.setCustomValidity('')" required>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" placeholder="Password" oninvalid="this.setCustomValidity('กรุณากรอก Password')" oninput="this.setCustomValidity('')" required>
        </div>
        <div class="row">
          <div class="col-12" align="center">
            <button type="submit" class="btn btn-primary btn-block btn-flat">เข้าสู่ระบบ</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
	<!-- All Js -->
	<script type="text/javascript" src="{{ url('js/app.js') }}"></script>
</html>