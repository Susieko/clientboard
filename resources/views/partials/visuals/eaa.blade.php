<svg
    class="client-visual-svg eaa-visual"
    viewBox="0 0 700 300"
    role="img"
    aria-label="EAA visual"
>
    <defs>
        <linearGradient id="eaaBg" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#262244" />
            <stop offset="100%" stop-color="#1b1835" />
        </linearGradient>

        <radialGradient id="eaaGlow" cx="70%" cy="30%" r="60%">
            <stop offset="0%" stop-color="#88d07d" stop-opacity="0.2" />
            <stop offset="100%" stop-color="#88d07d" stop-opacity="0" />
        </radialGradient>

        <linearGradient id="batteryFill" x1="0%" y1="0%" x2="100%" y2="0%">
            <stop offset="0%" stop-color="#e6d35c" />
            <stop offset="100%" stop-color="#7bcf6d" />
        </linearGradient>
    </defs>

    {{-- background --}}
    <rect width="700" height="300" fill="url(#eaaBg)" />
    <rect width="700" height="300" fill="url(#eaaGlow)" />

    {{-- sun --}}
    <g class="eaa-sun">
        <circle cx="590" cy="72" r="32" fill="#e2b93f" />
        <g stroke="#e2b93f" stroke-width="6" stroke-linecap="round">
            <line x1="590" y1="23" x2="590" y2="8" />
            <line x1="590" y1="121" x2="590" y2="136" />
            <line x1="541" y1="72" x2="526" y2="72" />
            <line x1="639" y1="72" x2="654" y2="72" />
            <line x1="556" y1="38" x2="545" y2="27" />
            <line x1="624" y1="38" x2="635" y2="27" />
            <line x1="556" y1="106" x2="545" y2="117" />
            <line x1="624" y1="106" x2="635" y2="117" />
        </g>
    </g>

    {{-- hills --}}
    <path
        d="M0 210
           C115 170, 215 174, 334 194
           C447 212, 560 202, 700 170
           L700 300
           L0 300 Z"
        fill="#274d49"
    />

    <path
        d="M0 244
           C140 216, 262 224, 375 242
           C492 260, 590 252, 700 228
           L700 300
           L0 300 Z"
        fill="#17634f"
    />

    {{-- houses --}}
    <g class="eaa-house eaa-house--one">
        <rect x="110" y="166" width="44" height="34" rx="4" fill="#f1eef8" />
        <path d="M104 168 L132 146 L160 168 Z" fill="#d9a347" />
        <rect x="126" y="182" width="10" height="18" rx="2" fill="#a7a2bf" />
    </g>

    <g class="eaa-house eaa-house--two">
        <rect x="170" y="174" width="38" height="28" rx="4" fill="#f1eef8" />
        <path d="M165 176 L189 156 L213 176 Z" fill="#d96a6a" />
        <rect x="184" y="187" width="8" height="15" rx="2" fill="#a7a2bf" />
    </g>

    {{-- battery --}}
    <g class="eaa-battery">
        <rect
            x="292"
            y="98"
            width="110"
            height="124"
            rx="22"
            fill="#f3eefb"
        />

        <rect
            x="330"
            y="82"
            width="34"
            height="18"
            rx="8"
            fill="#d5cde8"
        />

        <rect
            x="312"
            y="120"
            width="70"
            height="78"
            rx="14"
            fill="#2b254f"
        />

        <rect
            class="eaa-battery-fill"
            x="320"
            y="128"
            width="54"
            height="62"
            rx="10"
            fill="url(#batteryFill)"
        />

        <path
            d="M350 138
               L336 164
               H349
               L342 186
               L366 156
               H353
               L360 138 Z"
            fill="#ffffff"
        />
    </g>

    {{-- solar panel --}}
    <g class="eaa-panel">
        <path
            d="M464 196
               L546 176
               L562 214
               L480 234 Z"
            fill="#4d7fd9"
        />

        <g stroke="#9fc2ff" stroke-width="2" opacity="0.75">
            <line x1="481" y1="188" x2="498" y2="227" />
            <line x1="504" y1="182" x2="521" y2="221" />
            <line x1="527" y1="177" x2="544" y2="216" />
            <line x1="475" y1="204" x2="558" y2="184" />
            <line x1="481" y1="218" x2="563" y2="198" />
        </g>

        <line x1="513" y1="234" x2="503" y2="254" stroke="#8f89a3" stroke-width="6" stroke-linecap="round" />
        <line x1="529" y1="230" x2="539" y2="250" stroke="#8f89a3" stroke-width="6" stroke-linecap="round" />
    </g>

    {{-- energy dots --}}
    <g class="eaa-energy eaa-energy--one">
        <circle cx="246" cy="117" r="7" fill="#8fe27a" />
    </g>

    <g class="eaa-energy eaa-energy--two">
        <circle cx="434" cy="126" r="7" fill="#8fe27a" />
    </g>

    <g class="eaa-energy eaa-energy--three">
        <circle cx="574" cy="156" r="7" fill="#8fe27a" />
    </g>

    <text
        x="350"
        y="275"
        text-anchor="middle"
        fill="#f4edf9"
        font-size="16"
        font-weight="800"
        letter-spacing="0.14em"
        font-family="Arial, Helvetica, sans-serif"
    >
        EAA
    </text>
</svg>