<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <main class="app-shell">

        <header class="topbar">
            <a href="/" class="brand">
                <span class="brand-mark">◡</span>
                <span>Clientboard</span>
            </a>

            <button class="new-project-button">
                <span>+</span>
                New project
            </button>
        </header>

        <section class="dashboard-intro">
    <div class="intro-copy">
        <h1>
            {{ $waitingForFeedback }} projects are<br>
            waiting on feedback.
        </h1>

        <p>
            {{ $activeProjects }} active projects across
            {{ $clientCount }} clients.
            Click a card for notes and details,
            or a client name for their page.
        </p>
    </div>
</section>

<section class="client-toolbar">

    <div class="client-filters">

        <button class="client-filter is-active" type="button">
            All clients
        </button>

        @foreach ($clients as $client)
            <button class="client-filter" type="button">

                <span
                    class="client-dot client-dot--{{ $client['slug'] }}"
                ></span>

                {{ $client['name'] }}

            </button>
        @endforeach

    </div>

    <button class="add-client-button" type="button">
        <span>+</span>
        Add client
    </button>

</section>

<section class="client-overview">

    <div class="client-overview__header">

        <div>
            <span class="client-eyebrow">
                Selected client
            </span>

            <h2>
                {{ $selectedClient['name'] }}
            </h2>

            <p>
                {{ $selectedClient['type'] }}
                ·
                {{ $selectedClient['location'] }}
            </p>
        </div>

        <div class="client-overview__stats">

            <div class="client-stat">
                <span>Projects</span>
                <strong>
                    {{ $selectedClient['activeProjects'] }}
                </strong>
            </div>

            <div class="client-stat">
                <span>Status</span>
                <strong>
                    {{ $selectedClient['status'] }}
                </strong>
            </div>

        </div>

    </div>

<div class="client-visual">
    @include('partials.noordgroeit-landscape')
</div>

</section>

    </main>
</body>
</html>