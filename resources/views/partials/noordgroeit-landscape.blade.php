<svg
    class="client-landscape"
    viewBox="0 0 700 300"
    role="img"
    aria-label="Illustrated NoordgroeiT landscape"
>

    {{-- Sky --}}
    <rect
        width="700"
        height="300"
        fill="#262244"
    />

    {{-- Clouds --}}
    <g class="landscape-cloud landscape-cloud--one">
        <ellipse cx="95" cy="72" rx="35" ry="15" fill="#3b365f" />
        <ellipse cx="125" cy="67" rx="27" ry="18" fill="#3b365f" />
        <ellipse cx="150" cy="75" rx="32" ry="13" fill="#3b365f" />
    </g>

    <g class="landscape-cloud landscape-cloud--two">
        <ellipse cx="425" cy="56" rx="30" ry="13" fill="#413b68" />
        <ellipse cx="452" cy="50" rx="24" ry="16" fill="#413b68" />
        <ellipse cx="475" cy="57" rx="28" ry="12" fill="#413b68" />
    </g>

    {{-- Sun --}}
    <g class="landscape-sun">
        <circle
            cx="620"
            cy="118"
            r="43"
            fill="#c69b29"
        />

        <g
            stroke="#c69b29"
            stroke-width="7"
            stroke-linecap="round"
        >
            <line x1="620" y1="53" x2="620" y2="32" />
            <line x1="620" y1="183" x2="620" y2="204" />

            <line x1="555" y1="118" x2="532" y2="118" />
            <line x1="685" y1="118" x2="708" y2="118" />

            <line x1="575" y1="73" x2="558" y2="56" />
            <line x1="665" y1="73" x2="682" y2="56" />

            <line x1="575" y1="163" x2="558" y2="180" />
            <line x1="665" y1="163" x2="682" y2="180" />
        </g>
    </g>

    {{-- Back hill --}}
    <path
        d="M0 210
           C120 155, 230 165, 340 195
           C445 220, 555 190, 700 165
           L700 300
           L0 300 Z"
        fill="#274d49"
    />

    {{-- Front hill --}}
    <path
        d="M0 242
           C140 205, 255 225, 370 245
           C485 265, 595 250, 700 225
           L700 300
           L0 300 Z"
        fill="#17634f"
    />

    {{-- Windmill --}}
    <g class="windmill">

        {{-- tower --}}
        <path
            d="M285 222
               L300 135
               L326 135
               L342 222 Z"
            fill="#aaa7a1"
        />

        {{-- roof --}}
        <path
            d="M292 140
               Q313 118 334 140 Z"
            fill="#767273"
        />

        {{-- blades --}}
        <g class="windmill-blades">

            <circle
                cx="313"
                cy="145"
                r="8"
                fill="#8c7651"
            />

            <g fill="#aa9870">
                <rect
                    x="307"
                    y="72"
                    width="12"
                    height="65"
                    rx="2"
                />

                <rect
                    x="307"
                    y="153"
                    width="12"
                    height="65"
                    rx="2"
                />

                <rect
                    x="240"
                    y="139"
                    width="65"
                    height="12"
                    rx="2"
                />

                <rect
                    x="321"
                    y="139"
                    width="65"
                    height="12"
                    rx="2"
                />
            </g>

        </g>
    </g>

    {{-- Little plants --}}
    <g class="landscape-plants">

        <g transform="translate(70 238)">
            <line
                x1="0"
                y1="0"
                x2="0"
                y2="34"
                stroke="#124c3d"
                stroke-width="5"
            />

            <ellipse
                cx="-9"
                cy="5"
                rx="12"
                ry="6"
                transform="rotate(-25 -9 5)"
                fill="#7c9d55"
            />

            <ellipse
                cx="10"
                cy="10"
                rx="12"
                ry="6"
                transform="rotate(25 10 10)"
                fill="#90aa5c"
            />
        </g>

        <g transform="translate(500 230)">
            <line
                x1="0"
                y1="0"
                x2="0"
                y2="40"
                stroke="#124c3d"
                stroke-width="5"
            />

            <ellipse
                cx="-10"
                cy="8"
                rx="13"
                ry="6"
                transform="rotate(-28 -10 8)"
                fill="#88a65a"
            />

            <ellipse
                cx="11"
                cy="12"
                rx="13"
                ry="6"
                transform="rotate(25 11 12)"
                fill="#a1b967"
            />
        </g>

        <g transform="translate(580 244)">
            <line
                x1="0"
                y1="0"
                x2="0"
                y2="31"
                stroke="#124c3d"
                stroke-width="5"
            />

            <ellipse
                cx="-8"
                cy="5"
                rx="11"
                ry="6"
                transform="rotate(-30 -8 5)"
                fill="#809e55"
            />

            <ellipse
                cx="9"
                cy="9"
                rx="11"
                ry="6"
                transform="rotate(30 9 9)"
                fill="#a4b96a"
            />
        </g>

    </g>

</svg>