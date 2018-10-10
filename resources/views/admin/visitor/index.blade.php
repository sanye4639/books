@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 访问记录列表
                </div>
            </div>
            <div class="tpl-block">
                <form action="" method="get" id="searchList">
                    <div class="am-g">
                        <div class="am-btn-group">
                            <input type="text" class="am-form-field am-radius" name="visitor_ip" value="{{$searchArr['visitor_ip'] or ''}}" placeholder="  请输入访问者IP"/>
                        </div>
                        <div class="am-btn-group">
                            <input type="text" class="am-form-field am-radius" name="book_id" value="{{$searchArr['book_id'] or ''}}" placeholder="  请输入小说ID"/>
                        </div>
                        <div class="am-btn-group">
                            <input class="am-form-field" name="startDate" value="{{$searchArr['startDate'] or ''}}" placeholder="最新访问开始时间" id="startTime" style="width:100px;" autocomplete="off"/>
                        </div> ~
                        <div class="am-btn-group">
                            <input class="am-form-field" name="endDate" value="{{$searchArr['endDate'] or ''}}" placeholder="最新访问结束时间" id="endTime" style="width:100px;" autocomplete="off"/>
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
                                    <th>小说ID</th>
                                    <th>访问IP</th>
                                    <th>小说名称</th>
                                    <th>访问次数</th>
                                    <th>初次访问时间</th>
                                    <th>最新访问时间</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data)>0)
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>{{ $v->id }}</td>
                                            <td>{{ $v->book_id }}</td>
                                            <td>{{ $v->visitor_ip}}</td>
                                            <td><a href="{{url('admin/book/detail')}}/{{$v->book->id}}">{{$v->book->name}}</a></td>
                                            <td>{{ $v->visitor_num }}</td>
                                            <td>{{ $v->created_at }}</td>
                                            <td>{{ $v->updated_at }}</td>
                                            <td style="display: flex;">
                                                <a href="javascript:void(0)" class="am-btn am-btn-default am-btn-xs am-text-danger del" data-id="{{$v->id}}"><span class="am-icon-pencil-square-o"></span>删除</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8"><div style="text-align: center">暂无更多记录</div></td>
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
