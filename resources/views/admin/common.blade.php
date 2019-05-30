<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理系统</title>
    <meta name="description" content="这是一个 index 页面">
    <meta name="keywords" content="index">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" href="{{config('oss.OSSDomain')}}asset/img/min_logo.png">
    {{--<link rel="icon" type="image/png" href="/assets/i/favicon.png">--}}
    <link rel="apple-touch-icon-precomposed" href="{{config('oss.OSSDomain')}}asset/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI" />
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/css/amazeui.min.css" />
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/css/admin.css">
    <link rel="stylesheet" href="{{config('oss.OSSDomain')}}asset/css/app.css">

</head>

<body data-type="index">


<header class="am-topbar am-topbar-inverse admin-header">
    <div class="am-topbar-brand">
        <a href="{{url('admin')}}" class="tpl-logo">
            <img src="{{config('oss.OSSDomain')}}asset/img/logo.png" alt="">
        </a>
    </div>
    <div class="am-icon-list tpl-header-nav-hover-ico am-fl am-margin-right">

    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only" data-am-collapse="{target: '#topbar-collapse'}"><span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list tpl-header-list">
            <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="am-icon-bell-o"></span> 提醒 <span class="am-badge tpl-badge-success am-round">5</span></span>
                </a>
                <ul class="am-dropdown-content tpl-dropdown-content">
                    <li class="tpl-dropdown-content-external">
                        <h3>你有 <span class="tpl-color-success">5</span> 条提醒</h3><a href="###">全部</a></li>
                    <li class="tpl-dropdown-list-bdbc"><a href="#" class="tpl-dropdown-list-fl"><span class="am-icon-btn am-icon-plus tpl-dropdown-ico-btn-size tpl-badge-success"></span> 【预览模块】移动端 查看时 手机、电脑框隐藏。</a>
                        <span class="tpl-dropdown-list-fr">3小时前</span>
                    </li>
                    <li class="tpl-dropdown-list-bdbc"><a href="#" class="tpl-dropdown-list-fl"><span class="am-icon-btn am-icon-check tpl-dropdown-ico-btn-size tpl-badge-danger"></span> 移动端，导航条下边距处理</a>
                        <span class="tpl-dropdown-list-fr">15分钟前</span>
                    </li>
                    <li class="tpl-dropdown-list-bdbc"><a href="#" class="tpl-dropdown-list-fl"><span class="am-icon-btn am-icon-bell-o tpl-dropdown-ico-btn-size tpl-badge-warning"></span> 追加统计代码</a>
                        <span class="tpl-dropdown-list-fr">2天前</span>
                    </li>
                </ul>
            </li>
            <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="am-icon-comment-o"></span> 消息 <span class="am-badge tpl-badge-danger am-round">9</span></span>
                </a>
                <ul class="am-dropdown-content tpl-dropdown-content">
                    <li class="tpl-dropdown-content-external">
                        <h3>你有 <span class="tpl-color-danger">9</span> 条新消息</h3><a href="###">全部</a></li>
                    <li>
                        <a href="#" class="tpl-dropdown-content-message">
                                <span class="tpl-dropdown-content-photo">
                      <img src="{{config('oss.OSSDomain')}}asset/img/user02.png" alt=""> </span>
                            <span class="tpl-dropdown-content-subject">
                      <span class="tpl-dropdown-content-from"> 禁言小张 </span>
                                <span class="tpl-dropdown-content-time">10分钟前 </span>
                                </span>
                            <span class="tpl-dropdown-content-font"> Amaze UI 的诞生，依托于 GitHub 及其他技术社区上一些优秀的资源；Amaze UI 的成长，则离不开用户的支持。 </span>
                        </a>
                        <a href="#" class="tpl-dropdown-content-message">
                                <span class="tpl-dropdown-content-photo">
                      <img src="{{config('oss.OSSDomain')}}asset/img/user03.png" alt=""> </span>
                            <span class="tpl-dropdown-content-subject">
                      <span class="tpl-dropdown-content-from"> Steam </span>
                                <span class="tpl-dropdown-content-time">18分钟前</span>
                                </span>
                            <span class="tpl-dropdown-content-font"> 为了能最准确的传达所描述的问题， 建议你在反馈时附上演示，方便我们理解。 </span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="am-icon-calendar"></span> 进度 <span class="am-badge tpl-badge-primary am-round">4</span></span>
                </a>
                <ul class="am-dropdown-content tpl-dropdown-content">
                    <li class="tpl-dropdown-content-external">
                        <h3>你有 <span class="tpl-color-primary">4</span> 个任务进度</h3><a href="###">全部</a></li>
                    <li>
                        <a href="javascript:;" class="tpl-dropdown-content-progress">
                                <span class="task">
                        <span class="desc">Amaze UI 用户中心 v1.2 </span>
                                <span class="percent">45%</span>
                                </span>
                            <span class="progress">
                        <div class="am-progress tpl-progress am-progress-striped"><div class="am-progress-bar am-progress-bar-success" style="width:45%"></div></div>
                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="tpl-dropdown-content-progress">
                                <span class="task">
                        <span class="desc">新闻内容页 </span>
                                <span class="percent">30%</span>
                                </span>
                            <span class="progress">
                       <div class="am-progress tpl-progress am-progress-striped"><div class="am-progress-bar am-progress-bar-secondary" style="width:30%"></div></div>
                    </span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="tpl-dropdown-content-progress">
                                <span class="task">
                        <span class="desc">管理中心 </span>
                                <span class="percent">60%</span>
                                </span>
                            <span class="progress">
                        <div class="am-progress tpl-progress am-progress-striped"><div class="am-progress-bar am-progress-bar-warning" style="width:60%"></div></div>
                    </span>
                        </a>
                    </li>

                </ul>
            </li>
            <li class="am-hide-sm-only"><a href="javascript:;" id="admin-fullscreen" class="tpl-header-list-link"><span class="am-icon-arrows-alt"></span> <span class="admin-fullText">开启全屏</span></a></li>

            <li class="am-dropdown" data-am-dropdown data-am-dropdown-toggle>
                <a class="am-dropdown-toggle tpl-header-list-link" href="javascript:;">
                    <span class="tpl-header-list-user-nick"> {{$admin['name']}}</span><span class="tpl-header-list-user-ico"> <img src="{{config('oss.OSSDomain')}}asset/img/default_avatar.jpg"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li><a href="#"><span class="am-icon-bell-o"></span> 资料</a></li>
                    <li><a href="#"><span class="am-icon-cog"></span> 设置</a></li>
                    <li><a href="{{url('admin/logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><span class="am-icon-power-off"></span> 退出</a></li>
                </ul>
            </li>
            <li><a href="{{url('admin/logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="tpl-header-list-link"><span class="am-icon-sign-out tpl-header-list-ico-out-size"></span></a></li>
            <form id="logout-form" action="{{ url('admin/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

        </ul>
    </div>
