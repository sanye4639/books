@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 新增
                </div>
            </div>
            <div class="tpl-block">
                <div class="am-g">
                    <div class="tpl-form-body tpl-form-line">
                        <div class="am-form tpl-form-line-form">
                            {{ Form::open(array('url' => 'admin/menu')) }}
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">分类 <span class="tpl-form-line-small-title">Pid</span></label>
                                <div class="am-u-sm-9">
                                    <select name="pid" data-am-selected="{maxHeight: 300}">
                                        <option value="0">顶级</option>
                                        @foreach($menu_list as $v)
                                             <option value="{{$v['id']}}">{{$v['menu_name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">菜单名称 <span class="tpl-form-line-small-title">Menu_Name</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('menu_name', '', array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">路由 <span class="tpl-form-line-small-title">Ac</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('ac', '', array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">图标 <span class="tpl-form-line-small-title">Icon</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('icon_class', '', array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">路由参数 <span class="tpl-form-line-small-title">Params</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('url_params', '', array('class' => 'tpl-form-input','placeholder'=>'例如:?type=1多个参数&链接')) }}
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">是否显示 <span class="tpl-form-line-small-title">Status</span></label>
                                <div class="am-u-sm-9">
                                    <div class="tpl-switch">
                                        <input type="checkbox" name="dstatus" class="ios-switch bigswitch tpl-switch-btn" checked />
                                        <div class="tpl-switch-btn-view">
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    {{ Form::button('<', array('class' => 'am-btn am-btn-default tpl-btn-bg-color-default','onclick'=>'history.go(-1)')) }}
                                    {{ Form::submit('提交', array('class' => 'am-btn am-btn-primary tpl-btn-bg-color-success')) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop