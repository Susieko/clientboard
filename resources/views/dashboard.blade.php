<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <a
        href="{{ url('/') }}"
        class="client-filter {{ !$selectedSlug ? 'is-active' : '' }}"
    >
        All clients
    </a>

    @foreach ($clients as $client)

        <a
            href="{{ url('/') }}?client={{ $client['slug'] }}"
            class="client-filter {{ $selectedSlug === $client['slug'] ? 'is-active' : '' }}"
        >

            <span
                class="client-dot client-dot--{{ $client['slug'] }}"
            ></span>

            {{ $client['name'] }}

        </a>

    @endforeach

</div>

    <button class="add-client-button" type="button">
        <span>+</span>
        Add client
    </button>

</section>

@if ($selectedClient)
    <section class="client-overview">

        <div class="client-overview__content">

            <div class="client-overview__info">

                <div class="client-overview__identity">
                    <span class="client-avatar">
                        NG
                    </span>

                    <span class="client-type">
                        Non-profit
                    </span>
                </div>

                <h2>
                    {{ $selectedClient['name'] }}
                </h2>

                <p class="client-description">
                    A non-profit growing its online home:
                    a warm, easy-to-use website for visitors,
                    plus a place where volunteers can sign up.
                </p>

                <div class="client-meta">
                    <span>2 open projects</span>
                    <span>Next due 14 Oct</span>
                    <span>45% done on average</span>
                </div>

                <a href="/" class="back-to-clients">
                    Back to all clients
                </a>

            </div>


            <div class="client-overview__visual">
                @include('partials.noordgroeit-landscape')
            </div>

        </div>

    </section>
@endif

<section class="project-workflow">

    <div class="workflow-heading">
        <div>
            <span class="client-eyebrow">Project workflow</span>
            <h2>Projects</h2>
        </div>

        <span class="workflow-count">
            {{ count($projects) }} projects
        </span>
    </div>


    <div class="workflow-grid">

        @foreach ($workflowColumns as $column)

            <div class="workflow-column">

                <div class="workflow-column__header">

                    <h3>
                        {{ $column['label'] }}
                    </h3>

                    <span class="workflow-column__count">
                        {{ collect($projects)->where('status', $column['key'])->count() }}
                    </span>

                </div>


                <div class="workflow-column__cards">

                    @foreach ($projects as $project)

                        @if ($project['status'] === $column['key'])

<article
    class="project-card"
    data-project-card

    data-project-id="{{ $project->id }}"
    data-project-title="{{ $project['title'] }}"
    data-project-client="{{ $project->client?->name ?? 'No client' }}"
    data-project-notes="{{ $project->notes->pluck('content')->toJson() }}"
    data-project-status="{{ $project['status'] }}"
    data-project-deadline="{{ $project['deadline'] }}"
    data-project-progress="{{ $project['progress'] }}"

    tabindex="0"
    role="button"
>

                                <div class="project-card__top">

                                    <span class="project-card__client">
                                        {{ $project->client?->name ?? 'No client' }}
                                    </span>

                                    <button
                                        class="project-card__menu"
                                        type="button"
                                        aria-label="Project options"
                                    >
                                        ···
                                    </button>

                                </div>


                                <h4>
                                    {{ $project['title'] }}
                                </h4>


                                <div class="project-card__progress">

                                    <div class="project-card__progress-info">
                                        <span>Progress</span>

                                        <strong>
                                            {{ $project['progress'] }}%
                                        </strong>
                                    </div>

                                    <div class="progress-track">
                                        <span
                                            style="width: {{ $project['progress'] }}%"
                                        ></span>
                                    </div>

                                </div>  

                                <div class="project-card__footer">

                                    <span>
                                        Deadline
                                    </span>

                                    <strong>
                                        {{ $project['deadline'] }}
                                    </strong>

                                </div>

                            </article>

                        @endif

                    @endforeach

                </div>

            </div>

        @endforeach

    </div>

</section>

    </main>

    <div
    class="drawer-backdrop"
    data-drawer-backdrop
></div>

<aside
    class="project-drawer"
    data-project-drawer
    aria-hidden="true"
>

    <div class="project-drawer__visual">
        @include('partials.noordgroeit-landscape')
    </div>

    <div class="project-drawer__content">

        <div class="project-drawer__top">
            <span>Project details</span>

            <button
                class="project-drawer__close"
                type="button"
                data-drawer-close
                aria-label="Close project details"
            >
                ×
            </button>
        </div>

<h2 data-drawer-title>
    Project details
</h2>

<div class="drawer-project-client" data-drawer-client>
    Client
</div>

<div class="drawer-detail">

    <span class="drawer-detail__label">
        Status
    </span>

    <div class="drawer-status-grid">

        <button
            type="button"
            class="drawer-status-button"
            data-status-button="design"
        >
            Design
        </button>

        <button
            type="button"
            class="drawer-status-button"
            data-status-button="development"
        >
            Development
        </button>

        <button
            type="button"
            class="drawer-status-button"
            data-status-button="feedback"
        >
            Waiting for feedback
        </button>

        <button
            type="button"
            class="drawer-status-button"
            data-status-button="done"
        >
            Done
        </button>

    </div>

</div>

<div class="drawer-detail">

    <span class="drawer-detail__label">
        Deadline
    </span>

    <strong data-drawer-deadline>
        —
    </strong>

</div>

<div class="drawer-detail">

    <div class="drawer-progress__header">
        <span>Progress</span>

        <strong data-drawer-progress-label>
            0%
        </strong>
    </div>

    <input
        class="drawer-progress-slider"
        data-drawer-progress-slider
        type="range"
        min="0"
        max="100"
        value="0"
        aria-label="Project progress"
    >

</div>

<div class="drawer-detail">

    <span class="drawer-detail__label">
        Notes
    </span>

    <div
        class="drawer-notes"
        data-drawer-notes
    ></div>

    <div class="drawer-note-form">

    <input
        type="text"
        class="drawer-note-input"
        data-note-input
        placeholder="Add a note"
        maxlength="500"
    >

    <button
        type="button"
        class="drawer-note-add"
        data-note-add
    >
        Add
    </button>

</div>

</div>

    </div>

</aside>
</body>
</html>