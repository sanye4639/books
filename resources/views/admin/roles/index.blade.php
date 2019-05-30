
@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 角色列表
                </div>
            </div>
            <div class="tpl-block">
                <div class="am-g">
                    <div class="am-u-sm-12 am-u-md-6">
                        <div class="am-btn-toolbar">
                            <div class="am-btn-group am-btn-group-xs">
                                <button type="button" class="am-btn am-btn-default am-btn-success" onclick="window.location.href='{{ URL::to('admin/roles/create') }}'"><span class="am-icon-plus"></span> 新增</button>
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
                                    <th>角色</th>
                                    {{--<th>Permissions</th>--}}
                                    <th>组成员</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        {{--<td>{{ str_replace(array('[',']','"'),'', $role->permissions()->pluck('name')) }}</td>--}}
                                        <td>{{$role->role_ids}}</td>
                                        <td style="display: flex;">
                                            <a href="{{ URL::to('admin/roles/'.$role->id.'/edit') }}" class="am-btn am-btn-default am-btn-xs am-text-secondary"><span class="am-icon-pencil-square-o"></span>编辑</a>
                                            <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-danger del" data-id="{{$role->id}}"><span class="am-icon-pencil-square-o"></span>删除</a>

                                        {{--    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                                            {!! Form::button('<span class="am-icon-pencil-square-o"></span>删除', array('type' => 'submit', 'class' => 'am-btn am-btn-default am-btn-xs am-text-danger')) !!}
                                            {!! Form::close() !!}--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="am-u-lg-12">
                                <div class="am-cf">
                                    <div class="am-fr">
                                        <ul class="am-pagination tpl-pagination">
                                            {!! $roles->links() !!}
                                        </ul>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <hr>

                        </form>
                    </div>
                </div>
            </div>
            <div class="tpl-alert"></div>
        </div>
    </div>
@stop