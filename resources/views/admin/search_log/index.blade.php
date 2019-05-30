@extends('admin.common')
@section('content')
    <div class="tpl-content-wrapper">
        <div class="tpl-portlet-components">
            <div class="portlet-title">
                <div class="caption font-green bold">
                    <span class="am-icon-code"></span> 搜索记录列表
                </div>
            </div>
            <div class="tpl-block">
                <form action="" method="get" id="searchList">
                    <div class="am-g">
                        <div class="am-btn-group">
                            <input type="text" class="am-form-field am-radius" name="keywords" value="{{$searchArr['keywords'] or ''}}" placeholder="  请输入搜索关键字"/>
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
                                    <th>搜索关键字</th>
                                    <th>搜索次数</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($data)>0)
                                    @foreach ($data as $v)
                                        <tr>
                                            <td>{{ $v->keywords }}</td>
                                            <td>{{ $v->search_num }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2"><div style="text-align: center">暂无更多记录</div></td>
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

