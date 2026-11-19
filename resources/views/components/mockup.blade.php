@props(['art' => 'card', 'color' => '#6d28d9', 'title' => 'Patel Offset', 'image' => null])
@php
    $uid = 'm'.substr(md5($art.$color.$title.uniqid()), 0, 8);
    // Fit the title into $n characters, cutting on a word boundary.
    $fit = function (int $n) use ($title) {
        $out = '';
        foreach (preg_split('/\s+/', strtoupper(trim($title))) as $w) {
            if (strlen(trim($out.' '.$w)) > $n) {
                break;
            }
            $out = trim($out.' '.$w);
        }

        return $out ?: substr(strtoupper($title), 0, $n);
    };
    $t = $fit(18);
@endphp
@if($image)
    <img src="{{ asset('storage/'.$image) }}" alt="{{ $title }}" {{ $attributes->merge(['class' => 'mockup-img']) }} loading="lazy">
@else
<svg viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => 'mockup']) }} role="img" aria-label="{{ $title }}">
    <defs>
        <linearGradient id="{{ $uid }}bg" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="{{ $color }}" stop-opacity=".10"/>
            <stop offset="1" stop-color="{{ $color }}" stop-opacity=".28"/>
        </linearGradient>
        <linearGradient id="{{ $uid }}c" x1="0" y1="0" x2="1" y2="1">
            <stop offset="0" stop-color="{{ $color }}"/>
            <stop offset="1" stop-color="#0b1120"/>
        </linearGradient>
        <linearGradient id="{{ $uid }}g" x1="0" y1="0" x2="1" y2="0">
            <stop offset="0" stop-color="#f6d365"/><stop offset=".5" stop-color="#fff3c4"/><stop offset="1" stop-color="#d4a017"/>
        </linearGradient>
        <filter id="{{ $uid }}s" x="-20%" y="-20%" width="140%" height="150%">
            <feDropShadow dx="0" dy="10" stdDeviation="10" flood-color="#0b1120" flood-opacity=".28"/>
        </filter>
    </defs>
    <rect width="400" height="300" fill="url(#{{ $uid }}bg)"/>
    <circle cx="340" cy="40" r="70" fill="{{ $color }}" opacity=".10"/>
    <circle cx="40" cy="270" r="60" fill="{{ $color }}" opacity=".08"/>
    <g opacity=".5"><circle cx="30" cy="30" r="5" fill="#06b6d4"/><circle cx="46" cy="30" r="5" fill="#ec4899"/><circle cx="62" cy="30" r="5" fill="#facc15"/><circle cx="78" cy="30" r="5" fill="#0b1120"/></g>

    @switch($art)
        @case('card')
            <g filter="url(#{{ $uid }}s)" transform="rotate(-10 150 170)">
                <rect x="60" y="120" width="190" height="112" rx="8" fill="#fff"/>
                <rect x="60" y="120" width="12" height="112" rx="4" fill="{{ $color }}"/>
                <rect x="88" y="190" width="90" height="7" rx="3" fill="#cbd5e1"/><rect x="88" y="204" width="120" height="6" rx="3" fill="#e2e8f0"/><rect x="88" y="215" width="70" height="6" rx="3" fill="#e2e8f0"/>
            </g>
            <g filter="url(#{{ $uid }}s)" transform="rotate(8 250 130)">
                <rect x="150" y="70" width="200" height="118" rx="8" fill="url(#{{ $uid }}c)"/>
                <circle cx="250" cy="112" r="18" fill="none" stroke="url(#{{ $uid }}g)" stroke-width="3"/>
                <path d="M241 112 l7 7 l12 -14" fill="none" stroke="url(#{{ $uid }}g)" stroke-width="3"/>
                <text x="250" y="152" text-anchor="middle" font-family="Outfit,Arial" font-weight="700" font-size="14" fill="url(#{{ $uid }}g)" letter-spacing="2">{{ $fit(16) }}</text>
                <text x="250" y="170" text-anchor="middle" font-family="Arial" font-size="8" fill="#fff" opacity=".7" letter-spacing="3">PREMIUM PRINTING</text>
            </g>
            @break
        @case('flyer')
        @case('brochure')
            @if($art === 'brochure')
                <g filter="url(#{{ $uid }}s)">
                    <polygon points="80,70 160,60 160,250 80,240" fill="#fff"/>
                    <polygon points="160,60 240,70 240,240 160,250" fill="url(#{{ $uid }}c)"/>
                    <polygon points="240,70 320,60 320,250 240,240" fill="#fff"/>
                    <circle cx="200" cy="130" r="22" fill="#fff" opacity=".2"/>
                    <text x="200" y="185" text-anchor="middle" font-family="Outfit,Arial" font-weight="700" font-size="11" fill="#fff">{{ $fit(12) }}</text>
                    <rect x="92" y="90" width="56" height="40" rx="3" fill="{{ $color }}" opacity=".25"/><rect x="92" y="140" width="50" height="5" fill="#cbd5e1"/><rect x="92" y="152" width="40" height="5" fill="#e2e8f0"/>
                    <rect x="252" y="90" width="56" height="5" fill="#cbd5e1"/><rect x="252" y="102" width="46" height="5" fill="#e2e8f0"/><rect x="252" y="120" width="56" height="60" rx="3" fill="{{ $color }}" opacity=".25"/>
                </g>
            @else
                <g filter="url(#{{ $uid }}s)" transform="rotate(-6 140 160)"><rect x="70" y="60" width="130" height="185" rx="4" fill="#fff"/><rect x="80" y="70" width="110" height="80" rx="3" fill="{{ $color }}" opacity=".25"/><rect x="80" y="160" width="90" height="7" fill="#cbd5e1"/><rect x="80" y="174" width="105" height="5" fill="#e2e8f0"/><rect x="80" y="184" width="80" height="5" fill="#e2e8f0"/></g>
                <g filter="url(#{{ $uid }}s)" transform="rotate(5 260 150)">
                    <rect x="185" y="45" width="140" height="200" rx="4" fill="url(#{{ $uid }}c)"/>
                    <circle cx="255" cy="110" r="38" fill="#fff" opacity=".15"/><circle cx="255" cy="110" r="24" fill="#facc15" opacity=".9"/>
                    <text x="255" y="115" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="13" fill="#0b1120">50%</text>
                    <text x="255" y="178" text-anchor="middle" font-family="Outfit,Arial" font-weight="700" font-size="12" fill="#fff">{{ $fit(14) }}</text>
                    <rect x="215" y="192" width="80" height="16" rx="8" fill="#fff"/><text x="255" y="203" text-anchor="middle" font-family="Arial" font-size="7" font-weight="700" fill="{{ $color }}">ORDER NOW</text>
                </g>
            @endif
            @break
        @case('banner')
            <g filter="url(#{{ $uid }}s)">
                <rect x="40" y="80" width="320" height="130" rx="4" fill="url(#{{ $uid }}c)"/>
                <circle cx="52" cy="92" r="4" fill="#e2e8f0"/><circle cx="348" cy="92" r="4" fill="#e2e8f0"/><circle cx="52" cy="198" r="4" fill="#e2e8f0"/><circle cx="348" cy="198" r="4" fill="#e2e8f0"/>
                <text x="200" y="140" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="24" fill="#fff">{{ $fit(16) }}</text>
                <rect x="140" y="156" width="120" height="22" rx="11" fill="#facc15"/><text x="200" y="171" text-anchor="middle" font-family="Arial" font-weight="700" font-size="10" fill="#0b1120">GRAND OPENING</text>
            </g>
            <line x1="52" y1="80" x2="52" y2="40" stroke="#94a3b8" stroke-width="2"/><line x1="348" y1="80" x2="348" y2="40" stroke="#94a3b8" stroke-width="2"/>
            @break
        @case('standee')
            <g filter="url(#{{ $uid }}s)">
                <rect x="150" y="30" width="100" height="230" rx="3" fill="url(#{{ $uid }}c)"/>
                <circle cx="200" cy="90" r="28" fill="#fff" opacity=".18"/><circle cx="200" cy="90" r="16" fill="#facc15"/>
                <text x="200" y="150" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="11" fill="#fff">{{ $fit(11) }}</text>
                <rect x="165" y="165" width="70" height="5" fill="#fff" opacity=".6"/><rect x="172" y="176" width="56" height="5" fill="#fff" opacity=".4"/>
                <rect x="135" y="258" width="130" height="14" rx="4" fill="#94a3b8"/>
            </g>
            @break
        @case('letterhead')
        @case('billbook')
            <g filter="url(#{{ $uid }}s)" transform="rotate(-5 160 160)"><rect x="90" y="45" width="150" height="210" rx="3" fill="#f8fafc"/></g>
            <g filter="url(#{{ $uid }}s)" transform="rotate(4 230 150)">
                <rect x="160" y="40" width="160" height="220" rx="3" fill="#fff"/>
                <rect x="160" y="40" width="160" height="34" fill="url(#{{ $uid }}c)"/>
                <text x="175" y="62" font-family="Outfit,Arial" font-weight="700" font-size="11" fill="#fff">{{ $fit(18) }}</text>
                @if($art === 'billbook')
                    <text x="175" y="92" font-family="Arial" font-size="8" font-weight="700" fill="{{ $color }}">TAX INVOICE  No. 0001</text>
                    @for($i=0;$i<6;$i++)<rect x="175" y="{{ 104 + $i*18 }}" width="130" height="1" fill="#cbd5e1"/><rect x="175" y="{{ 98 + $i*18 }}" width="{{ 40 + ($i*13)%50 }}" height="4" fill="#e2e8f0"/>@endfor
                @else
                    @for($i=0;$i<8;$i++)<rect x="175" y="{{ 92 + $i*14 }}" width="{{ 130 - ($i*17)%45 }}" height="5" rx="2" fill="#e2e8f0"/>@endfor
                @endif
                <rect x="160" y="250" width="160" height="10" fill="{{ $color }}"/>
            </g>
            @break
        @case('envelope')
            <g filter="url(#{{ $uid }}s)">
                <rect x="70" y="90" width="260" height="130" rx="4" fill="#fff"/>
                <polygon points="70,90 200,165 330,90" fill="#f1f5f9" stroke="#e2e8f0"/>
                <rect x="70" y="90" width="70" height="10" fill="{{ $color }}"/>
                <text x="90" y="205" font-family="Outfit,Arial" font-weight="700" font-size="11" fill="{{ $color }}">{{ $fit(20) }}</text>
                <rect x="250" y="180" width="60" height="5" fill="#e2e8f0"/><rect x="250" y="190" width="50" height="5" fill="#e2e8f0"/>
            </g>
            @break
        @case('idcard')
            <path d="M200 20 L170 110 M200 20 L230 110" stroke="{{ $color }}" stroke-width="10" fill="none" stroke-linecap="round"/>
            <g filter="url(#{{ $uid }}s)">
                <rect x="140" y="105" width="120" height="170" rx="10" fill="#fff"/>
                <rect x="140" y="105" width="120" height="50" rx="10" fill="url(#{{ $uid }}c)"/>
                <circle cx="200" cy="160" r="26" fill="#e2e8f0" stroke="#fff" stroke-width="4"/>
                <circle cx="200" cy="154" r="9" fill="#94a3b8"/><path d="M184 176 q16 -16 32 0" fill="#94a3b8"/>
                <rect x="165" y="200" width="70" height="7" rx="3" fill="#334155"/><rect x="175" y="214" width="50" height="5" rx="2" fill="#cbd5e1"/>
                <rect x="160" y="236" width="80" height="22" fill="{{ $color }}" opacity=".15"/>
            </g>
            @break
        @case('sticker')
            <g filter="url(#{{ $uid }}s)">
                <circle cx="150" cy="150" r="72" fill="#fff"/><circle cx="150" cy="150" r="62" fill="url(#{{ $uid }}c)"/>
                <text x="150" y="146" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="13" fill="#fff">{{ $fit(10) }}</text>
                <text x="150" y="164" text-anchor="middle" font-family="Arial" font-size="8" fill="#facc15" letter-spacing="2">★ ★ ★</text>
                <rect x="235" y="85" width="110" height="70" rx="35" fill="#fff"/><rect x="242" y="92" width="96" height="56" rx="28" fill="{{ $color }}" opacity=".85"/>
                <text x="290" y="125" text-anchor="middle" font-family="Outfit,Arial" font-weight="700" font-size="12" fill="#fff">100% FRESH</text>
                <polygon points="290,170 304,200 336,204 312,226 318,258 290,242 262,258 268,226 244,204 276,200" fill="#facc15" stroke="#fff" stroke-width="4"/>
            </g>
            @break
        @case('frame')
            <g filter="url(#{{ $uid }}s)">
                <polygon points="120,250 280,250 300,268 100,268" fill="#cbd5e1" opacity=".9"/>
                <rect x="125" y="40" width="150" height="212" rx="4" fill="#ffffff" fill-opacity=".5" stroke="#fff" stroke-width="3"/>
                <rect x="135" y="50" width="130" height="192" fill="url(#{{ $uid }}c)"/>
                <text x="200" y="90" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="13" fill="#facc15">MENU</text>
                @for($i=0;$i<6;$i++)<rect x="150" y="{{ 108 + $i*20 }}" width="70" height="5" fill="#fff" opacity=".7"/><rect x="232" y="{{ 108 + $i*20 }}" width="20" height="5" fill="#facc15"/>@endfor
                <polygon points="125,40 170,40 125,120" fill="#fff" opacity=".25"/>
            </g>
            @break
        @case('invite')
            <g filter="url(#{{ $uid }}s)" transform="rotate(-8 150 160)"><rect x="80" y="70" width="140" height="180" rx="4" fill="url(#{{ $uid }}c)"/><path d="M80 70 L150 130 L220 70" fill="none" stroke="url(#{{ $uid }}g)" stroke-width="2"/></g>
            <g filter="url(#{{ $uid }}s)" transform="rotate(6 250 150)">
                <rect x="180" y="45" width="150" height="205" rx="4" fill="#fffbeb"/>
                <rect x="190" y="55" width="130" height="185" rx="3" fill="none" stroke="url(#{{ $uid }}g)" stroke-width="2"/>
                <path d="M255 80 c-10 -14 -30 -4 -20 12 l20 18 l20 -18 c10 -16 -10 -26 -20 -12z" fill="{{ $color }}"/>
                <text x="255" y="140" text-anchor="middle" font-family="Georgia,serif" font-style="italic" font-size="16" fill="{{ $color }}">Save the Date</text>
                <rect x="215" y="155" width="80" height="2" fill="url(#{{ $uid }}g)"/>
                <text x="255" y="178" text-anchor="middle" font-family="Georgia,serif" font-size="9" fill="#78716c">Rahul &amp; Priya</text>
                <text x="255" y="196" text-anchor="middle" font-family="Arial" font-size="7" fill="#a8a29e" letter-spacing="2">12 . 12 . 2026</text>
            </g>
            @break
        @case('tag')
            <g filter="url(#{{ $uid }}s)" transform="rotate(-12 170 160)">
                <path d="M120 60 h80 l20 25 v165 h-120 v-165 z" fill="url(#{{ $uid }}c)"/><circle cx="160" cy="85" r="7" fill="#f1f5f9"/>
                <text x="160" y="150" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="13" fill="#fff">{{ $fit(9) }}</text>
                <rect x="125" y="170" width="70" height="4" fill="#fff" opacity=".5"/>
            </g>
            <path d="M150 70 C 120 20, 260 20, 250 80" stroke="#94a3b8" stroke-width="2" fill="none"/>
            <g filter="url(#{{ $uid }}s)" transform="rotate(10 260 170)">
                <path d="M220 80 h70 l18 22 v150 h-106 v-150 z" fill="#fff"/><circle cx="255" cy="102" r="6" fill="#e2e8f0"/>
                <text x="255" y="150" text-anchor="middle" font-family="Arial" font-weight="700" font-size="10" fill="{{ $color }}">SIZE  M</text>
                <rect x="220" y="170" width="70" height="20" fill="{{ $color }}" opacity=".15"/>
                @for($i=0;$i<12;$i++)<rect x="{{ 222 + $i*6 }}" y="205" width="{{ $i%3 ? 2 : 4 }}" height="26" fill="#0b1120"/>@endfor
            </g>
            @break
        @case('box')
            <g filter="url(#{{ $uid }}s)">
                <polygon points="200,60 310,100 200,140 90,100" fill="{{ $color }}" opacity=".7"/>
                <polygon points="90,100 200,140 200,260 90,220" fill="url(#{{ $uid }}c)"/>
                <polygon points="200,140 310,100 310,220 200,260" fill="{{ $color }}"/>
                <g transform="matrix(1 0.36 0 1 0 0)"><text x="145" y="128" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="12" fill="#fff">{{ $fit(12) }}</text></g>
                <circle cx="255" cy="175" r="22" fill="#fff" opacity=".25"/>
            </g>
            @break
        @case('bag')
            <g filter="url(#{{ $uid }}s)">
                <path d="M165 90 q35 -60 70 0" stroke="#0b1120" stroke-width="5" fill="none"/>
                <rect x="120" y="90" width="160" height="180" rx="4" fill="url(#{{ $uid }}c)"/>
                <polygon points="280,90 310,105 310,262 280,270" fill="{{ $color }}" opacity=".6"/>
                <circle cx="200" cy="160" r="30" fill="#fff" opacity=".2"/>
                <text x="200" y="166" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="13" fill="#fff">{{ $fit(12) }}</text>
                <text x="200" y="225" text-anchor="middle" font-family="Arial" font-size="8" fill="#facc15" letter-spacing="3">THANK YOU</text>
            </g>
            @break
        @default
            <g filter="url(#{{ $uid }}s)"><rect x="100" y="70" width="200" height="160" rx="10" fill="url(#{{ $uid }}c)"/><text x="200" y="155" text-anchor="middle" font-family="Outfit,Arial" font-weight="800" font-size="16" fill="#fff">{{ $t }}</text></g>
    @endswitch
</svg>
@endif
