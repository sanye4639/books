@if ($paginator->hasPages())
    <ul class="am-pagination tpl-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="am-disabled"><a href="#">«</a></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
        @endif
        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif
            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="am-active"><a href="#">{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
        @else
            <li class="am-disabled"><span>&raquo;</span></li>
        @endif
        <li><input type="text" class="am-form-field am-radius" style='width: 50px;'/></li>
        <li><button type="button" class="am-btn am-btn-primary am-round" onclick="goPages(this,'{{$page}}');" style='margin-bottom: 10px'>GO</button></li>
    </ul>
    <script>
        function goPages(obj,totalPage)
        {
            var p=$(obj).parents().prev().children().val();
            if(p>0 && Number(p)<=Number(totalPage)){
                var urlArr = UrlSearch();
                urlArr['page'] = p;
                var urlStr = '?';
                for(var tmp in urlArr){
                    urlStr += tmp+'='+urlArr[tmp]+'&';
                }
                urlStr = urlStr.substr(0, urlStr.length - 1);
                window.location.href = window.location.pathname + urlStr;
            }else{
                layer.msg('请输入正确页码', {icon:0})
            }
        }
    </script>
@endif
