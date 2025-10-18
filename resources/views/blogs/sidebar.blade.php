<div class="sidebar">

    <div class="widget">
        <h4>{{ __('messages.text_archives') }}</h4>
        <ul class="list-unstyled">
            @foreach($archives as $yearMonth => $count)
            <li class="py-1">
                <a href="{{ route('blog.index') }}?archive={{ $yearMonth }}">
                    {{ \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F Y') }}
                    ({{ $count }})
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="widget">
        <h4>{{ __('messages.text_categories') }}</h4>
        <ul class="list-unstyled">
            @foreach($allCategories as $cat)
            <li class="py-1">
                <a href="{{ route('blog.category', $cat->slug) }}">
                    {{ $cat->translate()->name }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
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