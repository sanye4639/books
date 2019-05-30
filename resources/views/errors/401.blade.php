@extends('admin.common')
@section('content')
    <style>
        .container {
            padding-top: 10%;
        }
    </style>
    <div class="container">
        <div>
            <p style="text-align: center;"><span
                        style="font-family:arial,helvetica,sans-serif;"><span
                            style="color: rgb(0, 136, 194);"><span
                                style="font-size: 64px;">401</span></span></span>
            </p>
            <p style="text-align: center;"><span
                        style="font-size:28px;"><span
                            style="color: rgb(51, 51, 51);">对不起，您没有权限访问!</span></span>
            </p>
            <p style="text-align: center;"><span
                        style="font-size:18px;color: #ccc;"><a href="javascript:void(0)" onclick="javascript :history.back(-1);" style="text-decoration:none;">返回上一页</a></span>
            </p>
        </div>
    </div>
@stop


