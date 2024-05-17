@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- 上一页链接 --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link"><i class="mdi mdi-chevron-left"></i></span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i class="mdi mdi-chevron-left"></i></a></li>
        @endif

        {{-- 分页元素 --}}
        @foreach ($elements as $element)
            {{-- 数组的 "窗口" --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 下一页链接 --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i class="mdi mdi-chevron-right"></i></a></li>
        @else
            <li class="page-item disabled"><span class="page-link"><i class="mdi mdi-chevron-right"></i></span></li>
        @endif
    </ul>
@endif
