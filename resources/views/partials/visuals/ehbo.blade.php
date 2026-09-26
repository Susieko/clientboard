<svg
    class="client-visual-svg ehbo-visual"
    viewBox="0 0 700 300"
    role="img"
    aria-label="EHBO visual"
>
    <defs>
        <linearGradient id="ehboBg" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#27234a" />
            <stop offset="100%" stop-color="#1a1735" />
        </linearGradient>

        <radialGradient id="ehboGlow" cx="50%" cy="40%" r="60%">
            <stop offset="0%" stop-color="#5b4aa0" stop-opacity="0.28" />
            <stop offset="100%" stop-color="#5b4aa0" stop-opacity="0" />
        </radialGradient>
    </defs>

    {{-- background --}}
    <rect width="700" height="300" fill="url(#ehboBg)" />
    <rect width="700" height="300" fill="url(#ehboGlow)" />

    {{-- soft circles --}}
    <circle cx="585" cy="70" r="52" fill="#f0d36c" opacity="0.08" />
    <circle cx="122" cy="228" r="38" fill="#78a9ff" opacity="0.08" />

    {{-- floating pluses --}}
    <g class="ehbo-plus ehbo-plus--one">
        <rect x="106" y="76" width="14" height="42" rx="7" fill="#f2c94c" />
        <rect x="92" y="90" width="42" height="14" rx="7" fill="#f2c94c" />
    </g>

    <g class="ehbo-plus ehbo-plus--two">
        <rect x="560" y="174" width="10" height="30" rx="5" fill="#75c2ff" />
        <rect x="550" y="184" width="30" height="10" rx="5" fill="#75c2ff" />
    </g>

    {{-- medical card --}}
    <g class="ehbo-card">
        <rect
            x="198"
            y="54"
            width="304"
            height="192"
            rx="28"
            fill="#f3eefb"
        />

        <rect
            x="220"
            y="78"
            width="78"
            height="78"
            rx="20"
            fill="#d95366"
        />

        <rect
            x="250"
            y="92"
            width="18"
            height="50"
            rx="9"
            fill="#ffffff"
        />

        <rect
            x="234"
            y="108"
            width="50"
            height="18"
            rx="9"
            fill="#ffffff"
        />

        {{-- text lines --}}
        <rect x="325" y="88" width="118" height="14" rx="7" fill="#2d2950" opacity="0.95" />
        <rect x="325" y="116" width="92" height="10" rx="5" fill="#817ba1" />
        <rect x="220" y="182" width="165" height="10" rx="5" fill="#b3aec7" />
        <rect x="220" y="202" width="120" height="10" rx="5" fill="#cbc7da" />
    </g>

    {{-- heart icon --}}
    <g class="ehbo-heart">
        <path
            d="M372 170
               C365 158, 349 158, 343 170
               C337 182, 347 194, 358 201
               C369 194, 379 182, 373 170
               C373 169, 372 169, 372 170 Z"
            fill="#f26f8d"
        />
    </g>

    {{-- ecg line --}}
    <path
        class="ehbo-ecg"
        d="M72 232
           H164
           L186 232
           L205 200
           L224 252
           L246 182
           L268 232
           H334
           L354 232
           L372 214
           L390 232
           H626"
        fill="none"
        stroke="#f2c94c"
        stroke-width="6"
        stroke-linecap="round"
        stroke-linejoin="round"
    />

    {{-- bottom glow line --}}
    <path
        d="M60 232 H640"
        fill="none"
        stroke="#ffffff"
        stroke-opacity="0.08"
        stroke-width="2"
    />

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
        EHBO
    </text>
</svg>