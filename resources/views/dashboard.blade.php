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

<span
    class="brand-mark brand-mascot"
    data-brand-mascot
    aria-hidden="true"
>
    <span class="mascot-eyes">

        <span class="mascot-eye">
            <span class="mascot-pupil">
                <span class="mascot-highlight"></span>
            </span>

            <span class="mascot-happy-eye">^</span>
        </span>

        <span class="mascot-eye">
            <span class="mascot-pupil">
                <span class="mascot-highlight"></span>
            </span>

            <span class="mascot-happy-eye">^</span>
        </span>

    </span>

    <span class="mascot-ear mascot-ear--left"></span>
<span class="mascot-ear mascot-ear--right"></span>

    <span class="mascot-blush mascot-blush--left"></span>
    <span class="mascot-blush mascot-blush--right"></span>

    <span class="mascot-heart">♥</span>
</span>

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
    @if ($waitingForFeedback === 1)

        1 project is<br>
        waiting for feedback.

    @else

        {{ $waitingForFeedback }} projects are<br>
        waiting for feedback.

    @endif
</h1>

        <p>
            {{ $activeProjects }}
            {{ $activeProjects === 1 ? 'active project' : 'active projects' }}
            across

            {{ $clientCount }}
            {{ $clientCount === 1 ? 'client' : 'clients' }}.

            Click a card for notes and details,
            or a client name for their page.
        </p>

    </div>


    @if ($nextDeadline)

        <button
            type="button"
            class="deadline-widget"
            data-deadline-project="{{ $nextDeadline['id'] }}"
        >

            <div class="deadline-widget__copy">

                <span class="deadline-widget__eyebrow">
                    Next deadline
                </span>

                <strong class="deadline-widget__title">
                    {{ $nextDeadline['title'] }}
                </strong>

                <span class="deadline-widget__meta">
                    {{ $nextDeadline['client'] }}
                    ·
                    {{ $nextDeadline['date'] }}
                </span>

            </div>


            <div class="deadline-widget__ring">

                @if ($nextDeadline['days'] === 0)

                    <strong class="deadline-widget__today">
                        Today
                    </strong>

                @else

                    <strong>
                        {{ $nextDeadline['days'] }}
                    </strong>

                    <span>
                        {{ $nextDeadline['days'] === 1
                            ? 'day'
                            : 'days' }}
                    </span>

                @endif

            </div>

        </button>

    @else

        <div class="deadline-widget deadline-widget--empty">

            <div class="deadline-widget__copy">

                <span class="deadline-widget__eyebrow">
                    Next deadline
                </span>

                <strong class="deadline-widget__title">
                    Nothing urgent ✨
                </strong>

                <span class="deadline-widget__meta">
                    No upcoming deadlines
                </span>

            </div>

        </div>

    @endif

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

    <section
        class="client-overview"
        style="
            --client-accent:
            {{ $selectedClient->accent_color ?? '#d0a323' }};
        "
    >

        <div class="client-overview__content">

            <div class="client-overview__info">

                <div class="client-overview__identity">

                    <span class="client-avatar">
                        {{ $selectedClientInitials }}
                    </span>

                    <span class="client-type">

                        {{ $selectedClient->type ?? 'Client' }}

                        @if ($selectedClient->location)
                            · {{ $selectedClient->location }}
                        @endif

                    </span>

                </div>


                <h2>
                    {{ $selectedClient->name }}
                </h2>


                <p class="client-description">

                    {{ $selectedClient->description
                        ?? 'Client projects and progress.' }}

                </p>


                <div class="client-meta">

                    <span>

                        {{ $selectedClientStats['open_projects'] }}

                        {{ $selectedClientStats['open_projects'] === 1
                            ? 'open project'
                            : 'open projects' }}

                    </span>


                    <span>

                        @if ($selectedClientStats['next_deadline'])

                            Next due
                            {{ $selectedClientStats['next_deadline'] }}

                        @else

                            No upcoming deadline

                        @endif

                    </span>


                    <span>
                        {{ $selectedClientStats['average_progress'] }}%
                        done on average
                    </span>

                </div>


                <a
                    href="/"
                    class="back-to-clients"
                >
                    Back to all clients
                </a>

            </div>


            <div class="client-overview__visual">

                @if ($selectedClient->slug === 'noordgroeit')

                    @include(
                        'partials.noordgroeit-landscape'
                    )

                @else

                    <div class="client-generic-visual">

                        <div
                            class="
                                client-generic-visual__orb
                                client-generic-visual__orb--one
                            "
                        ></div>

                        <div
                            class="
                                client-generic-visual__orb
                                client-generic-visual__orb--two
                            "
                        ></div>

                        <span
                            class="client-generic-visual__initials"
                        >
                            {{ $selectedClientInitials }}
                        </span>

                        <span
                            class="client-generic-visual__name"
                        >
                            {{ $selectedClient->name }}
                        </span>

                    </div>

                @endif

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

            <div
    class="workflow-column"
    data-status-column="{{ $column['key'] }}"
>

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
    data-project-client-type="{{ $project->client?->type ?? '' }}"
    data-project-client-location="{{ $project->client?->location ?? '' }}"
    data-project-client-description="{{ $project->client?->description ?? '' }}"
    data-project-client-contact="{{ $project->client?->contact_name ?? '' }}"
    data-project-client-email="{{ $project->client?->contact_email ?? '' }}"
    data-project-client-color="{{ $project->client?->accent_color ?? '#d0a323' }}"

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

                                    <strong data-card-deadline>
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

    <label
        class="drawer-detail__label"
        for="project-deadline"
    >
        Deadline
    </label>

    <input
        type="date"
        id="project-deadline"
        class="drawer-deadline-input"
        data-drawer-deadline
    >

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

<div class="drawer-detail">

    <span class="drawer-detail__label">
        Client
    </span>

    <div
        class="drawer-client-card"
        data-drawer-client-card
    >
        <div
            class="drawer-client-card__avatar"
            data-drawer-client-avatar
        >
            CL
        </div>

        <div class="drawer-client-card__content">

            <div class="drawer-client-card__heading">
                <strong data-drawer-client-name>
                    Client
                </strong>

                <span data-drawer-client-type>
                    —
                </span>
            </div>

            <p
                class="drawer-client-card__location"
                data-drawer-client-location
            ></p>

            <p
                class="drawer-client-card__description"
                data-drawer-client-description
            ></p>

            <div
                class="drawer-client-card__contact"
                data-drawer-client-contact-row
            >
                <span data-drawer-client-contact></span>

                <a
                    href="#"
                    data-drawer-client-email
                ></a>
            </div>

        </div>
    </div>

</div>

</div>

    </div>

</aside>
</body>
</html>