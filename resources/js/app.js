const projectCards =
    document.querySelectorAll(
        '[data-project-card]'
    )

const drawer =
    document.querySelector(
        '[data-project-drawer]'
    )

const backdrop =
    document.querySelector(
        '[data-drawer-backdrop]'
    )

const closeButton =
    document.querySelector(
        '[data-drawer-close]'
    )

const drawerTitleInput =
    document.querySelector(
        '[data-drawer-title-input]'
    )

const drawerClient =
    document.querySelector(
        '[data-drawer-client]'
    )

const drawerDeadline =
    document.querySelector(
        '[data-drawer-deadline]'
    )

const drawerNotes =
    document.querySelector(
        '[data-drawer-notes]'
    )

const drawerClientSelect =
    document.querySelector(
        '[data-drawer-client-select]'
    )

const statusButtons =
    document.querySelectorAll(
        '[data-status-button]'
    )

const drawerClientScenes =
    document.querySelectorAll(
        '[data-drawer-client-scene]'
    )

const drawerClientCard =
    document.querySelector(
        '[data-drawer-client-card]'
    )

const drawerClientAvatar =
    document.querySelector(
        '[data-drawer-client-avatar]'
    )

const drawerClientName =
    document.querySelector(
        '[data-drawer-client-name]'
    )

const drawerClientType =
    document.querySelector(
        '[data-drawer-client-type]'
    )

const drawerClientLocation =
    document.querySelector(
        '[data-drawer-client-location]'
    )

const drawerClientDescription =
    document.querySelector(
        '[data-drawer-client-description]'
    )

const drawerClientContact =
    document.querySelector(
        '[data-drawer-client-contact]'
    )

const drawerClientEmail =
    document.querySelector(
        '[data-drawer-client-email]'
    )

const drawerClientContactRow =
    document.querySelector(
        '[data-drawer-client-contact-row]'
    )

const archiveProjectButton =
    document.querySelector(
        '[data-archive-project]'
    )

const archiveConfirm =
    document.querySelector(
        '[data-archive-confirm]'
    )

const archiveCancelButton =
    document.querySelector(
        '[data-archive-cancel]'
    )

const archiveConfirmButton =
    document.querySelector(
        '[data-archive-confirm-button]'
    )

const progressSlider =
    document.querySelector(
        '[data-drawer-progress-slider]'
    )

const progressLabel =
    document.querySelector(
        '[data-drawer-progress-label]'
    )

const noteInput =
    document.querySelector(
        '[data-note-input]'
    )

const noteAddButton =
    document.querySelector(
        '[data-note-add]'
    )

const drawerSaveState =
    document.querySelector(
        '[data-drawer-save-state]'
    )

const csrfToken =
    document.querySelector(
        'meta[name="csrf-token"]'
    )?.content

const emailPattern =
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/

const openArchiveButton =
    document.querySelector(
        '[data-open-archive]'
    )

const archiveModal =
    document.querySelector(
        '[data-archive-modal]'
    )

const archiveModalBackdrop =
    document.querySelector(
        '[data-archive-modal-backdrop]'
    )

const closeArchiveButton =
    document.querySelector(
        '[data-close-archive]'
    )

const openEditClientButton =
    document.querySelector(
        '[data-open-edit-client]'
    )

const editClientModal =
    document.querySelector(
        '[data-edit-client-modal]'
    )

const editClientBackdrop =
    document.querySelector(
        '[data-edit-client-backdrop]'
    )

const closeEditClientButton =
    document.querySelector(
        '[data-close-edit-client]'
    )

const cancelEditClientButton =
    document.querySelector(
        '[data-cancel-edit-client]'
    )

const editClientForm =
    document.querySelector(
        '[data-edit-client-form]'
    )

const editClientSubmit =
    document.querySelector(
        '[data-submit-edit-client]'
    )

const editClientError =
    document.querySelector(
        '[data-edit-client-error]'
    )

const editClientColor =
    document.querySelector(
        '[data-edit-client-color]'
    )

const editClientColorValue =
    document.querySelector(
        '[data-edit-client-color-value]'
    )

let activeProjectCard = null
let drawerSaveTimer = null

/* =========================================================
   PROJECT TITLE
   ========================================================= */

drawerTitleInput
    ?.addEventListener(
        'change',
        async (event) => {

            if (!activeProjectCard) {
                return
            }

            const projectId =
                activeProjectCard
                    .dataset
                    .projectId

            const previousTitle =
                activeProjectCard
                    .dataset
                    .projectTitle

            const newTitle =
                event.target
                    .value
                    .trim()


            if (!newTitle) {

                drawerTitleInput.value =
                    previousTitle

                return
            }


            if (
                newTitle ===
                previousTitle
            ) {
                return
            }


            drawerTitleInput.disabled =
                true


            try {

                const response =
                    await fetch(
                        `/projects/${projectId}/title`,
                        {
                            method:
                                'PATCH',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify({
                                    title:
                                        newTitle,
                                }),
                        }
                    )


                if (!response.ok) {

                    throw new Error(
                        'Could not save project title.'
                    )
                }


                const data =
                    await response
                        .json()


                activeProjectCard
                    .dataset
                    .projectTitle =
                    data.title


                const cardTitle =
                    activeProjectCard
                        .querySelector(
                            'h4'
                        )


                if (cardTitle) {

                    cardTitle.textContent =
                        data.title
                }


                drawerTitleInput.value =
                    data.title


                showSavedState()

            } catch (error) {

                console.error(
                    error
                )


                drawerTitleInput.value =
                    previousTitle


                alert(
                    'Project title could not be saved.'
                )

            } finally {

                drawerTitleInput.disabled =
                    false
            }
        }
    )

    drawerTitleInput
    ?.addEventListener(
        'keydown',
        (event) => {

            if (event.key === 'Enter') {

                event.preventDefault()

                drawerTitleInput.blur()
            }
        }
    )

    const newProjectFieldErrors =
    document.querySelectorAll(
        '[data-new-project-field-error]'
    )


function clearNewProjectFieldErrors() {

    newProjectFieldErrors.forEach(
        (errorElement) => {

            errorElement.hidden =
                true

            errorElement.textContent =
                ''
        }
    )


    newProjectForm
        ?.querySelectorAll(
            '.is-invalid'
        )
        .forEach(
            (field) => {

                field.classList.remove(
                    'is-invalid'
                )
            }
        )
}


