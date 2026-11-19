@if ($paginator->hasPages())
    <nav class="pager" style="display:flex;gap:8px;justify-content:center;margin-top:40px;flex-wrap:wrap">
        @php $btn = 'display:grid;place-items:center;min-width:44px;height:44px;padding:0 12px;border-radius:12px;border:1.5px solid var(--line);background:#fff;font-weight:700;'; @endphp
        @if ($paginator->onFirstPage())
            <span style="{{ $btn }}opacity:.4"><i class="fa-solid fa-chevron-left"></i></span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="{{ $btn }}"><i class="fa-solid fa-chevron-left"></i></a>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))<span style="{{ $btn }}">…</span>@endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="{{ $btn }}background:var(--ink);color:#fff;border-color:var(--ink)">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="{{ $btn }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="{{ $btn }}"><i class="fa-solid fa-chevron-right"></i></a>
        @else
            <span style="{{ $btn }}opacity:.4"><i class="fa-solid fa-chevron-right"></i></span>
        @endif
    </nav>
@endif
