<svg
    class="client-visual-svg birbbuds-visual"
    viewBox="0 0 700 300"
    role="img"
    aria-label="BirbBuds visual"
>
    <defs>
        <radialGradient
            id="birbGlow"
            cx="50%"
            cy="40%"
            r="65%"
        >
            <stop
                offset="0%"
                stop-color="#8d6bc1"
                stop-opacity="0.45"
            />
            <stop
                offset="100%"
                stop-color="#2b254f"
                stop-opacity="0"
            />
        </radialGradient>
    </defs>

    {{-- background --}}
    <rect
        width="700"
        height="300"
        fill="#2b254f"
    />

    <rect
        width="700"
        height="300"
        fill="url(#birbGlow)"
    />

    {{-- soft blobs --}}
    <circle
        cx="610"
        cy="52"
        r="55"
        fill="#d8a8ef"
        opacity="0.22"
    />

    <circle
        cx="165"
        cy="258"
        r="28"
        fill="#c891e7"
        opacity="0.16"
    />

    <circle
        cx="525"
        cy="230"
        r="22"
        fill="#f0b7ee"
        opacity="0.12"
    />

    {{-- hills --}}
    <path
        d="M0 215
           C130 175, 245 185, 350 205
           C455 225, 565 225, 700 195
           L700 300
           L0 300 Z"
        fill="#45386f"
    />

    <path
        d="M0 240
           C145 210, 260 220, 365 238
           C470 256, 595 250, 700 225
           L700 300
           L0 300 Z"
        fill="#5a477f"
    />

    {{-- stars / sparkles --}}
    <g class="birb-twinkle birb-twinkle--one">
        <circle
            cx="140"
            cy="62"
            r="3"
            fill="#f8d775"
        />
    </g>

    <g class="birb-twinkle birb-twinkle--two">
        <circle
            cx="540"
            cy="95"
            r="2.5"
            fill="#f8d775"
        />
    </g>

    <g class="birb-twinkle birb-twinkle--three">
        <circle
            cx="475"
            cy="54"
            r="2"
            fill="#f8d775"
        />
    </g>

    {{-- floating items --}}
    <g class="birb-float-item birb-float-item--one">
        <path
            d="M258 98
               C251 89, 237 89, 232 99
               C227 109, 235 120, 246 126
               C257 120, 266 109, 261 99
               C260 97, 259 97, 258 98 Z"
            fill="#f3a7cb"
        />
    </g>

    <g class="birb-float-item birb-float-item--two">
        <ellipse
            cx="484"
            cy="113"
            rx="10"
            ry="7"
            fill="#f7d26f"
        />
        <ellipse
            cx="476"
            cy="110"
            rx="4"
            ry="2.5"
            fill="#d39b2c"
            opacity="0.8"
        />
    </g>

    <g class="birb-float-item birb-float-item--three">
        <circle
            cx="220"
            cy="178"
            r="10"
            fill="#91d4ff"
            opacity="0.9"
        />
        <circle
            cx="220"
            cy="178"
            r="4"
            fill="#ffffff"
            opacity="0.55"
        />
    </g>

    {{-- little stand --}}
    <ellipse
        cx="355"
        cy="225"
        rx="70"
        ry="16"
        fill="#231d42"
        opacity="0.55"
    />

    {{-- birb --}}
    <g class="birb-character">
        {{-- body --}}
        <ellipse
            cx="355"
            cy="172"
            rx="58"
            ry="52"
            fill="#f2b7e8"
        />

        {{-- belly --}}
        <ellipse
            cx="355"
            cy="185"
            rx="32"
            ry="27"
            fill="#ffeaf8"
        />

        {{-- left wing --}}
        <ellipse
            class="birb-wing birb-wing--left"
            cx="314"
            cy="177"
            rx="18"
            ry="28"
            fill="#e59fda"
        />

        {{-- right wing --}}
        <ellipse
            class="birb-wing birb-wing--right"
            cx="396"
            cy="177"
            rx="18"
            ry="28"
            fill="#e59fda"
        />

        {{-- feet --}}
        <line
            x1="342"
            y1="220"
            x2="336"
            y2="233"
            stroke="#f3a76b"
            stroke-width="4"
            stroke-linecap="round"
        />
        <line
            x1="368"
            y1="220"
            x2="374"
            y2="233"
            stroke="#f3a76b"
            stroke-width="4"
            stroke-linecap="round"
        />

        {{-- beak --}}
        <path
            d="M355 180
               L372 186
               L355 192 Z"
            fill="#f3b14f"
        />

        {{-- eyes --}}
        <circle
            cx="339"
            cy="167"
            r="8"
            fill="#ffffff"
        />
        <circle
            cx="373"
            cy="167"
            r="8"
            fill="#ffffff"
        />

        <circle
            class="birb-pupil birb-pupil--left"
            cx="339"
            cy="167"
            r="4"
            fill="#171329"
        />
        <circle
            class="birb-pupil birb-pupil--right"
            cx="373"
            cy="167"
            r="4"
            fill="#171329"
        />

        {{-- blush --}}
        <ellipse
            cx="325"
            cy="181"
            rx="7"
            ry="4"
            fill="#f39fc2"
            opacity="0.65"
        />
        <ellipse
            cx="386"
            cy="181"
            rx="7"
            ry="4"
            fill="#f39fc2"
            opacity="0.65"
        />

        {{-- tuft --}}
        <path
            d="M344 121
               C344 110, 352 106, 356 112
               C356 101, 366 99, 367 112
               C373 106, 379 109, 377 120"
            fill="none"
            stroke="#f2b7e8"
            stroke-width="7"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </g>

    {{-- label --}}
    <text
        x="355"
        y="270"
        text-anchor="middle"
        fill="#f4edf9"
        font-size="16"
        font-weight="800"
        letter-spacing="0.14em"
        font-family="Arial, Helvetica, sans-serif"
    >
        BIRBBUDS
    </text>
</svg>