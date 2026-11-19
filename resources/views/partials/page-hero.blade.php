<section class="page-hero">
    <div class="hero-bg"><div class="grid"></div><div class="blob b1" style="width:380px;height:380px"></div><div class="blob b2" style="width:300px;height:300px"></div></div>
    <div class="container">
        <div class="crumbs" data-reveal="up">
            <a href="{{ route('home') }}"><i class="fa-solid fa-house" style="font-size:12px"></i> Home</a>
            @foreach($crumbs ?? [] as $label => $url)
                <i class="fa-solid fa-chevron-right"></i>
                @if($url)<a href="{{ $url }}">{{ $label }}</a>@else<span>{{ $label }}</span>@endif
            @endforeach
        </div>
        <h1 data-reveal="up" style="--d:.1s">{!! $title !!}</h1>
        @isset($sub)<p data-reveal="up" style="--d:.2s">{{ $sub }}</p>@endisset
    </div>
</section>
