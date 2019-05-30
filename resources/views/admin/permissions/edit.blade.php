@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 编辑
                </div>
            </div>
            <div class="tpl-block">
                <div class="am-g">
                    <div class="tpl-form-body tpl-form-line">
                        <div class="am-form tpl-form-line-form">
                            {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">权限 <span class="tpl-form-line-small-title">Permissions</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('name', null, array('class' => 'tpl-form-input')) }}
                                    <small>请填写权限名。</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    {{ Form::button('《', array('class' => 'am-btn am-btn-primary tpl-btn-bg-color-success','onclick'=>'history.go(-1)')) }}
                                    {{ Form::submit('修改', array('class' => 'am-btn am-btn-primary tpl-btn-bg-color-success')) }}
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

