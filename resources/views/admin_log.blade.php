<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
    <meta charset="utf-8">
    <title>三叶后台管理登陆</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- CSS -->
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=PT+Sans:400,700'>
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/login/css/reset.css">
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/login/css/supersized.css">
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/login/css/style.css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>
<div class="page-container">
    <h1>Login</h1>
    <form method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="text" name="username" class="username" placeholder="Username">
        <input type="password" name="password" class="password" placeholder="Password">
        <button type="submit">submit</button>
        <div class="error"><span>+</span></div>
    </form>
  {{--  <div class="connect">
        <p>Or connect with:</p>
        <p>
            <a class="facebook" href=""></a>
            <a class="twitter" href=""></a>
        </p>
    </div>--}}
</div>
<!-- Javascript -->
<script src="{{config('oss.OSSDomain')}}asset/login/js/jquery-1.8.2.min.js"></script>
<script src="{{config('oss.OSSDomain')}}asset/login/js/supersized.3.2.7.min.js"></script>
<script src="{{config('oss.OSSDomain')}}asset/login/js/supersized-init.js"></script>
<script src="{{config('oss.OSSDomain')}}asset/login/js/scripts.js"></script>
</body>
</html>

