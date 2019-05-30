
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
                        <form class="am-form tpl-form-line-form" id="form" method="post" action="">
                            <input type="hidden" name="id" value="{{$data['id']}}">
                            {{ csrf_field() }}
                            <div class="am-form-group">
                                <label for="user-weibo" class="am-u-sm-3 am-form-label">封面图 <span class="tpl-form-line-small-title">Images</span></label>
                                <div class="am-u-sm-9">
                                    <div class="am-form-group am-form-file">
                                        <input type="hidden" name="pic" id="fileBase64" value="{{old('pic',$data['pic'])}}">
                                        <div class="tpl-form-file-img"  id="imgView">
                                            <img src="{{old('pic',$data['pic'])}}" alt="">
                                        </div>
                                        <button type="button" class="am-btn am-btn-danger am-btn-sm">
                                            <i class="am-icon-cloud-upload"></i> 修改封面图片</button>
                                        <input id="doc-form-file upfile" type="file" name="upfile" capture="camera" accept="image/*">
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-intro" class="am-u-sm-3 am-form-label">隐藏文章</label>
                                <div class="am-u-sm-9">
                                    <div class="tpl-switch">
                                        <input type="checkbox" name="dstatus" class="ios-switch bigswitch tpl-switch-btn" @if(old('dstatus',$data['dstatus']) == 1 or old('dstatus',$data['dstatus']) == 'on') checked @endif />
                                        <div class="tpl-switch-btn-view">
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label for="user-phone" class="am-u-sm-3 am-form-label">推荐栏目</label>
                                <div class="am-u-sm-9">
                                    <select data-am-selected="{btnWidth: '40%', btnSize: 'sm', btnStyle: 'secondary'}" name="tj">
                                        @foreach($tjArr as $k=>$v)
                                            <option value="{{$k}}" @if(old('tj',$data['tj']) == $k) selected @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label for="user-intro" class="am-u-sm-3 am-form-label">小说简介</label>
                                <div class="am-u-sm-9">
                                    <textarea class="" rows="10" id="user-intro" name="intro" placeholder="请输入简介内容">{{old('intro',$data['intro'])}}</textarea>
                                </div>
                            </div>

                            <div class="am-form-group">

                                <div class="am-u-sm-9 am-u-sm-push-3">
                                    <button type="button" class="am-btn am-btn-default tpl-btn-bg-color-default" onclick="history.go(-1)"><</button>
                                    <button type="button" class="am-btn am-btn-primary tpl-btn-bg-color-success" id="btn">提交</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(function () {
            $('#btn').click(function () {
                // $('#form').serialize();
                $('#form').submit();
            })

        })
        var progress = $.AMUI.progress;
        document.querySelector('input[type=file]').addEventListener('change', function () {
            $.AMUI.progress.inc(0.4);
            var that = this;
            if(that.files[0]) {
                lrz(that.files[0], {
                    width: 800
                })
                    .then(function (rst) {
                        console.log(that.files);
                        var data = new FormData();
                        $.each(that.files, function (i, file) {
                            data.append('upfile', file);//文件name域
                        });
                        $.ajax({
                            url: '{{url('uploadImg')}}',
                            data: data,
                            type: 'post',
                            cache: false,
                            processData: false,
                            contentType: false,
                            success: function (res) {
                                if (res.status == 1) {
                                    var img_url = res.data;
                                    $('[name=pic]').val(img_url);
                                } else {
                                    alert(res.msg);
                                    return;
                                }
                            }
                        });
                        //如果是ajax请求到后台的话，代码也在这里写，具体写法请参考自带的例子，
                        //这里是通过submit将数据统一提交，所以只保存到隐藏域中即可
                        var imgView = document.getElementById("imgView");
                        img = new Image(),
                            div = document.createElement('div'),
                            p = document.createElement('p'),
                            sourceSize = toFixed2(that.files[0].size / 1024),
                            resultSize = toFixed2(rst.fileLen / 1024),
                            scale = parseInt(100 - (resultSize / sourceSize * 100));
                        img.width = 500;
                        img.height = 500;
                        img.className = 'image';
                        imgView.innerHTML = "";//先清空原先数值
                        p.style.fontSize = 13 + 'px';
                        p.innerHTML = '源文件大小：<span>' +
                            sourceSize + 'KB' +
                            '</span> <br />' +
                            '上传后大小：<span>' +
                            resultSize + 'KB (省' + scale + '%)' +
                            '</span> ';
                        div.className = '';
                        div.appendChild(img);
                        div.appendChild(p);
                        img.onload = function () {

                            document.querySelector('#imgView').appendChild(div);
                        };
                        // console.log(img.src);
                        img.src = rst.base64;
                        progress.done();
                        //保存到隐藏域中。
                        // document.getElementById("fileBase64").value = rst.base64;
                        return rst;
                    });
            }
        });

        function toFixed2 (num) {
            return parseFloat(+num.toFixed(2));
        }

    </script>
@stop