</header>

<div class="tpl-page-container tpl-page-header-fixed">

    <div class="tpl-left-nav tpl-left-nav-hover">
        <div class="tpl-left-nav-title">
            后台管理系统
        </div>
        <div class="tpl-left-nav-list">
            <ul class="tpl-left-nav-menu">
                @foreach($menu_nav as $val)
                    @if(!isset($val['children']))
                        <li class="tpl-left-nav-item">
                            <a href="{{url($val['ac'])}}{{$val['url_params']}}" class="nav-link" data-url="{{$val['ac']}}">
                                <i class="{{$val['icon_class']}}"></i>
                                <span>{{$val['menu_name']}}</span>
                            </a>
                        </li>
                    @else
                        <li class="tpl-left-nav-item">
                            <a href="javascript:;" class="nav-link tpl-left-nav-link-list">
                                <i class="{{$val['icon_class']}}"></i>
                                <span>{{$val['menu_name']}}</span>
                                <i class="am-icon-angle-right tpl-left-nav-more-ico am-fr am-margin-right"></i>
                            </a>
                            <ul class="tpl-left-nav-sub-menu">
                                <li>
                                    @foreach($val['children'] as $v)
                                        <a href="{{url($v['ac'])}}{{$v['url_params']}}" data-url="{{$v['ac']}}">
                                            <i class="am-icon-angle-right"></i>
                                            <span>{{$v['menu_name']}}</span>
                                            {{--                                        @if($v['name'] =='小说详情')--}}
                                            {{--<i class="tpl-left-nav-content tpl-badge-success">--}}
                                            {{--                                            {{$book_count}}--}}
                                            {{--</i>--}}
                                            {{--@endif--}}
                                        </a>
                                    @endforeach
                                </li>
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
    <script src="{{config('oss.OSSDomain')}}asset/js/jquery.min.js"></script>
    <script src="{{config('oss.OSSDomain')}}asset/js/amazeui.min.js"></script>
    <script src="{{config('oss.OSSDomain')}}asset/js/app.js"></script>
    <script src="{{config('oss.OSSDomain')}}asset/js/layui.all.js"></script>
    <script src="{{config('oss.OSSDomain')}}asset/js/lrz.all.bundle.js"></script>

    @yield('content')

    @show
    {{--表单验证错误信息弹窗--}}
    @if (isset($errors))
        @if (count($errors) > 0 )
            <script>
                var errors ='<?php echo json_encode( $errors->all());?>';
                errors = JSON.parse(errors);
                var error_html = '';
                errors.forEach(function(e){
                    error_html += e+'<br>';
                });
                layer.msg(error_html,{icon:2}); //icon  0-!,1-success,2-error,3-?,4-锁,5-难过,6-微笑,7-云下载
            </script>
        @endif
    @endif
    @if (Session::has('flash_message'))
        <script>
            var flash_message ='<?php echo json_encode( Session::get('flash_message'));?>';
            flash_message = JSON.parse(flash_message);
            layer.msg(flash_message,{icon:1});
        </script>
    @endif
    @if (Session::has('error_message'))
        <script>
            var error_message ='<?php echo json_encode( Session::get('error_message'));?>';
            error_message = JSON.parse(error_message);
            layer.msg(error_message,{icon:2});
        </script>
    @endif