function showNewProjectFieldError(
    fieldName,
    message
) {

    const field =
        newProjectForm
            ?.querySelector(
                `[name="${fieldName}"]`
            )


    const errorElement =
        document.querySelector(
            `[data-new-project-field-error="${fieldName}"]`
        )


    field
        ?.classList
        .add(
            'is-invalid'
        )


    if (errorElement) {

        errorElement.textContent =
            message

        errorElement.hidden =
            false
    }
}


/* =========================================================
   HELPERS
   ========================================================= */

function getClientInitials(name) {

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map((word) => word[0])
        .join('')
        .toUpperCase()
}


function formatDeadlineLabel(deadline) {

    if (!deadline) {
        return 'No deadline'
    }


    const [year, month, day] =
        deadline
            .split('-')
            .map(Number)


    const deadlineDate =
        new Date(
            year,
            month - 1,
            day
        )


    const today =
        new Date()


    today.setHours(
        0,
        0,
        0,
        0
    )


    const millisecondsPerDay =
        1000 * 60 * 60 * 24


    const daysUntil =
        Math.round(
            (
                deadlineDate -
                today
            ) /
            millisecondsPerDay
        )


    if (daysUntil < 0) {

        const daysOverdue =
            Math.abs(
                daysUntil
            )

        return `Overdue ${daysOverdue} ${
            daysOverdue === 1
                ? 'day'
                : 'days'
        }`
    }


    if (daysUntil === 0) {
        return 'Due today'
    }


    if (daysUntil === 1) {
        return 'Due tomorrow'
    }


    if (daysUntil <= 7) {
        return `Due in ${daysUntil} days`
    }


    return `Due ${
        deadlineDate.toLocaleDateString(
            'en-GB',
            {
                day: 'numeric',
                month: 'short',
            }
        )
    }`
}


function showSavedState() {

    if (!drawerSaveState) {
        return
    }


    clearTimeout(
        drawerSaveTimer
    )


    drawerSaveState.classList.add(
        'is-visible'
    )


    drawerSaveTimer =
        setTimeout(() => {

            drawerSaveState
                .classList
                .remove(
                    'is-visible'
                )

        }, 1600)
}


function updateProgressUI(value) {

    if (progressSlider) {

        progressSlider.value =
            value

        progressSlider
            .style
            .setProperty(
                '--progress',
                `${value}%`
            )
    }


    if (progressLabel) {

        progressLabel.textContent =
            `${value}%`
    }


    if (activeProjectCard) {

        const cardLabel =
            activeProjectCard
                .querySelector(
                    '.project-card__progress-info strong'
                )

        const cardBar =
            activeProjectCard
                .querySelector(
                    '.progress-track span'
                )


        if (cardLabel) {

            cardLabel.textContent =
                `${value}%`
        }


        if (cardBar) {

            cardBar.style.width =
                `${value}%`
        }
    }
}

function openEditClientModal() {

    editClientModal
        ?.classList
        .add('is-open')

    editClientBackdrop
        ?.classList
        .add('is-open')

    editClientModal
        ?.setAttribute(
            'aria-hidden',
            'false'
        )
}


function closeEditClientModal() {

    editClientModal
        ?.classList
        .remove('is-open')

    editClientBackdrop
        ?.classList
        .remove('is-open')

    editClientModal
        ?.setAttribute(
            'aria-hidden',
            'true'
        )

    if (editClientError) {

        editClientError.hidden =
            true

        editClientError.textContent =
            ''
    }
}


openEditClientButton
    ?.addEventListener(
        'click',
        openEditClientModal
    )

closeEditClientButton
    ?.addEventListener(
        'click',
        closeEditClientModal
    )

cancelEditClientButton
    ?.addEventListener(
        'click',
        closeEditClientModal
    )

editClientBackdrop
    ?.addEventListener(
        'click',
        closeEditClientModal
    )


editClientColor
    ?.addEventListener(
        'input',
        (event) => {

            if (editClientColorValue) {

                editClientColorValue.textContent =
                    event.target.value
            }
        }
    )

editClientForm
    ?.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault()


            clearEditClientFieldErrors()


            if (editClientError) {

                editClientError.hidden =
                    true

                editClientError.textContent =
                    ''
            }


            const clientId =
                editClientForm
                    .dataset
                    .clientId


            const formData =
                new FormData(
                    editClientForm
                )


            const name =
                String(
                    formData.get('name') || ''
                ).trim()


            const email =
                String(
                    formData.get(
                        'contact_email'
                    ) || ''
                ).trim()

            let hasErrors =
                false


            if (!name) {

                showEditClientFieldError(
                    'name',
                    'Give the client a name.'
                )

                hasErrors =
                    true
            }


            if (
                email &&
                !emailPattern.test(email)
            ) {

                showEditClientFieldError(
                    'contact_email',
                    'Enter a valid email address.'
                )

                hasErrors =
                    true
            }


            if (hasErrors) {
                return
            }


            const clientData = {

                name,

                type:
                    formData.get('type') || null,

                location:
                    formData.get('location') || null,

                description:
                    formData.get('description') || null,

                contact_name:
                    formData.get('contact_name') || null,

                contact_email:
                    email || null,

                accent_color:
                    formData.get('accent_color'),
            }


            editClientSubmit.disabled =
                true

            editClientSubmit.textContent =
                'Saving...'


            try {

                const response =
                    await fetch(
                        `/clients/${clientId}`,
                        {
                            method:
                                'PATCH',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify(
                                    clientData
                                ),
                        }
                    )


                const data =
                    await response.json()


                if (!response.ok) {

                    if (data.errors) {

                        Object.entries(
                            data.errors
                        ).forEach(
                            ([field, messages]) => {

                                showEditClientFieldError(
                                    field,
                                    messages[0]
                                )
                            }
                        )

                        return
                    }


                    throw new Error(
                        data.message ||
                        'Could not update client.'
                    )
                }


                editClientSubmit.textContent =
                    'Saved ✓'


                setTimeout(
                    () => {

                        window.location.reload()

                    },
                    450
                )


            } catch (error) {

                console.error(
                    error
                )


                if (editClientError) {

                    editClientError.textContent =
                        error.message

                    editClientError.hidden =
                        false
                }


            } finally {

                editClientSubmit.disabled =
                    false


                if (
                    editClientSubmit.textContent !==
                    'Saved ✓'
                ) {

                    editClientSubmit.textContent =
                        'Save changes'
                }
            }
        }
    )

    editClientForm
    ?.querySelectorAll(
        'input, select, textarea'
    )
    .forEach(
        (field) => {

            field.addEventListener(
                'input',
                () => {

                    field.classList.remove(
                        'is-invalid'
                    )


                    const errorElement =
                        document.querySelector(
                            `[data-edit-client-field-error="${field.name}"]`
                        )


                    if (errorElement) {

                        errorElement.hidden =
                            true

                        errorElement.textContent =
                            ''
                    }
                }
            )
        }
    )

