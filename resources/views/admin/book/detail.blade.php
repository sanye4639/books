@extends('admin.common')
@section('content')
    <style>
        .tpl-edit-content-btn{
            width: 500px;
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
            @if($chapter_id < 0)
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> <a href="{{url('admin/book')}}">小说列表</a> > <a href="{{url('admin/book/detail')}}/{{$data['id']}}">{{$data['name']}}</a>
                        @if($showType == 'img')
                            >
                            <a href="{{url('admin/book/detail')}}/{{$data['id']}}?orderBy=1">倒序</a>
                            @endif
                    </div>
                </div>
                @if($showType == 'font')
                    <div class="tpl-block">
                        <form action="" method="get" id="searchList">
                            <div class="am-g">
                                <div class="am-btn-group">
                                    <input type="text" class="am-form-field am-radius" name="title" value="{{$searchArr['title'] or ''}}" placeholder="  请输入章节名称"/>
                                </div>
                                <div class="am-btn-group">
                                    <button class="am-btn am-btn-default am-btn-success tpl-am-btn-success am-icon-search" id="search_btn" type="button"></button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="am-g">
                            <div class="am-u-sm-12 am-u-md-6">
                                <div class="am-btn-toolbar">
                                    <div class="am-btn-group am-btn-group-xs">
                                        <button type="button" class="am-btn am-btn-default am-btn-danger" onclick="del(0,'{{$data['id']}}')"><span class="am-icon-trash-o"></span> 批量删除</button>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-12 am-scrollable-horizontal">
                                <table class="am-table am-table-striped am-table-hover table-main am-text-nowrap" id="table">
                                    <thead>
                                    <tr>
                                        <th class="table-check"><input type="checkbox" name="" class="tpl-table-fz-check"  id="allChoose"></th>
                                        <th class="table-id" style="display: none">ID</th>
                                        <th class="table-title">标题</th>
                                        <th class="table-type">抓取url</th>
                                        <th class="table-type">访问url</th>
                                        <th class="table-date am-hide-sm-only">更新日期</th>
                                        <th class="table-set">操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($chapterList)>0)
                                        @foreach($chapterList as $v)
                                            <tr>
                                                <td><input type="checkbox"></td>
                                                <td class="id" style="display: none">{{$v->id}}</td>
                                                <td><a href="{{url('admin/book/detail')}}/{{$v->book_id}}?chapter_id={{$v->id}}">{{$v->title}}</a></td>
                                                <td><a href="{{$v->url}}" target="_blank">{{$v->url}}</a></td>
                                                <td>{{$v->oss_url}}</td>
                                                <td>{{ $v->created_at }}</td>
                                                <td>
                                                    <div class="am-btn-toolbar">
                                                        <div class="am-btn-group am-btn-group-xs" data-id="{{$v->id}}">
                                                            <button type="button" class="am-btn am-btn-default am-text-primary" onclick="chapter_update('{{$v->id}}','{{$v->book_id}}')"><span class="am-icon-tasks"></span> 更新</button>
                                                            <button class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="location.href='{{url('admin/book/detail')}}/{{$v->book_id}}?chapter_id={{$v->id}}'"><span class="am-icon-pencil-square-o"></span>编辑</button>
                                                            <button class="am-btn am-btn-default am-btn-xs am-text-danger" onclick="del('{{$v->id}}','{{$v->book_id}}')"><span class="am-icon-trash-o"></span>删除</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7"><div style="text-align: center">暂无更多记录</div></td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                                <div class="am-u-lg-12">
                                    <div class="am-cf">
                                        <div class="am-fr">
                                            <ul class="am-pagination tpl-pagination">
                                                {!! $chapterList->appends($searchArr)->links() !!}
                                            </ul>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <script>
                        function del(id,book_id) {
                            var del_url = "{{url('admin/book/del')}}"+"?recycle=chapter";
                            /*判断是否批量删除*/
                            if(id>0){
                                layer.confirm('确定要删除吗？', {
                                    btn: ['删除','取消'] //按钮
                                }, function(){
                                    $.post(del_url,'id='+id+'&book_id='+book_id,function (res) {
                                        if(res.status == 1){
                                            layer.msg('删除成功',{icon:1,time:1000},function () {
                                                window.location.reload();
                                            });
                                        }else{
                                            layer.msg(res.msg,{icon:2,time:1000});
                                        }
                                    })
                                }, function(){
                                });
                            }else{
                                var $checkbox = $('table tbody input[type="checkbox"]');
                                var $checked = $('table tbody input[type="checkbox"]:checked');
                                if($checkbox.is(":checked")){
                                    layer.confirm('确定要删除吗？', {
                                        btn: ['删除','取消'] //按钮
                                    }, function(){
                                        var idStr = '';
                                        //删除数据
                                        for(var j=0;j<$checked.length;j++){
                                            idStr += $checked.eq(j).parents("tr").children('.id').text() + ',';
                                        }
                                        idStr=idStr.substring(0,idStr.length-1);
                                        $.post(del_url,'id='+idStr+'&book_id='+book_id,function (res) {
                                            if(res.status == 1){
                                                layer.msg('删除成功',{icon:1,time:1000},function () {
                                                    window.location.reload();
                                                });
                                            }else{
                                                layer.msg(res.msg,{icon:2,time:1000});
                                            }
                                        })
                                    }, function(){
                                    });
                                }else{
                                    layer.msg("请选择需要操作的章节",{icon:0});
                                }
                            }
                        }

                        /*更新章节*/
                        function chapter_update(chapter_id,book_id) {
                            layer.confirm('确定要更新吗？', {
                                icon:0,
                                btn: ['确定','取消'] //按钮
                            }, function(index1){
                                layer.close(index1);
                                var index = layer.load(3, {
                                    shade: [0.1,'#636363'] //0.1透明度的白色背景
                                });
                                $.post('{{url('admin/book/execPythonChapter')}}/'+book_id,{'chapter_id':chapter_id},function (res){
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
                @else
                    <table class="am-table am-table-bordered am-table-striped am-table-hover chapterList-table">
                        <tr class="am-active">
                            @foreach($chapterList as $k=>$v)
                                <td width="33%" title="{{$v['title']}}">
                                    <a href="{{url('admin/book/detail')}}/{{$v['book_id']}}?chapter_id={{$v['id']}}">
                                        @if(mb_strlen($v['title'],'utf-8')>20)
                                            {{mb_substr($v['title'],0,20,'utf-8')}}...
                                        @else
                                            {{$v['title']}}
                                        @endif
                                    </a>
                                </td>
                                @if(($k+1)%3 == 0 && $k+1<count($chapterList))
                        </tr><tr>
                            @endif
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                    <a href="javascript:void(0)" title="回到顶部" class="am-icon-btn am-icon-arrow-up" data-am-smooth-scroll="{position: 0}" style="position: fixed;right:50px;bottom: 20px;"></a>
                @endif
            @else
                <div class="portlet-title">
                    <div class="caption font-green bold">
                        <span class="am-icon-code"></span> <a href="{{url('admin/book')}}">小说列表</a> > <a href="{{url('admin/book/detail')}}/{{$data['id']}}">{{$data['name']}}</a> > {{$chapterList['title']}}
                    </div>
                </div>
                <table class="am-table am-table-bordered am-table-striped">
                    <tr class="am-active">
                      <td @if($showType == 'font') contenteditable="true" @endif id="content">
                           {!! $chapterList['content'] !!}
                      </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="tpl-edit-content-btn">
                                @if($showType == 'font')
                                    <button type="button" class="am-btn am-btn-default" onclick="history.go(-1)">返回</button>
                                    <button type="button" class="am-btn am-btn-success" onclick="change_content()">保存</button>
                                @else
                                    <button type="button" class="am-btn am-btn-default" onclick="window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}?chapter_id={{$chapterList['last_chapterId']}}'" @if($chapterList['last_chapterId'] == 0) disabled="disabled" @endif>上一页</button>
                                    <button type="button" class="am-btn am-btn-default" onclick="window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}'">目录</button>
                                    <button type="button" class="am-btn am-btn-default" onclick="window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}?chapter_id={{$chapterList['next_chapterId']}}'" @if($chapterList['next_chapterId'] == 0) disabled="disabled" @endif>下一页</button>
                                @endif
                            </div>
                        </td>
                    </tr>
                </table>
                <script>

                    var last_chapterId = "{{$chapterList['last_chapterId']}}";
                    var next_chapterId = "{{$chapterList['next_chapterId']}}";
                    $(document).keydown(function(event){
                        //判断当event.keyCode 为37时（即左方面键），执行函数to_left();
                        //判断当event.keyCode 为39时（即右方面键），执行函数to_right();
                        if(event.keyCode == 37){
                            if(last_chapterId > 0){
                                window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}?chapter_id=' + last_chapterId;
                            }else{
                                window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}';
                            }
                        }else if (event.keyCode == 39){
                            if(next_chapterId > 0){
                                window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}?chapter_id=' + next_chapterId;
                            }else{
                                window.location.href='{{url('admin/book/detail')}}/{{$data['id']}}';
                            }
                        }
                    });
                    function change_content() {
                        layer.confirm('确定要更改章节内容吗？',{
                            icon:0,
                            btn: ['确定','取消'] //按钮
                        }, function(){
                            var content = $('#content').text();
                            console.log(content);
                            $.post('{{url('admin/book/update_chapter')}}/{{$data['id']}}',{chapter_id:'{{$chapterList['id']}}',content:content},function (res) {
                                if(res.status == 1){
                                    layer.msg('更改成功',{icon:1,time:1000},function () {
                                        window.location.reload();
                                    });
                                }else{
                                    layer.msg(res.msg,{icon:2,time:1000});
                                }
                            })
                        }, function(){
                        });
                    }
                </script>
            @endif
        </div>
    </div>
@stop
