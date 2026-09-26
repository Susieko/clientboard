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

    <button
        type="button"
        class="new-project-button"
        data-open-new-project
    >
        + New project
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
        class="client-dot"
        style="background: {{ $client->accent_color ?? '#d4a526' }}"
    ></span>

                {{ $client['name'] }}

            </a>

        @endforeach

    </div>

    <button
        type="button"
        class="add-client-button"
        data-open-add-client
    >
        + Add client
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

    @include('partials.client-visual', [
        'clientSlug' => $selectedClient->slug ?? 'default',
    ])

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
    {{ count($projects) }}
    {{ count($projects) === 1 ? 'project' : 'projects' }}
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
        data-project-status="{{ $project->status }}"
        data-card-status="{{ $project->status }}"

        data-project-client="{{ $project->client?->name ?? 'No client' }}"
        data-project-client-id="{{ $project->client_id }}"
        data-project-client-slug="{{ $project->client?->slug ?? '' }}"
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

<div class="project-card__topline">

    <span class="project-card__client">

        <span
            class="project-card__client-dot"
            style="
                background:
                {{ $project->client?->accent_color ?? '#d4a526' }}
            "
        ></span>

        {{ $project->client?->name ?? 'No client' }}

    </span>


    <span class="project-card__status">

        @switch($project->status)

            @case('design')
                Design
                @break

            @case('development')
                Development
                @break

            @case('feedback')
                Feedback
                @break

            @case('done')
                Done
                @break

        @endswitch

    </span>

</div>


<h4>
    {{ $project->title }}
</h4>


<div class="project-card__progress">

    <div class="project-card__progress-info">

        <span>
            Progress
        </span>

        <strong>
            {{ $project->progress }}%
        </strong>

    </div>


    <div class="progress-track">

        <span
            style="
                width:
                {{ $project->progress }}%
            "
        ></span>

    </div>

</div>