function updateColumnCounts() {

    document
        .querySelectorAll(
            '[data-status-column]'
        )
        .forEach((column) => {

            const count =
                column
                    .querySelectorAll(
                        '.project-card'
                    )
                    .length


            const countElement =
                column.querySelector(
                    '.workflow-column__count'
                )


            const emptyState =
                column.querySelector(
                    '.workflow-column__empty'
                )


            if (countElement) {

                countElement.textContent =
                    count
            }


            if (emptyState) {

                emptyState.hidden =
                    count > 0
            }
        })
}

const editClientFieldErrors =
    document.querySelectorAll(
        '[data-edit-client-field-error]'
    )


function clearEditClientFieldErrors() {

    editClientFieldErrors.forEach(
        (errorElement) => {

            errorElement.hidden =
                true

            errorElement.textContent =
                ''
        }
    )


    editClientForm
        ?.querySelectorAll(
            '.is-invalid'
        )
        .forEach(
            (field) => {

                field.classList.remove(
                    'is-invalid'
                )
            }
        )
}


function showEditClientFieldError(
    fieldName,
    message
) {

    const field =
        editClientForm
            ?.querySelector(
                `[name="${fieldName}"]`
            )


    const errorElement =
        document.querySelector(
            `[data-edit-client-field-error="${fieldName}"]`
        )


    field
        ?.classList
        .add(
            'is-invalid'
        )


    if (errorElement) {

        errorElement.textContent =
            message

        errorElement.hidden =
            false
    }
}




/* =========================================================
   OPEN PROJECT DRAWER
   ========================================================= */

function openDrawer(card) {

    activeProjectCard =
        card


    projectCards.forEach(
        (projectCard) => {

            projectCard
                .classList
                .remove(
                    'is-selected'
                )
        }
    )


    card.classList.add(
        'is-selected'
    )


    const clientSlug =
        card.dataset
            .projectClientSlug

    const title =
        card.dataset
            .projectTitle

    const client =
        card.dataset
            .projectClient

    const clientId =
        card.dataset
            .projectClientId

    const clientType =
        card.dataset
            .projectClientType

    const clientLocation =
        card.dataset
            .projectClientLocation

    const clientDescription =
        card.dataset
            .projectClientDescription

    const clientContact =
        card.dataset
            .projectClientContact

    const clientEmail =
        card.dataset
            .projectClientEmail

    const clientColor =
        card.dataset
            .projectClientColor

    const status =
        card.dataset
            .projectStatus

    const deadline =
        card.dataset
            .projectDeadline

    const progress =
        card.dataset
            .projectProgress


    const notes =
        JSON.parse(
            card.dataset
                .projectNotes ||
            '[]'
        )


    /* Project info */

    if (archiveConfirm) {
    archiveConfirm.hidden = true
}

if (archiveProjectButton) {
    archiveProjectButton.hidden = false
}

if (drawerTitleInput) {
    drawerTitleInput.value =
        title
}


    if (drawerClient) {

        drawerClient.textContent =
            client
    }


    if (drawerDeadline) {

        drawerDeadline.value =
            deadline || ''
    }


    if (drawerClientSelect) {

        drawerClientSelect.value =
            clientId || ''
    }


    /* Client details */

    if (drawerClientName) {

        drawerClientName.textContent =
            client
    }


    if (drawerClientAvatar) {

        drawerClientAvatar.textContent =
            getClientInitials(
                client
            )

        drawerClientAvatar
            .style
            .background =
            clientColor
    }


    if (drawerClientType) {

        drawerClientType.textContent =
            clientType ||
            'Client'
    }


    if (drawerClientLocation) {

        drawerClientLocation.textContent =
            clientLocation || ''
    }


    if (drawerClientDescription) {

        drawerClientDescription
            .textContent =
            clientDescription || ''
    }


    if (drawerClientContact) {

        drawerClientContact.textContent =
            clientContact || ''
    }


    if (drawerClientEmail) {

        drawerClientEmail.textContent =
            clientEmail || ''

        drawerClientEmail.href =
            clientEmail
                ? `mailto:${clientEmail}`
                : '#'
    }


    if (drawerClientContactRow) {

        drawerClientContactRow.hidden =
            !clientContact &&
            !clientEmail
    }


    if (drawerClientCard) {

        drawerClientCard
            .style
            .setProperty(
                '--client-accent',
                clientColor
            )
    }


    /* Client illustration */

    drawerClientScenes.forEach(
        (scene) => {

            const isCurrentClient =
                scene.dataset
                    .drawerClientScene ===
                clientSlug

            scene.hidden =
                !isCurrentClient
        }
    )


    /* Status */

    statusButtons.forEach(
        (button) => {

            const isActive =
                button.dataset
                    .statusButton ===
                status

            button.classList.toggle(
                'is-active',
                isActive
            )
        }
    )


    /* Progress */

    updateProgressUI(
        progress
    )


    /* Notes */

    if (drawerNotes) {

        drawerNotes.innerHTML =
            ''


        if (notes.length === 0) {

            drawerNotes.innerHTML = `
                <p class="drawer-notes__empty">
                    No notes yet.
                </p>
            `

        } else {

            notes.forEach(
                (note) => {

                    const item =
                        document
                            .createElement(
                                'div'
                            )

                    item.classList.add(
                        'drawer-note'
                    )


                    item.innerHTML = `
                        <span class="drawer-note__dot"></span>
                        <span></span>
                    `


                    item.querySelector(
                        'span:last-child'
                    ).textContent =
                        note


                    drawerNotes
                        .appendChild(
                            item
                        )
                }
            )
        }
    }


    if (noteInput) {

        noteInput.value =
            ''
    }


    drawer
        ?.classList
        .add(
            'is-open'
        )


    backdrop
        ?.classList
        .add(
            'is-open'
        )


    drawer
        ?.setAttribute(
            'aria-hidden',
            'false'
        )
}


/* =========================================================
   CLOSE PROJECT DRAWER
   ========================================================= */

function closeDrawer() {

    drawer
        ?.classList
        .remove(
            'is-open'
        )


    backdrop
        ?.classList
        .remove(
            'is-open'
        )


    drawer
        ?.setAttribute(
            'aria-hidden',
            'true'
        )


    activeProjectCard
        ?.classList
        .remove(
            'is-selected'
        )


    activeProjectCard =
        null
}

