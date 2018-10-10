@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 菜单列表
                </div>
            </div>
            <div class="tpl-block">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-md-6">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <button type="button" class="am-btn am-btn-default am-btn-success" onclick="window.location.href='{{ URL::to('admin/menu/create') }}'"><span class="am-icon-plus"></span> 新增</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="am-g">
                    <div class="am-u-sm-12 am-scrollable-horizontal">
                        <form class="am-form">
                            <table class="am-table am-table-striped am-table-hover table-main am-text-nowrap">
                                <thead>
                                <tr>
                                    {{--<th>ID</th>--}}
                                    <th>菜单名</th>
                                    <th>路由</th>
                                    <th>URL参数</th>
                                    <th>状态</th>
                                    <th>创建时间</th>
                                    <th>修改时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($menu as $v)
                                    <tr>
                                        {{--<td>{{ $v->id }}</td>--}}
                                        <td>{{ $v->menu_name }}</td>
                                        <td>{{ $v->ac }}</td>
                                        <td>{{ $v->url_params }}</td>
                                        <td>{{ $v->dstatus }}</td>
                                        <td>{{ $v->created_at }}</td>
                                        <td>{{ $v->updated_at }}</td>
                                        <td style="display: flex;">
                                            <a href="{{ URL::to('admin/menu/'.$v->id.'/edit') }}" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>编辑</a>
                                            <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-danger del" data-id="{{$v->id}}"><span class="am-icon-pencil-square-o"></span>删除</a>
                                            {{--{!! Form::open(['method' => 'DELETE', 'route' => ['menu.destroy', $v->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                                            {!! Form::button('<span class="am-icon-pencil-square-o"></span>删除', array('type' => 'submit', 'class' => 'am-btn am-btn-default am-btn-xs am-text-danger')) !!}
                                            {!! Form::close() !!}--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tpl-alert"></div>
        </div>
    </div>
@stop
