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
                            {{ Form::open(array('url' => 'admin/roles')) }}
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">角色名 <span class="tpl-form-line-small-title">Name</span></label>
                                <div class="am-u-sm-9">
                                    {{ Form::text('name', null, array('class' => 'tpl-form-input')) }}
                                    <small>请填写角色名。</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-name" class="am-u-sm-3 am-form-label">请选择权限 <span class="tpl-form-line-small-title">Permissions</span></label>
                                <div class='am-u-sm-9' id="table">
                                    <label class="am-checkbox-inline">
                                        {{Form::checkbox('permissions[]',  1, null,array('data-am-ucheck','class'=>'allChoose') ) }}
                                        <b>超级权限</b>
                                    </label>
                                    @foreach ($menu_data as $val)
                                        <div class="table">
                                            <label class="am-checkbox-inline">
                                                {{Form::checkbox('permissions[]',  $val->permission_id,null,array('data-am-ucheck','class'=>'allChoose') ) }}
                                                <b>{{$val->menu_name}}</b>
                                            </label>
                                            <br>
                                            @if(isset($val->children))
                                                <div style="margin-left: 20px" class="children_check">
                                                    @foreach($val->children as $v)
                                                        <label class="am-checkbox-inline am-success">
                                                            {{Form::checkbox('permissions[]',  $v->permission_id,null,array('data-am-ucheck') ) }}
                                                            {{$v->menu_name}}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
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
    <script>
        $(function () {
            //全选或全不选
            $(".allChoose").click(function(){
                if(this.checked){
                    $(this).parents('.table').find('.children_check').find('input[type="checkbox"]').prop("checked", true);
                }else{
                    $(this).parents('.table').find('.children_check').find('input[type="checkbox"]').prop("checked", false);
                }
            });
            $("#table .table .children_check input:checkbox").click(function () {
                allChooseChk($(this));
            });
        })
        function allChooseChk(obj) {
            var chknum = obj.parents('.children_check').find('input:checkbox').size();//选项总个数
            var chk = 0;
            obj.parents('.children_check').find('input:checkbox').each(function () {
                if($(this).prop("checked")==true){
                    chk++;
                }
            })
            if(chknum==chk){
                obj.parents('.table').find(".allChoose").prop("checked",true);
            }else{
                obj.parents('.table').find(".allChoose").prop("checked",false);
            }
        }
    </script>
@stop