</div>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function () {
        $('#startTime').datepicker({
            inline: true,
            dateFormat: 'yy-mm-dd'
        });
        $('#endTime').datepicker({
            inline: true,
            dateFormat: 'yy-mm-dd'
        });

        //左侧导航栏默认选中样式
        var url_path = window.location.pathname;
        var url_index = find(url_path,'/',2);
        var url_str = (url_index>0)?url_path.slice(0,url_index):url_path;
        url_str = getCaption(url_str);
        $(".tpl-left-nav-menu a").each(function () {
            var this_str = $(this).attr('data-url');
            if(this_str == url_str){
                $(this).addClass('active').parents('li').find('ul').css('display','block');
                $(this).parents('li').find('.nav-link>i:nth-child(3)').addClass('tpl-left-nav-more-ico-rotate');
            }
        })

        //筛选搜索
        $('#search_btn').click(function () {
            $('#searchList').submit();
        });
        //回车事件
        $(document).keyup(function(event){
            if(event.keyCode ==13){
                $("#search_btn").trigger("click");
            }
        });

        //全选或全不选
        $("#allChoose").click(function(){
            if(this.checked){
                $(this).parents('table').find('tbody input[type="checkbox"]').prop("checked", true);
            }else{
                $(this).parents('table').find('tbody input[type="checkbox"]').prop("checked", false);
            }
        });
        //设置全选复选框
        $("#table tbody input:checkbox").click(function(){
            allchk();
        });

        //图片点击放大效果，img父级追加ID layer-photos-demo
        layer.photos({
            photos: '#layer-photos-demo',
            anim: 3 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });

        $('.del').click(function () {
            var del_obj = $(this);
            var id = del_obj.attr('data-id');
            layer.confirm('确定要删除吗？', {
                icon: 0,
                btn: ['删除','取消'] //按钮
            }, function(){
                var url = window.location.pathname+'/'+id;
                $.post(url,{_method:'DELETE'},function (res) {
                    del_obj.parents('tr').remove();
                    layer.msg('删除成功',{icon:1,time:800},function () {
                        window.location.reload();
                    });
                })
            }, function(){
            });
        })
    })

    function find(str,cha,num){
        var x=str.indexOf(cha);
        for(var i=0;i<num;i++){
            x=str.indexOf(cha,x+1);
        }
        return x;
    }

    function allchk(){
        var chknum = $("#table tbody input:checkbox").size();//选项总个数
        var chk = 0;
        $("#table tbody input:checkbox").each(function () {
            if($(this).prop("checked")==true){
                chk++;
            }
        });
        if(chknum==chk){//全选
            $("#allChoose").prop("checked",true);
        }else{//不全选
            $("#allChoose").prop("checked",false);
        }
    }

    function getCaption(obj){   //获取/第一次出现后面的字符串
        var index=obj.indexOf("/");
        obj=obj.substring(index+1,obj.length);
        return obj;
    }

    function GetQueryString(name)  //截取url 传递的 值
    {
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if(r!=null)return  unescape(r[2]); return null;
    }

    function ConfirmDelete()
    {
        var x = confirm("确定要删除吗?");
        if (x)
            return true;
        else
            return false;
    }

    function UrlSearch() {
        var name,value;
        var new_arr = [];
        var str=location.href; //取得整个地址栏
        var num=str.indexOf("?");
        str=str.substr(num+1); //取得所有参数   stringvar.substr(start [, length ]
        var arr=str.split("&"); //各个参数放到数组里
        for(var i=0;i < arr.length;i++){
            num=arr[i].indexOf("=");
            if(num>0){
                name=arr[i].substring(0,num);
                value=arr[i].substr(num+1);
                new_arr[name]=value;
            }
        }
        return new_arr;
    }
</script>
</body>
</html>