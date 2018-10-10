<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>三叶后台管理登陆</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="icon" type="image/png" href="{{config('oss.OSSDomain')}}asset/i/favicon.png">
    <link rel="apple-touch-icon-precomposed" href="h{config('oss.OSSDomain')}}asset/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/css/amazeui.min.css" />
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/css/admin.css">
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/css/app.css">
</head>

<body data-type="login">

<div class="am-g myapp-login">
    <div class="myapp-login-logo-block  tpl-login-max">
        <div class="myapp-login-logo-text">
            <div class="myapp-login-logo-text">
                后台登陆
            </div>
        </div>
        <div class="am-u-sm-10 login-am-center">
            <form method="post" action="{{ url('admin/login') }}" class="am-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                <fieldset>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label" style="color: #fff;">Name</label>
                        <div class="am-form-group">
                            <input id="name doc-ipt-name-1" type="text" name="name" value="{{ old('name') }}" placeholder="输入账号" required autofocus>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                     <strong style="color: #f00;">{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label" style="color: #fff;">Password</label>
                        <div class="am-form-group">
                            <input type="password" class="" id="doc-ipt-pwd-1" name="password"  placeholder="请输入密码" required>
                            @if ($errors->has('password'))
                                <span class="help-block">
                                      <strong style="color: #f00;">{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label class="am-checkbox am-success">
                                    <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} data-am-ucheck checked><span style="color: #fff;">Remember Me</span>
                                </label>

                            </div>
                        </div>
                    </div>
                    <p><button type="submit" class="am-btn am-btn-default">登录</button></p>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<script src="{{config('oss.OSSDomain')}}asset/js/jquery.min.js"></script>
<script src="{{config('oss.OSSDomain')}}asset/js/amazeui.min.js"></script>
<script src="{{config('oss.OSSDomain')}}asset/js/app.js"></script>
</body>

</html>
