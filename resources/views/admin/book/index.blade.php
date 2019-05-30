
@extends('admin.common')
@section('content')
    <style>
        .tpl-edit-content-btn{
            display: -webkit-flex;
            display: flex;
            -webkit-align-items: center;
            align-items: center;
            -webkit-justify-content: center;
            justify-content: center;
            margin: auto;
        }
        .tpl-edit-content-btn button{
            margin:0 20px;
        }
    </style>
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> <a href="javascript:void(0)" onclick="showType('img')">图片列表</a>  |  <a href="javascript:void(0)" onclick="showType('font')">文字列表</a>
                </div>
            </div>
            <div class="tpl-block">
                <form action="" method="get" id="searchList">
                <div class="am-g">
                    <div class="am-btn-group">
                        <input type="text" class="am-form-field am-radius" name="name" value="{{$searchArr['name'] or ''}}" placeholder="  请输入书名或作者名"/>
                    </div>
                    <div class="am-btn-group">
                        <select data-am-selected="{btnSize: 'sm'}" name="type">
                            <option value="">请选择小说分类</option>
                            @foreach($data['bookType'] as $v)
                                <option value="{{$v['id']}}" @if(isset($searchArr['type']) and $searchArr['type'] == $v['id']) selected @endif >{{$v['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="am-btn-group">
                        <select data-am-selected="{btnSize: 'sm'}" name="tj">
                            <option value="">请选择推荐栏目</option>
                            @foreach($data['tjArr'] as $k=>$v)
                                <option value="{{$k}}" @if(isset($searchArr['tj']) and count($searchArr['tj'])>0 and intval($searchArr['tj']) === $k) selected @endif >{{$v}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="am-btn-group">
                        <select data-am-selected="{btnSize: 'sm'}" name="over">
                            <option value="">请选择内容状态</option>
                            <option value="1" @if(isset($searchArr['over']) and $searchArr['over'] == 1) selected @endif >连载</option>
                            <option value="2" @if(isset($searchArr['over']) and $searchArr['over'] == 2) selected @endif >完结</option>
                        </select>
                    </div>
                    <div class="am-btn-group">
                        <select data-am-selected="{btnSize: 'sm'}" name="dstatus">
                            <option value="">请选择小说状态</option>
                            <option value="1" @if(isset($searchArr['dstatus']) and $searchArr['dstatus'] == 1) selected @endif >显示</option>
                            <option value="2" @if(isset($searchArr['dstatus']) and $searchArr['dstatus'] == 2) selected @endif >隐藏</option>
                        </select>
                    </div>
                    <div class="am-btn-group">
                        <select data-am-selected="{btnSize: 'sm'}" name="orderBy">
                            <option value="">请选择排序方式</option>
                            <option value="1" @if($orderBy == 1) selected @endif >sort升序</option>
                            <option value="2" @if($orderBy == 2) selected @endif >sort降序</option>
                            <option value="3" @if($orderBy == 3) selected @endif >更新时间升序</option>
                            <option value="4" @if($orderBy == 4) selected @endif >更新时间降序</option>
                        </select>
                    </div>
                    <div class="am-btn-group">
                        <button class="am-btn am-btn-default am-btn-success tpl-am-btn-success am-icon-search" id="search_btn" type="button"></button>
                    </div>
                </div>
                </form>
                <br>
                <div class="am-g">
                    @if($showType == 'font')
                        <div class="am-u-sm-12 am-u-md-6">
                            <div class="am-btn-toolbar">
                                <div class="am-btn-group am-btn-group-xs">
                                    {{--<button type="button" class="am-btn am-btn-default am-btn-secondary"><span class="am-icon-save"></span> 保存</button>--}}
                                    {{--<button type="button" class="am-btn am-btn-default am-btn-warning" onclick="del()"><span class="am-icon-archive"></span> 还原</button>--}}
                                    <button type="button" class="am-btn am-btn-default am-btn-success" onclick="window.location.href='{{url('admin/book/create')}}'"><span class="am-icon-plus"></span> 新增</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-danger" onclick="del(0)"><span class="am-icon-trash-o"></span> 批量删除</button>
                                    <button type="button" class="am-btn am-btn-default am-btn-secondary recycle"><span class="am-icon-save"></span> 回收站
                                        {{--<span class="am-badge-danger am-round">&nbsp;&nbsp;{{$data['recycle_count']}}&nbsp;&nbsp;</span>--}}
                                        （<span style="color: #f00;">{{$data['recycle_count']}}</span>）

                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="am-u-sm-12 am-scrollable-horizontal">
                            <table class="am-table am-table-striped am-table-hover table-main am-text-nowrap" id="table">
                                <thead>
                                <tr>
                                    <th class="table-check"><input type="checkbox" name="" class="tpl-table-fz-check"  id="allChoose"></th>
                                    <th class="table-id">ID</th>
                                    <th class="table-title">标题</th>
                                    <th class="table-type">类别</th>
                                    <th class="table-type">作者</th>
                                    <th class="table-type" style="width: 40px;">排序</th>
                                    <th class="table-type">推荐栏目</th>
                                    <th class="table-type">内容状态</th>
                                    <th class="table-type">状态</th>
                                    {{--<th class="table-date am-hide-sm-only">创建日期</th>--}}
                                    <th class="table-date am-hide-sm-only">更新日期</th>
                                    <th class="table-set">操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data['bookData'])>0)
                                    @foreach($data['bookData'] as $v)
                                        <tr>
                                            <td><input type="checkbox"></td>
                                            <td class="id">{{$v['id']}}</td>
                                            <td><a href="{{url('admin/book/detail')}}/{{$v['id']}}">{{$v['name']}}</a></td>
                                            <td>{{$v['type']}}</td>
                                            <td>{{$v['writer']}}</td>
                                            <td><input type="text" name="sort" class="sort" value="{{$v['sort']}}" style="width: 40px;"></td>
                                            <td>{!! $v['tj'] !!}</td>
                                            <td>{!! $v['over'] !!}</td>
                                            <td>{!! $v['dstatus'] !!}</td>
                                            {{--<td>{{ $v['created_at'] }}</td>--}}
                                            <td>{{ $v['updated_at'] }}</td>
                                            <td>
                                                <div class="am-btn-toolbar">
                                                    <div class="am-btn-group am-btn-group-xs" data-id="{{$v['id']}}">
                                                        @if(empty($v['deleted_at']))
                                                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="window.location.href='{{url('admin/book/update')}}/{{$v['id']}}'"><span class="am-icon-pencil-square-o"></span>编辑</button>
                                                            <button type="button" class="am-btn am-btn-default am-text-warning" onclick="location.href='{{url('admin/book/detail')}}/{{$v['id']}}'"><span class="am-icon-tasks"></span>详情</button>
                                                            <button type="button" class="am-btn am-btn-default am-text-primary" onclick="book_update({{$v['id']}})"><span class="am-icon-tasks"></span>更新</button>
                                                        @else
                                                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="restore({{$v['id']}})"><span class="am-icon-pencil-square-o"></span>还原</button>
                                                        @endif
                                                        <button class="am-btn am-btn-default am-btn-xs am-text-danger" onclick="del({{$v['id']}})"><span class="am-icon-trash-o"></span>删除</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12"><div style="text-align: center">暂无更多记录</div></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            <div class="am-u-lg-12">
                                <div class="am-cf">
                                    <div class="am-fr">
                                        <ul class="am-pagination tpl-pagination">
                                            {!! $data['bookData']->appends($searchArr)->links() !!}
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <hr>
                        </div>
                    @else
                        <div class="tpl-table-images">
                            @foreach($data['bookData'] as $v)
                                <div class="am-u-sm-12 am-u-md-6 am-u-lg-4" style="width: 313px;height: 600px;">
                                    <div class="tpl-table-images-content">{{$v['name']}}
                                        <div class="tpl-table-images-content-i-time">更新时间：{{ $v['updated_at'] }}&nbsp;&nbsp;</div>
                                        <div class="tpl-i-title" style="height: 32px;font-size: 12px">
                                            类型：{!! $v['type'] !!}  | 作者：{{$v['writer']}}
                                        </div>
                                        <a href="javascript:;" class="tpl-table-images-content-i" title="{{$v['intro']}}" onclick="location.href='{{url('admin/book/detail')}}/{{$v['id']}}'">
                                            <span class="tpl-table-images-content-i-shadow"></span>
                                            <img src="{{$v['pic']}}" style="height:250px;">
                                        </a>
                                        <div class="tpl-table-images-content-block">
                                            <div class="tpl-i-font" style="height: 42px;" title="{{$v['intro']}}" >
                                                @if($v['intro'])
                                                    {{$v['intro']}}
                                                @else
                                                    暂无简介
                                                @endif
                                            </div>
                                            <div class="tpl-i-more">
                                                <ul>
                                                    <li>&nbsp;<span class="am-icon-comments am-text-warning" title="评论数"> {{$v['review_num']}}+</span></li>
                                                    <li>&nbsp;<span class="am-icon-thumbs-o-up am-text-success" title="点击量"> {{$v['click_num']}}+</span></li>
                                                </ul>
                                            </div>
                                            <div class="am-btn-toolbar btn-div" style="margin-top: 10px;">
                                                <div class="am-btn-group am-btn-group-xs tpl-edit-content-btn">
                                                    <button type="button" class="am-btn am-btn-default am-btn-secondary" onclick="location.href='{{url('admin/book/update')}}/{{$v['id']}}'"><span class="am-icon-edit"></span>编辑</button>
                                                    <button type="button" class="am-btn am-btn-default am-btn-warning" onclick="location.href='{{url('admin/book/detail')}}/{{$v['id']}}'"><span class="am-icon-tasks"></span>详情</button>
                                                    <button class="am-btn am-btn-default am-btn-xs am-btn-danger" onclick="del({{$v['id']}})"><span class="am-icon-trash-o"></span>删除</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="am-u-lg-12">
                                <div class="am-cf">
                                    <div class="am-fr">
                                        <ul class="am-pagination tpl-pagination">
                                            {!! $data['bookData']->appends($searchArr)->links() !!}
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    @endif
                    </div>
                </div>
            </div>
            <div class="tpl-alert"></div>
        </div>
    <script>
        $(function () {
            //修改排序
            $('.sort').blur(function () {
                var sort = $(this).val();
                var id = $(this).parents().children('.id').text();
                $.post('{{url('admin/book/sort')}}/'+id,'sort='+sort,function (res) {
                    layer.msg(res.msg,{icon:1,time:800},function(index){
                        // window.location.reload();
                    });
                },'json')
            })

            //回收站
            $('.recycle').click(function () {
                var recycle_url = location.pathname+'?recycle=onlyTrashed';
                window.location.href = recycle_url;
            })
        })

        function del(id) {
            /*判断是否删除回收车数据*/
            if(GetQueryString('recycle') == 'onlyTrashed'){
                var del_url = "{{url('admin/book/del')}}"+"?recycle=onlyTrashed";
            }else{
                var del_url = "{{url('admin/book/del')}}";
            }
            /*判断是否批量删除*/
            if(id>0){
                layer.confirm('确定要删除吗？', {
                    icon:0,
                    btn: ['删除','取消'] //按钮
                }, function(){
                    $.post(del_url,'id='+id,function (res) {
                        layer.msg('删除成功',{icon:1,time:1000},function () {
                            window.location.reload();
                        });
                    })
                }, function(){
                });
            }else{
                var $checkbox = $('table tbody input[type="checkbox"]');
                var $checked = $('table tbody input[type="checkbox"]:checked');
                if($checkbox.is(":checked")){
                    layer.confirm('确定要删除吗？', {
                        icon:0,
                        btn: ['删除','取消'] //按钮
                    }, function(){
                        var idStr = '';
                        //删除数据
                        for(var j=0;j<$checked.length;j++){
                            idStr += $checked.eq(j).parents("tr").children('.id').text() + ',';
                        }
                        idStr=idStr.substring(0,idStr.length-1);
                        $.post(del_url,'id='+idStr,function (res) {
                            layer.msg('删除成功',{icon:1,time:1000},function () {
                                window.location.reload();
                            });
                        })
                    }, function(){
                    });
                }else{
                    layer.msg("请选择需要操作的小说",{icon:0});
                }
            }
        }

      
        /*拼接列表展示样式url*/
        function showType(type) {
            var urlArr = UrlSearch();
            delete urlArr['recycle'];
            urlArr['showType'] = type;
            var urlStr = '?';
            for(var tmp in urlArr){
                urlStr += tmp+'='+urlArr[tmp]+'&';
            }
            urlStr = urlStr.substr(0, urlStr.length - 1);
            window.location.href = window.location.pathname + urlStr;
        }
        /*还原已删除数据*/
        function restore(id) {
            layer.confirm('确定要还原吗？', {
                btn: ['还原','取消'] //按钮
            }, function(){
                $.post('{{url('admin/book/restore')}}','id='+id,function (res) {
                    layer.msg('还原成功',{icon:1,time:1000},function () {
                        window.location.reload();
                    });
                })
            }, function(){
            });
        }
        /*更新小说*/
        function book_update(id) {
            layer.confirm('确定要更新吗？<br>如若是初次抓取等待时间过长,可自行刷新页面观察是否抓取完毕', {
                icon:0,
                btn: ['确定','取消'] //按钮
            }, function(index1){
                layer.close(index1);
                var index = layer.load(3, {
                    shade: [0.1,'#636363'] //0.1透明度的白色背景
                });
                $.post('{{url('admin/book/execPython')}}/'+id,function (res){
                    layer.close(index);
                    console.log(res);
                    layer.msg(res.msg,{icon:1,time:1000},function () {
                        window.location.reload();
                    });
                })
            }, function(){
            });
        }
    </script>
@stop