function openArchiveModal() {

    archiveModal
        ?.classList
        .add(
            'is-open'
        )

    archiveModalBackdrop
        ?.classList
        .add(
            'is-open'
        )

    archiveModal
        ?.setAttribute(
            'aria-hidden',
            'false'
        )
}


function closeArchiveModal() {

    archiveModal
        ?.classList
        .remove(
            'is-open'
        )

    archiveModalBackdrop
        ?.classList
        .remove(
            'is-open'
        )

    archiveModal
        ?.setAttribute(
            'aria-hidden',
            'true'
        )
}


openArchiveButton
    ?.addEventListener(
        'click',
        openArchiveModal
    )

closeArchiveButton
    ?.addEventListener(
        'click',
        closeArchiveModal
    )

archiveModalBackdrop
    ?.addEventListener(
        'click',
        closeArchiveModal
    )


/* =========================================================
   PROJECT CARD EVENTS
   ========================================================= */

projectCards.forEach(
    (card) => {

        const deadlineLabel =
            card.querySelector(
                '[data-card-deadline]'
            )


        if (!deadlineLabel) {
            return
        }


        const formattedDeadline =
            formatDeadlineLabel(
                card.dataset
                    .projectDeadline
            )


        deadlineLabel.textContent =
            formattedDeadline


        deadlineLabel
            .classList
            .toggle(
                'is-overdue',
                formattedDeadline
                    .startsWith(
                        'Overdue'
                    )
            )
    }
)


projectCards.forEach(
    (card) => {

        card.addEventListener(
            'click',
            () => {

                openDrawer(
                    card
                )
            }
        )


        card.addEventListener(
            'keydown',
            (event) => {

                if (
                    event.key ===
                        'Enter' ||
                    event.key ===
                        ' '
                ) {

                    event.preventDefault()

                    openDrawer(
                        card
                    )
                }
            }
        )
    }
)


/* =========================================================
   PROGRESS SLIDER
   ========================================================= */

progressSlider
    ?.addEventListener(
        'input',
        (event) => {

            updateProgressUI(
                event.target.value
            )
        }
    )


progressSlider
    ?.addEventListener(
        'change',
        async (event) => {

            if (!activeProjectCard) {
                return
            }


            const projectId =
                activeProjectCard
                    .dataset
                    .projectId


            const previousProgress =
                activeProjectCard
                    .dataset
                    .projectProgress


            const newProgress =
                event.target.value


            progressSlider.disabled =
                true


            try {

                const response =
                    await fetch(
                        `/projects/${projectId}/progress`,
                        {
                            method:
                                'PATCH',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify({
                                    progress:
                                        Number(
                                            newProgress
                                        ),
                                }),
                        }
                    )


                if (!response.ok) {

                    throw new Error(
                        'Could not save project progress.'
                    )
                }


                const data =
                    await response
                        .json()


                const savedProgress =
                    String(
                        data.progress
                    )


                activeProjectCard
                    .dataset
                    .projectProgress =
                    savedProgress


                updateProgressUI(
                    savedProgress
                )


                showSavedState()

            } catch (error) {

                console.error(
                    error
                )


                updateProgressUI(
                    previousProgress
                )


                alert(
                    'Progress could not be saved.'
                )

            } finally {

                progressSlider.disabled =
                    false
            }
        }
    )


/* =========================================================
   PROJECT STATUS
   ========================================================= */

statusButtons.forEach(
    (button) => {

        button.addEventListener(
            'click',
            async () => {

                if (!activeProjectCard) {
                    return
                }


                const projectId =
                    activeProjectCard
                        .dataset
                        .projectId


                const previousStatus =
                    activeProjectCard
                        .dataset
                        .projectStatus


                const newStatus =
                    button.dataset
                        .statusButton


                if (
                    previousStatus ===
                    newStatus
                ) {
                    return
                }


                statusButtons.forEach(
                    (statusButton) => {

                        statusButton.disabled =
                            true
                    }
                )


                try {

                    const response =
                        await fetch(
                            `/projects/${projectId}/status`,
                            {
                                method:
                                    'PATCH',

                                headers: {
                                    'Content-Type':
                                        'application/json',

                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,
                                },

                                body:
                                    JSON.stringify({
                                        status:
                                            newStatus,
                                    }),
                            }
                        )


                    if (!response.ok) {

                        throw new Error(
                            'Could not save project status.'
                        )
                    }


                    const data =
                        await response
                            .json()


                    const savedStatus =
                        data.status


                    activeProjectCard
                        .dataset
                        .projectStatus =
                        savedStatus


                    activeProjectCard
                        .dataset
                        .cardStatus =
                        savedStatus


                    const cardStatusLabel =
                        activeProjectCard
                            .querySelector(
                                '.project-card__status'
                            )


                    const statusLabels = {
                        design:
                            'Design',

                        development:
                            'Development',

                        feedback:
                            'Feedback',

                        done:
                            'Done',
                    }


                    if (cardStatusLabel) {

                        cardStatusLabel
                            .textContent =
                            statusLabels[
                                savedStatus
                            ] ||
                            savedStatus
                    }


                    statusButtons.forEach(
                        (statusButton) => {

                            statusButton
                                .classList
                                .toggle(
                                    'is-active',

                                    statusButton
                                        .dataset
                                        .statusButton ===
                                    savedStatus
                                )
                        }
                    )


                    const targetColumn =
                        document
                            .querySelector(
                                `[data-status-column="${savedStatus}"]`
                            )


                    const targetCardContainer =
                        targetColumn
                            ?.querySelector(
                                '.workflow-column__cards'
                            )


                    if (
                        targetCardContainer &&
                        activeProjectCard
                    ) {

                        targetCardContainer
                            .appendChild(
                                activeProjectCard
                            )
                    }


                    updateColumnCounts()

                    showSavedState()

                } catch (error) {

                    console.error(
                        error
                    )


                    alert(
                        'Project status could not be saved.'
                    )

                } finally {

                    statusButtons.forEach(
                        (statusButton) => {

                            statusButton.disabled =
                                false
                        }
                    )
                }
            }
        )
    }
)


/* =========================================================
   PROJECT DEADLINE
   ========================================================= */

