@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 广告管理
                </div>
            </div>
            <div class="tpl-block">
                <form action="" method="get" id="searchList">
                    <div class="am-g">
                        <div class="am-btn-group">
                            <select data-am-selected="{btnSize: 'sm'}" name="type">
                                <option value="">请选择分类</option>
                                @foreach($tjArr as $k=>$v)
                                    <option value="{{$k}}" @if(isset($searchArr['type']) and count($searchArr['type'])>0 and intval($searchArr['type']) === $k) selected @endif >{{$v}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="am-btn-group">
                            <select data-am-selected="{btnSize: 'sm'}" name="dstatus">
                                <option value="">请选择广告状态</option>
                                <option value="1" @if(isset($searchArr['dstatus']) and $searchArr['dstatus'] == 1) selected @endif >显示</option>
                                <option value="2" @if(isset($searchArr['dstatus']) and $searchArr['dstatus'] == 2) selected @endif >隐藏</option>
                            </select>
                        </div>
                        <div class="am-btn-group">
                            <input class="am-form-field" name="startDate" value="{{$searchArr['startDate'] or ''}}" placeholder="创建开始时间" id="startTime" style="width:100px;" autocomplete="off"/>
                        </div> ~
                        <div class="am-btn-group">
                            <input class="am-form-field" name="endDate" value="{{$searchArr['endDate'] or ''}}" placeholder="创建结束时间" id="endTime" style="width:100px;" autocomplete="off"/>
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
                                <button type="button" class="am-btn am-btn-default am-btn-success" onclick="window.location.href='{{url('admin/banner/create')}}'"><span class="am-icon-plus"></span> 新增</button>
                            </div>
                        </div>
                    </div>
                    <div class="am-u-sm-12 am-scrollable-horizontal">
                        <form class="am-form">
                            <table class="am-table am-table-striped am-table-hover table-main am-text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>图片</th>
                                    <th>标题</th>
                                    <th>分类</th>
                                    <th>状态</th>
                                    <th>创建时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data)>0)
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>{{ $v->id }}</td>
                                            <td id="layer-photos-demo">
                                                @if($v->pic)
                                                    <img src="{{ $v->pic}}" data-rel="{{ $v->pic}}" style="height: 48px;" />
                                                @endif
                                            </td>
                                            <td>{{ $v->title}}</td>
                                            <td>{{ $v->type }}</td>
                                            <td>{{ $v->dstatus }}</td>
                                            <td>{{ $v->created_at }}</td>
                                            <td>
                                                <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-secondary" onclick="window.location='{{url('admin/banner/update')}}/{{$v['id']}}'"><span class="am-icon-pencil-square-o"></span>编辑</a>
                                                <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-danger del" data-id="{{$v->id}}"><span class="am-icon-pencil-square-o"></span>删除</a>
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
@stop
