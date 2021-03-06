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
                            {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}

                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">用户名 <span class="tpl-form-line-small-title">Name</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('name', null, array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">手机号 <span class="tpl-form-line-small-title">Phone</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('phone', null, array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">请选择角色 <span class="tpl-form-line-small-title">Roles</span></label>
                                <div class="am-u-sm-9">
                                    <div class='am-u-sm-9'>
                                        <select multiple data-am-selected name="roles[]">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}" @if(in_array($role->name,$user_roles))selected @endif> {{ Form::label($role->name, ucfirst($role->name)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">密码 <span class="tpl-form-line-small-title">Password</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::password('password', array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">重复密码 <span class="tpl-form-line-small-title">Reset_Password</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::password('password_confirmation', array('class' => 'tpl-form-input')) }}
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    {{ Form::button('<', array('class' => 'am-btn am-btn-default tpl-btn-bg-color-default','onclick'=>'history.go(-1)')) }}
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