drawerDeadline
    ?.addEventListener(
        'change',
        async (event) => {

            if (!activeProjectCard) {
                return
            }


            const projectId =
                activeProjectCard
                    .dataset
                    .projectId


            const previousDeadline =
                activeProjectCard
                    .dataset
                    .projectDeadline


            const newDeadline =
                event.target.value


            drawerDeadline.disabled =
                true


            try {

                const response =
                    await fetch(
                        `/projects/${projectId}/deadline`,
                        {
                            method:
                                'PATCH',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify({
                                    deadline:
                                        newDeadline ||
                                        null,
                                }),
                        }
                    )


                if (!response.ok) {

                    throw new Error(
                        'Could not save project deadline.'
                    )
                }


                const data =
                    await response
                        .json()


                const savedDeadline =
                    data.deadline ||
                    ''


                activeProjectCard
                    .dataset
                    .projectDeadline =
                    savedDeadline


                const cardDeadline =
                    activeProjectCard
                        .querySelector(
                            '[data-card-deadline]'
                        )


                if (cardDeadline) {

                    cardDeadline
                        .textContent =
                        formatDeadlineLabel(
                            savedDeadline
                        )


                    cardDeadline
                        .classList
                        .toggle(
                            'is-overdue',

                            cardDeadline
                                .textContent
                                .startsWith(
                                    'Overdue'
                                )
                        )
                }


                drawerDeadline.value =
                    savedDeadline


                showSavedState()

            } catch (error) {

                console.error(
                    error
                )


                drawerDeadline.value =
                    previousDeadline ||
                    ''


                alert(
                    'Project deadline could not be saved.'
                )

            } finally {

                drawerDeadline.disabled =
                    false
            }
        }
    )


/* =========================================================
   PROJECT CLIENT
   ========================================================= */

drawerClientSelect
    ?.addEventListener(
        'change',
        async (event) => {

            if (!activeProjectCard) {
                return
            }


            const projectId =
                activeProjectCard
                    .dataset
                    .projectId


            const previousClientId =
                activeProjectCard
                    .dataset
                    .projectClientId


            const newClientId =
                event.target.value


            if (
                previousClientId ===
                newClientId
            ) {
                return
            }


            drawerClientSelect.disabled =
                true


            try {

                const response =
                    await fetch(
                        `/projects/${projectId}/client`,
                        {
                            method:
                                'PATCH',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify({
                                    client_id:
                                        Number(
                                            newClientId
                                        ),
                                }),
                        }
                    )


                const data =
                    await response
                        .json()


                if (!response.ok) {

                    const validationErrors =
                        data.errors
                            ? Object
                                .values(
                                    data.errors
                                )
                                .flat()
                                .join(' ')
                            : null


                    throw new Error(
                        validationErrors ||
                        data.message ||
                        'Could not change client.'
                    )
                }


                /*
                 * Reload because the project may now
                 * belong to another filtered client.
                 */

                window.location.reload()

            } catch (error) {

                console.error(
                    error
                )


                drawerClientSelect.value =
                    previousClientId


                alert(
                    error.message ||
                    'Project client could not be changed.'
                )

            } finally {

                drawerClientSelect.disabled =
                    false
            }
        }
    )


/* =========================================================
   ADD NOTE
   ========================================================= */

noteAddButton
    ?.addEventListener(
        'click',
        async () => {

            if (
                !activeProjectCard ||
                !noteInput
            ) {
                return
            }


            const content =
                noteInput
                    .value
                    .trim()


            if (!content) {
                return
            }


            const projectId =
                activeProjectCard
                    .dataset
                    .projectId


            noteAddButton.disabled =
                true


            noteAddButton.textContent =
                'Adding...'


            try {

                const response =
                    await fetch(
                        `/projects/${projectId}/notes`,
                        {
                            method:
                                'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify({
                                    content,
                                }),
                        }
                    )


                if (!response.ok) {

                    throw new Error(
                        'Could not save note.'
                    )
                }


                const data =
                    await response
                        .json()


                const noteElement =
                    document
                        .createElement(
                            'div'
                        )


                noteElement
                    .classList
                    .add(
                        'drawer-note'
                    )


                noteElement.innerHTML = `
                    <span class="drawer-note__dot"></span>
                    <span></span>
                `


                noteElement
                    .querySelector(
                        'span:last-child'
                    )
                    .textContent =
                    data.note.content


                drawerNotes
                    ?.querySelector(
                        '.drawer-notes__empty'
                    )
                    ?.remove()


                drawerNotes
                    ?.appendChild(
                        noteElement
                    )


                const existingNotes =
                    JSON.parse(
                        activeProjectCard
                            .dataset
                            .projectNotes ||
                        '[]'
                    )


                existingNotes.push(
                    data.note.content
                )


                activeProjectCard
                    .dataset
                    .projectNotes =
                    JSON.stringify(
                        existingNotes
                    )


                const noteCount =
                    activeProjectCard
                        .querySelector(
                            '[data-card-note-count]'
                        )


                if (noteCount) {

                    noteCount.textContent =
                        existingNotes.length
                }


                noteInput.value =
                    ''


                noteInput.focus()


                showSavedState()

            } catch (error) {

                console.error(
                    error
                )


                alert(
                    'The note could not be saved.'
                )

            } finally {

                noteAddButton.disabled =
                    false


                noteAddButton.textContent =
                    'Add'
            }
        }
    )


noteInput
    ?.addEventListener(
        'keydown',
        (event) => {

            if (
                event.key ===
                'Enter'
            ) {

                event.preventDefault()

                noteAddButton
                    ?.click()
            }
        }
    )


/* =========================================================
   DRAWER CLOSE EVENTS
   ========================================================= */

closeButton
    ?.addEventListener(
        'click',
        closeDrawer
    )


backdrop
    ?.addEventListener(
        'click',
        closeDrawer
    )


/* =========================================================
   NEXT DEADLINE WIDGET
   ========================================================= */

const deadlineWidget =
    document.querySelector(
        '[data-deadline-project]'
    )


deadlineWidget
    ?.addEventListener(
        'click',
        () => {

            const projectId =
                deadlineWidget
                    .dataset
                    .deadlineProject


            const projectCard =
                document.querySelector(
                    `[data-project-card][data-project-id="${projectId}"]`
                )


            if (projectCard) {

                openDrawer(
                    projectCard
                )
            }
        }
    )


/* =========================================================
   NEW PROJECT MODAL
   ========================================================= */

const newProjectButton =
    document.querySelector(
        '[data-open-new-project]'
    )

const newProjectModal =
    document.querySelector(
        '[data-project-modal]'
    )

const newProjectBackdrop =
    document.querySelector(
        '[data-project-modal-backdrop]'
    )

const closeNewProjectButton =
    document.querySelector(
        '[data-close-new-project]'
    )

const cancelNewProjectButton =
    document.querySelector(
        '[data-cancel-new-project]'
    )

const newProjectForm =
    document.querySelector(
        '[data-new-project-form]'
    )

const newProjectSubmit =
    document.querySelector(
        '[data-submit-new-project]'
    )

