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
                            {{ Form::open(array('url' => 'admin/permissions')) }}
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">权限 <span class="tpl-form-line-small-title">Permissions</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('name', '', array('class' => 'tpl-form-input')) }}
                                    <small>请填写权限名。</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">请选择角色 <span class="tpl-form-line-small-title">Role</span></label>
                                <div class="am-u-sm-9">
                                    <div class='am-u-sm-9'>
                                        @if(!$roles->isEmpty())
                                            @foreach ($roles as $role)
                                                {{ Form::checkbox('roles[]',  $role->id ) }}
                                                {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    {{ Form::button('《', array('class' => 'am-btn am-btn-primary tpl-btn-bg-color-success','onclick'=>'history.go(-1)')) }}
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

