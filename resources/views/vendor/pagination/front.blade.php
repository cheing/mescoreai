@if ($paginator->hasPages())
<div class="gt-pagination mt-5">
    <nav>
        <ul class="pagination justify-content-center">
            {{-- 上一页链接 --}}
            @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link"><i class="fas fa-angle-left"></i></span></li>
            @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"><i
                        class="fas fa-angle-left"></i></a></li>
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
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"><i
                        class="fas fa-angle-right"></i></a></li>
            @else
            <li class="page-item disabled"><span class="page-link"><i class="fas fa-angle-right"></i></span></li>
            @endif
        </ul>

    </nav>
</div>
@endif

<style>
    .sidebar {
        background: #111;
    }

    .widget h4 {
        color: #fff;
    }

    .widget ul li a {
        color: #ff4e00;
    }
</style>