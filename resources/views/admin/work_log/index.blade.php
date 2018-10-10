@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 日志列表
                </div>
            </div>
            <div class="tpl-block">
                <form action="" method="get" id="searchList">
                    <div class="am-g">
                        <div class="am-btn-group">
                            <input type="text" class="am-form-field am-radius" name="name" value="{{$searchArr['name'] or ''}}" placeholder="  请输入用户名"/>
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
                                    <th>管理员ID</th>
                                    <th>用户名</th>
                                    <th>请求地址</th>
                                    <th>请求方式</th>
                                    <th>ip</th>
                                    <th>请求参数</th>
                                    <th>请求时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data)>0)
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>{{ $v->id }}</td>
                                            <td>{{ $v->admin_id }}</td>
                                            <td>{{ $v->admin->name }}</td>
                                            <td>{{ $v->path }}</td>
                                            <td>{{ $v->method }}</td>
                                            <td>{{ $v->ip }}</td>
                                            <td title="{{$v->input}}">
                                                @if(mb_strlen( $v->input ,'utf-8')>20)
                                                    {{mb_substr( $v->input ,0,40,'utf-8')}}...
                                                @else
                                                    {{ $v->input }}
                                                @endif
                                            </td>
                                            <td>{{ $v->created_at }}</td>
                                            <td style="display: flex;">
                                                <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-danger del" data-id="{{$v->id}}"><span class="am-icon-pencil-square-o"></span>删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9"><div style="text-align: center">暂无更多记录</div></td>
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
