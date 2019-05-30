@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 意见反馈列表
                </div>
            </div>
            <div class="tpl-block">
                <form action="" method="get" id="searchList">
                    <div class="am-g">
                        <div class="am-btn-group">
                            <select data-am-selected="{btnSize: 'sm'}" name="dstatus">
                                <option value="">请选择状态</option>
                                <option value="0" @if(isset($searchArr['dstatus']) and $searchArr['dstatus'] == 0) selected @endif >未读</option>
                                <option value="1" @if(isset($searchArr['dstatus']) and $searchArr['dstatus'] == 1) selected @endif >已读</option>
                            </select>
                        </div>
                        <div class="am-btn-group">
                            <input class="am-form-field" name="startDate" value="{{$searchArr['startDate'] or ''}}" placeholder="开始时间" id="startTime" style="width:100px;" autocomplete="off"/>
                        </div> ~
                        <div class="am-btn-group">
                            <input class="am-form-field" name="endDate" value="{{$searchArr['endDate'] or ''}}" placeholder="结束时间" id="endTime" style="width:100px;" autocomplete="off"/>
                        </div>
                        <div class="am-btn-group">
                            <button class="am-btn am-btn-default am-btn-success tpl-am-btn-success am-icon-search" id="search_btn" type="button"></button>
                        </div>
                    </div>
                </form>
                <div class="am-g">
                    <div class="am-u-sm-12 am-scrollable-horizontal">
                        <form class="am-form">
                            <table class="am-table am-table-striped am-table-hover table-main am-text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>用户ID</th>
                                    <th>反馈图片</th>
                                    <th>反馈内容</th>
                                    <th>是否已读</th>
                                    <th>反馈时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data)>0)
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>{{ $v->id }}</td>
                                            <td>{{ $v->uid }}</td>
                                            <td id="layer-photos-demo">
                                                @if($v->pic)
                                                    @foreach($v->pic as $vv)
                                                            <img src="{{$vv}}" data-rel="{{$vv}}" style="height: 28px;" />
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>{{ $v->content }}</td>
                                            <td>{{ $v->dstatusCn }}</td>
                                            <td>{{ $v->created_at }}</td>
                                            <td style="display: flex;">
                                                @if($v->dstatus == '0')
                                                    <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="is_read('{{$v->id}}')"><span class="am-icon-pencil-square-o"></span>已读</a>
                                                @else
                                                    <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-danger del" data-id="{{$v->id}}"><span class="am-icon-pencil-square-o"></span>删除</a>
                                                @endif
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
                                            {!! $data->links() !!}
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tpl-alert"></div>
        </div>
    </div>
    <script>
        function is_read(id) {
            $.post('{{url('admin/feedback/is_read')}}'+'/'+id,function (res) {
                if(res.status == 1){
                    layer.msg(res.msg,{icon:1,time:1000},function () {
                        window.location.reload();
                    });
                }else{
                    layer.msg(res.msg,{icon:2,time:1000});
                }
            })
        }
    </script>
@stop