const newProjectError =
    document.querySelector(
        '[data-new-project-error]'
    )

const newProjectProgress =
    document.querySelector(
        '[data-new-project-progress]'
    )

const newProjectProgressLabel =
    document.querySelector(
        '[data-new-project-progress-label]'
    )


function openNewProjectModal() {

    newProjectModal
        ?.classList
        .add(
            'is-open'
        )


    newProjectBackdrop
        ?.classList
        .add(
            'is-open'
        )


    newProjectModal
        ?.setAttribute(
            'aria-hidden',
            'false'
        )


    const titleInput =
        newProjectForm
            ?.querySelector(
                '[name="title"]'
            )


    setTimeout(() => {

        titleInput
            ?.focus()

    }, 100)
}


function closeNewProjectModal() {

    newProjectModal
        ?.classList
        .remove(
            'is-open'
        )


    newProjectBackdrop
        ?.classList
        .remove(
            'is-open'
        )


    newProjectModal
        ?.setAttribute(
            'aria-hidden',
            'true'
        )


    if (newProjectError) {

        newProjectError.hidden =
            true

        newProjectError.textContent =
            ''
    }
}


newProjectButton
    ?.addEventListener(
        'click',
        openNewProjectModal
    )


closeNewProjectButton
    ?.addEventListener(
        'click',
        closeNewProjectModal
    )


cancelNewProjectButton
    ?.addEventListener(
        'click',
        closeNewProjectModal
    )


newProjectBackdrop
    ?.addEventListener(
        'click',
        closeNewProjectModal
    )


newProjectProgress
    ?.addEventListener(
        'input',
        (event) => {

            if (
                newProjectProgressLabel
            ) {

                newProjectProgressLabel
                    .textContent =
                    `${event.target.value}%`
            }
        }
    )


newProjectForm
    ?.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault()


            clearNewProjectFieldErrors()


            if (newProjectError) {
                newProjectError.hidden = true
                newProjectError.textContent = ''
            }


            const formData =
                new FormData(
                    newProjectForm
                )


            const title =
                String(
                    formData.get('title') || ''
                ).trim()


            const clientId =
                formData.get(
                    'client_id'
                )


            let hasErrors =
                false


            if (!title) {

                showNewProjectFieldError(
                    'title',
                    'Give the project a name.'
                )

                hasErrors =
                    true
            }


            if (!clientId) {

                showNewProjectFieldError(
                    'client_id',
                    'Choose a client first.'
                )

                hasErrors =
                    true
            }


            if (hasErrors) {
                return
            }


            const projectData = {

                title,

                client_id:
                    Number(
                        clientId
                    ),

                status:
                    formData.get(
                        'status'
                    ),

                deadline:
                    formData.get(
                        'deadline'
                    ) || null,

                progress:
                    Number(
                        formData.get(
                            'progress'
                        )
                    ),
            }


            newProjectSubmit.disabled =
                true

            newProjectSubmit.textContent =
                'Creating...'


            try {

                const response =
                    await fetch(
                        '/projects',
                        {
                            method:
                                'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify(
                                    projectData
                                ),
                        }
                    )


                const data =
                    await response.json()


                if (!response.ok) {

                    if (data.errors) {

                        Object.entries(
                            data.errors
                        ).forEach(
                            ([field, messages]) => {

                                showNewProjectFieldError(
                                    field,
                                    messages[0]
                                )
                            }
                        )

                        return
                    }


                    throw new Error(
                        data.message ||
                        'Could not create project.'
                    )
                }


                newProjectSubmit.textContent =
                    'Created ✓'


                setTimeout(
                    () => {
                        window.location.reload()
                    },
                    350
                )


            } catch (error) {

                console.error(
                    error
                )


                if (newProjectError) {

                    newProjectError.textContent =
                        error.message

                    newProjectError.hidden =
                        false
                }


            } finally {

                newProjectSubmit.disabled =
                    false

                if (
                    newProjectSubmit.textContent !==
                    'Created ✓'
                ) {

                    newProjectSubmit.textContent =
                        'Create project'
                }
            }
        }
    )

    newProjectForm
    ?.querySelectorAll(
        'input, select, textarea'
    )
    .forEach(
        (field) => {

            field.addEventListener(
                'input',
                () => {

                    field.classList.remove(
                        'is-invalid'
                    )


                    const errorElement =
                        document.querySelector(
                            `[data-new-project-field-error="${field.name}"]`
                        )


                    if (errorElement) {

                        errorElement.hidden =
                            true

                        errorElement.textContent =
                            ''
                    }
                }
            )
        }
    )


/* =========================================================
   ADD CLIENT MODAL
   ========================================================= */

const addClientButton =
    document.querySelector(
        '[data-open-add-client]'
    )

const clientModal =
    document.querySelector(
        '[data-client-modal]'
    )

const clientModalBackdrop =
    document.querySelector(
        '[data-client-modal-backdrop]'
    )

const closeClientModalButton =
    document.querySelector(
        '[data-close-add-client]'
    )

const cancelClientButton =
    document.querySelector(
        '[data-cancel-add-client]'
    )

const addClientForm =
    document.querySelector(
        '[data-add-client-form]'
    )

const addClientSubmit =
    document.querySelector(
        '[data-submit-add-client]'
    )

const addClientError =
    document.querySelector(
        '[data-add-client-error]'
    )

const addClientFieldErrors =
    document.querySelectorAll(
        '[data-add-client-field-error]'
    )


function clearAddClientFieldErrors() {

    addClientFieldErrors.forEach(
        (errorElement) => {

            errorElement.hidden = true
            errorElement.textContent = ''
        }
    )


    addClientForm
        ?.querySelectorAll('.is-invalid')
        .forEach(
            (field) => {

                field.classList.remove(
                    'is-invalid'
                )
            }
        )
}


function showAddClientFieldError(
    fieldName,
    message
) {

    const field =
        addClientForm
            ?.querySelector(
                `[name="${fieldName}"]`
            )


    const errorElement =
        document.querySelector(
            `[data-add-client-field-error="${fieldName}"]`
        )


    field
        ?.classList
        .add('is-invalid')


    if (errorElement) {

        errorElement.textContent =
            message

        errorElement.hidden =
            false
    }
}

const clientColor =
    document.querySelector(
        '[data-client-color]'
    )

const clientColorValue =
    document.querySelector(
        '[data-client-color-value]'
    )


