@extends('common')
@section('content')
    <style>
        .wrapper-page{
            width: 800px;
            position: absolute;
            top:10%;
            left: 25%;
        }
        h3{
            font-size: 100px;
        }
        .alert{
            color: #aaa;
        }
    </style>
        <div class="wrapper-page">
            <div class="panel panel-color {{ $data['status']?'panel-inverse':'panel-danger' }}">
                <div class="panel-heading">
                    <h3 class="text-center m-t-10">{{ $data['message'] }}</h3>
                </div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="alert {{ $data['status']?'alert-info':'alert-danger' }} alert-dismissable">
                            {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
                            浏览器页面将在<b id="loginTime">{{ $data['jumpTime'] }}</b>秒后跳转......<span class="input-group-btn"> <a href="{{$data['url']}}" class="btn {{ $data['status']?'btn-success':'btn-danger' }}">点击立即跳转</a> </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
    $(function(){
        //循环倒计时，并跳转
        var url = "{{ $data['url'] }}";
        var loginTime = parseInt($('#loginTime').text());
        console.log(loginTime);
        var time = setInterval(function(){
            loginTime = loginTime-1;
            $('#loginTime').text(loginTime);
            if(loginTime==0){
                clearInterval(time);
                window.location.href=url;
            }
        },1000);
    })
</script>

@stop