<div class="project-card__footer">

    <span
        class="project-card__deadline"
        data-card-deadline
    >
        {{ $project->deadline ?? 'No deadline' }}
    </span>


    <span class="project-card__notes">

        <span aria-hidden="true">
            ✦
        </span>

        <span data-card-note-count>
            {{ $project->notes->count() }}
        </span>

    </span>

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
        class="client-modal-backdrop"
        data-client-modal-backdrop
    ></div>

    <div
        class="client-modal"
        data-client-modal
        aria-hidden="true"
    >
        <div class="client-modal__header">

            <div>
                <span class="client-modal__eyebrow">
                    New client
                </span>

                <h2>
                    Who are we building for?
                </h2>
            </div>

            <button
                type="button"
                class="client-modal__close"
                data-close-add-client
                aria-label="Close client form"
            >
                ×
            </button>

        </div>


        <form
            class="client-modal__form"
            data-add-client-form
        >

            <label class="project-field">
                <span>Client name</span>

                <input
                    type="text"
                    name="name"
                    placeholder="e.g. BirbBuds"
                    maxlength="255"
                    required
                >
            </label>


            <div class="project-modal__row">

                <label class="project-field">
                    <span>Type</span>

                    <input
                        type="text"
                        name="type"
                        placeholder="Non-profit, Company..."
                    >
                </label>


                <label class="project-field">
                    <span>Location</span>

                    <input
                        type="text"
                        name="location"
                        placeholder="Tilburg"
                    >
                </label>

            </div>


            <label class="project-field">
                <span>Description</span>

                <textarea
                    name="description"
                    class="client-description-input"
                    maxlength="1000"
                    rows="4"
                    placeholder="What does this client do?"
                ></textarea>
            </label>


            <div class="project-modal__row">

                <label class="project-field">
                    <span>Contact person</span>

                    <input
                        type="text"
                        name="contact_name"
                        placeholder="Jan"
                    >
                </label>


                <label class="project-field">
                    <span>Email</span>

                    <input
                        type="email"
                        name="contact_email"
                        placeholder="hello@example.nl"
                    >
                </label>

            </div>


            <label class="project-field">

                <span>Accent colour</span>

                <div class="client-color-field">

                    <input
                        type="color"
                        name="accent_color"
                        value="#d4a526"
                        data-client-color
                    >

                    <span data-client-color-value>
                        #d4a526
                    </span>

                </div>

            </label>


            <p
                class="project-modal__error"
                data-add-client-error
                hidden
            ></p>


            <div class="project-modal__actions">

                <button
                    type="button"
                    class="project-modal__cancel"
                    data-cancel-add-client
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="project-modal__submit"
                    data-submit-add-client
                >
                    Add client
                </button>

            </div>

        </form>
    </div>

        <div
        class="project-modal-backdrop"
        data-project-modal-backdrop
    ></div>

    <div
        class="project-modal"
        data-project-modal
        aria-hidden="true"
    >
        <div class="project-modal__header">

            <div>
                <span class="project-modal__eyebrow">
                    New project
                </span>

                <h2>
                    Add something to the board.
                </h2>
            </div>

            <button
                type="button"
                class="project-modal__close"
                data-close-new-project
                aria-label="Close new project form"
            >
                ×
            </button>

        </div>


        <form
            class="project-modal__form"
            data-new-project-form
        >

            <label class="project-field">

                <span>
                    Project name
                </span>

                <input
                    type="text"
                    name="title"
                    placeholder="e.g. Clientboard redesign"
                    maxlength="255"
                    required
                    autofocus
                >

            </label>


            <label class="project-field">

                <span>
                    Client
                </span>

                <select
                    name="client_id"
                    required
                >

                    <option value="" disabled
                        @selected(!$selectedClient)
                    >
                        Choose a client
                    </option>

                    @foreach ($clients as $client)

                        <option
                            value="{{ $client->id }}"
                            @selected(
                                $selectedClient?->id === $client->id
                            )
                        >
                            {{ $client->name }}
                        </option>

                    @endforeach

                </select>

            </label>

            <div class="project-modal__row">

                <label class="project-field">

                    <span>
                        Status
                    </span>

                    <select name="status">

                        <option value="design" selected>
                            Design
                        </option>

                        <option value="development">
                            Development
                        </option>

                        <option value="feedback">
                            Waiting for feedback
                        </option>

                        <option value="done">
                            Done
                        </option>

                    </select>

                </label>


                <label class="project-field">

                    <span>
                        Deadline
                    </span>

                    <input
                        type="date"
                        name="deadline"
                    >

                </label>

            </div>


            <label class="project-field">

                <div class="project-field__heading">

                    <span>
                        Progress
                    </span>

                    <strong data-new-project-progress-label>
                        0%
                    </strong>

                </div>

                <input
                    type="range"
                    name="progress"
                    min="0"
                    max="100"
                    value="0"
                    data-new-project-progress
                >

            </label>


            <p
                class="project-modal__error"
                data-new-project-error
                hidden
            ></p>


            <div class="project-modal__actions">

                <button
                    type="button"
                    class="project-modal__cancel"
                    data-cancel-new-project
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="project-modal__submit"
                    data-submit-new-project
                >
                    Create project
                </button>

            </div>

        </form>
    </div>

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

        @foreach ($clients as $client)

            <div
                class="drawer-client-scene"
                data-drawer-client-scene="{{ $client->slug }}"
                hidden
            >
                @include('partials.client-visual', [
                    'clientSlug' => $client->slug,
                ])
            </div>

        @endforeach

    </div>


    <div class="project-drawer__content">

        <div class="project-drawer__top">

            <span>
                Project details
            </span>

            <div class="project-drawer__top-actions">

                <span
                    class="drawer-save-state"
                    data-drawer-save-state
                    aria-live="polite"
                >
                    Saved ✓
                </span>

                <button
                    class="project-drawer__close"
                    type="button"
                    data-drawer-close
                    aria-label="Close project details"
                >
                    ×
                </button>

            </div>

        </div>


        <h2 data-drawer-title>
            Project details
        </h2>


        <div
            class="drawer-project-client"
            data-drawer-client
        >
            Client
        </div>


        <div class="drawer-detail">

            <label
                class="drawer-detail__label"
                for="drawer-project-client"
            >
                Client
            </label>

            <select
                id="drawer-project-client"
                class="drawer-client-select"
                data-drawer-client-select
            >

                @foreach ($clients as $client)

                    <option value="{{ $client->id }}">
                        {{ $client->name }}
                    </option>

                @endforeach

            </select>

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

                <span>
                    Progress
                </span>

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

                        <span
                            data-drawer-client-contact
                        ></span>

                        <a
                            href="#"
                            data-drawer-client-email
                        ></a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</aside>
    </body>
    </html>