function openClientModal() {

    clientModal
        ?.classList
        .add(
            'is-open'
        )


    clientModalBackdrop
        ?.classList
        .add(
            'is-open'
        )


    clientModal
        ?.setAttribute(
            'aria-hidden',
            'false'
        )


    const nameInput =
        addClientForm
            ?.querySelector(
                '[name="name"]'
            )


    setTimeout(() => {

        nameInput
            ?.focus()

    }, 100)
}


function closeClientModal() {

    clientModal
        ?.classList
        .remove(
            'is-open'
        )


    clientModalBackdrop
        ?.classList
        .remove(
            'is-open'
        )


    clientModal
        ?.setAttribute(
            'aria-hidden',
            'true'
        )


    if (addClientError) {

        addClientError.hidden =
            true

        addClientError.textContent =
            ''
    }
}


addClientButton
    ?.addEventListener(
        'click',
        openClientModal
    )


closeClientModalButton
    ?.addEventListener(
        'click',
        closeClientModal
    )


cancelClientButton
    ?.addEventListener(
        'click',
        closeClientModal
    )


clientModalBackdrop
    ?.addEventListener(
        'click',
        closeClientModal
    )


clientColor
    ?.addEventListener(
        'input',
        (event) => {

            if (clientColorValue) {

                clientColorValue
                    .textContent =
                    event.target.value
            }
        }
    )


addClientForm
    ?.addEventListener(
        'submit',
        async (event) => {

            event.preventDefault()


            clearAddClientFieldErrors()


            if (addClientError) {
                addClientError.hidden = true
                addClientError.textContent = ''
            }


            const formData =
                new FormData(
                    addClientForm
                )


            const name =
                String(
                    formData.get('name') || ''
                ).trim()


            const email =
                String(
                    formData.get(
                        'contact_email'
                    ) || ''
                ).trim()


            let hasErrors =
                false


            if (!name) {

                showAddClientFieldError(
                    'name',
                    'Give the client a name.'
                )

                hasErrors = true
            }

if (
    email &&
    !emailPattern.test(email)
) {

                showAddClientFieldError(
                    'contact_email',
                    'Enter a valid email address.'
                )

                hasErrors = true
            }


            if (hasErrors) {
                return
            }


            const clientData = {

                name,

                type:
                    formData.get('type') || null,

                location:
                    formData.get('location') || null,

                description:
                    formData.get('description') || null,

                contact_name:
                    formData.get('contact_name') || null,

                contact_email:
                    email || null,

                accent_color:
                    formData.get('accent_color'),
            }


            addClientSubmit.disabled =
                true

            addClientSubmit.textContent =
                'Adding...'


            try {

                const response =
                    await fetch(
                        '/clients',
                        {
                            method: 'POST',

                            headers: {
                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },

                            body:
                                JSON.stringify(
                                    clientData
                                ),
                        }
                    )


                const data =
                    await response.json()


                if (!response.ok) {

                    if (data.errors) {

                        Object.entries(
                            data.errors
                        ).forEach(
                            ([field, messages]) => {

                                showAddClientFieldError(
                                    field,
                                    messages[0]
                                )
                            }
                        )

                        return
                    }


                    throw new Error(
                        data.message ||
                        'Could not create client.'
                    )
                }


                addClientSubmit.textContent =
                    'Added ✓'


                setTimeout(
                    () => {

                        window.location.href =
                            `/?client=${encodeURIComponent(
                                data.client.slug
                            )}`

                    },
                    350
                )


            } catch (error) {

                console.error(error)


                if (addClientError) {

                    addClientError.textContent =
                        error.message

                    addClientError.hidden =
                        false
                }


            } finally {

                addClientSubmit.disabled =
                    false


                if (
                    addClientSubmit.textContent !==
                    'Added ✓'
                ) {

                    addClientSubmit.textContent =
                        'Add client'
                }
            }
        }
    )

    addClientForm
    ?.querySelectorAll(
        'input, select, textarea'
    )
    .forEach(
        (field) => {

            field.addEventListener(
                'input',
                () => {

                    field.classList.remove(
                        'is-invalid'
                    )


                    const errorElement =
                        document.querySelector(
                            `[data-add-client-field-error="${field.name}"]`
                        )


                    if (errorElement) {

                        errorElement.hidden =
                            true

                        errorElement.textContent =
                            ''
                    }
                }
            )
        }
    )

    const interactivePanels = [
    drawer,
    newProjectModal,
    ]


/* =========================================================
   ESCAPE KEY
   ========================================================= */

document.addEventListener(
    'keydown',
    (event) => {

        if (
            event.key ===
            'Escape'
        ) {

            closeDrawer()

            closeNewProjectModal()

            closeClientModal()

            closeArchiveModal()

            closeEditClientModal()
        }
    }
)


/* =========================================================
   CLIENTBOARD MASCOT EYES
   ========================================================= */

const mascot =
    document.querySelector(
        '[data-brand-mascot]'
    )


if (mascot) {

    const eyes =
        mascot.querySelectorAll(
            '.mascot-eye'
        )


    window.addEventListener(
        'mousemove',
        (event) => {

            eyes.forEach(
                (eye) => {

                    const pupil =
                        eye.querySelector(
                            '.mascot-pupil'
                        )


                    if (!pupil) {
                        return
                    }


                    const rect =
                        eye
                            .getBoundingClientRect()


                    const centerX =
                        rect.left +
                        rect.width / 2


                    const centerY =
                        rect.top +
                        rect.height / 2


                    const angle =
                        Math.atan2(
                            event.clientY -
                                centerY,

                            event.clientX -
                                centerX
                        )


                    const distance =
                        2


                    const x =
                        Math.cos(
                            angle
                        ) *
                        distance


                    const y =
                        Math.sin(
                            angle
                        ) *
                        distance


                    pupil.style.transform =
                        `translate(${x}px, ${y}px)`
                }
            )
        }
    )


    document
        .documentElement
        .addEventListener(
            'mouseleave',
            () => {

                eyes.forEach(
                    (eye) => {

                        const pupil =
                            eye.querySelector(
                                '.mascot-pupil'
                            )


                        if (pupil) {

                            pupil
                                .style
                                .transform =
                                'translate(0, 0)'
                        }
                    }
                )
            }
        )
}

document
    .querySelectorAll(
        '[data-restore-project]'
    )
    .forEach((button) => {

        button.addEventListener(
            'click',
            async () => {

                const projectId =
                    button.dataset
                        .restoreProject

                button.disabled =
                    true

                button.textContent =
                    'Restoring...'

                try {

                    const response =
                        await fetch(
                            `/projects/${projectId}/restore`,
                            {
                                method:
                                    'PATCH',

                                headers: {
                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,
                                },
                            }
                        )

                    if (!response.ok) {

                        throw new Error(
                            'Could not restore project.'
                        )
                    }

                    button.textContent =
                        'Restored ✓'

                    setTimeout(
                        () => {
                            window.location
                                .reload()
                        },
                        400
                    )

                } catch (error) {

                    console.error(
                        error
                    )

                    button.disabled =
                        false

                    button.textContent =
                        'Restore'

                    alert(
                        'Project could not be restored.'
                    )
                }
            }
        )
    })


document
    .querySelectorAll(
        '[data-delete-project]'
    )
    .forEach((button) => {

        let confirming =
            false


        button.addEventListener(
            'click',
            async () => {

                if (!confirming) {

                    confirming =
                        true

                    button.classList.add(
                        'is-confirming'
                    )

                    button.textContent =
                        'Delete forever?'

                    setTimeout(
                        () => {

                            confirming =
                                false

                            button
                                .classList
                                .remove(
                                    'is-confirming'
                                )

                            button.textContent =
                                'Delete'

                        },
                        3500
                    )

                    return
                }


                const projectId =
                    button.dataset
                        .deleteProject

                button.disabled =
                    true

                button.textContent =
                    'Deleting...'


                try {

                    const response =
                        await fetch(
                            `/projects/${projectId}`,
                            {
                                method:
                                    'DELETE',

                                headers: {
                                    'Accept':
                                        'application/json',

                                    'X-CSRF-TOKEN':
                                        csrfToken,
                                },
                            }
                        )


                    if (!response.ok) {

                        throw new Error(
                            'Could not delete project.'
                        )
                    }


                    window.location
                        .reload()

                } catch (error) {

                    console.error(
                        error
                    )

                    button.disabled =
                        false

                    confirming =
                        false

                    button.classList
                        .remove(
                            'is-confirming'
                        )

                    button.textContent =
                        'Delete'

                    alert(
                        'Project could not be deleted.'
                    )
                }
            }
        )
    })

/* =========================================================
   ARCHIVE PROJECT
   ========================================================= */

archiveProjectButton
    ?.addEventListener(
        'click',
        () => {

            if (archiveConfirm) {
                archiveConfirm.hidden =
                    false
            }

            archiveProjectButton.hidden =
                true
        }
    )


archiveCancelButton
    ?.addEventListener(
        'click',
        () => {

            if (archiveConfirm) {
                archiveConfirm.hidden =
                    true
            }

            if (archiveProjectButton) {
                archiveProjectButton.hidden =
                    false
            }
        }
    )


archiveConfirmButton
    ?.addEventListener(
        'click',
        async () => {

            if (!activeProjectCard) {
                return
            }


            const projectId =
                activeProjectCard
                    .dataset
                    .projectId


            archiveConfirmButton.disabled =
                true

            archiveConfirmButton.textContent =
                'Archiving...'


            try {

                const response =
                    await fetch(
                        `/projects/${projectId}/archive`,
                        {
                            method:
                                'PATCH',

                            headers: {
                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken,
                            },
                        }
                    )


                if (!response.ok) {

                    throw new Error(
                        'Could not archive project.'
                    )
                }


                archiveConfirmButton.textContent =
                    'Archived ✓'


                setTimeout(() => {

                    window.location.reload()

                }, 450)

            } catch (error) {

                console.error(
                    error
                )


                alert(
                    'Project could not be archived.'
                )


                archiveConfirmButton.disabled =
                    false

                archiveConfirmButton.textContent =
                    'Yes, archive'
            }
        }
    )

/* =========================================================
   DELETE CLIENT
   ========================================================= */

let deleteClientConfirmTimer =
    null


document.addEventListener(
    'click',
    async (event) => {

        const button =
            event.target.closest(
                '[data-delete-client]'
            )


        if (!button) {
            return
        }


        if (!editClientForm) {

            console.error(
                'Edit client form not found.'
            )

            return
        }


        const clientId =
            editClientForm
                .dataset
                .clientId


        if (!clientId) {

            console.error(
                'Client ID not found.'
            )

            return
        }


        /*
         * FIRST CLICK
         * Ask for confirmation
         */

        if (
            !button
                .classList
                .contains(
                    'is-confirming'
                )
        ) {

            button
                .classList
                .add(
                    'is-confirming'
                )


            button.textContent =
                'Delete forever?'


            clearTimeout(
                deleteClientConfirmTimer
            )


            deleteClientConfirmTimer =
                setTimeout(
                    () => {

                        button
                            .classList
                            .remove(
                                'is-confirming'
                            )


                        button.textContent =
                            'Delete client'

                    },
                    3500
                )


            return
        }


        /*
         * SECOND CLICK
         * Actually delete
         */

        clearTimeout(
            deleteClientConfirmTimer
        )


        button.disabled =
            true


        button.textContent =
            'Deleting...'


        try {

            const response =
                await fetch(
                    `/clients/${clientId}`,
                    {
                        method:
                            'DELETE',

                        headers: {
                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                csrfToken,
                        },
                    }
                )


            const data =
                await response.json()


            if (!response.ok) {

                throw new Error(
                    data.message ||
                    'Could not delete client.'
                )
            }


            button.textContent =
                'Deleted ✓'


            setTimeout(
                () => {

                    window.location.href =
                        '/'

                },
                350
            )


        } catch (error) {

            console.error(
                error
            )


            button.disabled =
                false


            button
                .classList
                .remove(
                    'is-confirming'
                )


            button.textContent =
                'Delete client'


            alert(
                error.message ||
                'Client could not be deleted.'
            )
        }
    }
)

/* =========================================================
   ACCESSIBILITY
   KEEP CLOSED PANELS OUT OF TAB ORDER
   ========================================================= */

const focusManagedPanels = [
    drawer,
    newProjectModal,
    clientModal,
    archiveModal,
    editClientModal,
].filter(Boolean)


function syncPanelAccessibility(panel) {

    const isOpen =
        panel.classList.contains(
            'is-open'
        )


    panel.inert =
        !isOpen


    panel.setAttribute(
        'aria-hidden',
        isOpen
            ? 'false'
            : 'true'
    )
}


focusManagedPanels.forEach(
    (panel) => {

        /*
         * Set the correct state immediately
         * when the page loads.
         */

        syncPanelAccessibility(
            panel
        )


        /*
         * Watch for our existing JS adding
         * or removing the is-open class.
         */

        const observer =
            new MutationObserver(
                () => {

                    syncPanelAccessibility(
                        panel
                    )
                }
            )


        observer.observe(
            panel,
            {
                attributes:
                    true,

                attributeFilter: [
                    'class',
                ],
            }
        )
    }
)