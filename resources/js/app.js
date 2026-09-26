const projectCards = document.querySelectorAll('[data-project-card]')

const drawer = document.querySelector('[data-project-drawer]')
const backdrop = document.querySelector('[data-drawer-backdrop]')
const closeButton = document.querySelector('[data-drawer-close]')

const drawerTitle = document.querySelector('[data-drawer-title]')
const drawerClient = document.querySelector('[data-drawer-client]')
const drawerDeadline = document.querySelector('[data-drawer-deadline]')
const drawerNotes = document.querySelector('[data-drawer-notes]')

const statusButtons = document.querySelectorAll('[data-status-button]')

const drawerClientCard = document.querySelector(
    '[data-drawer-client-card]'
)

const drawerClientAvatar = document.querySelector(
    '[data-drawer-client-avatar]'
)

const drawerClientName = document.querySelector(
    '[data-drawer-client-name]'
)

const drawerClientType = document.querySelector(
    '[data-drawer-client-type]'
)

const drawerClientLocation = document.querySelector(
    '[data-drawer-client-location]'
)

const drawerClientDescription = document.querySelector(
    '[data-drawer-client-description]'
)

const drawerClientContact = document.querySelector(
    '[data-drawer-client-contact]'
)

const drawerClientEmail = document.querySelector(
    '[data-drawer-client-email]'
)

const drawerClientContactRow = document.querySelector(
    '[data-drawer-client-contact-row]'
)

const progressSlider = document.querySelector(
    '[data-drawer-progress-slider]'
)

const progressLabel = document.querySelector(
    '[data-drawer-progress-label]'
)

const noteInput = document.querySelector('[data-note-input]')
const noteAddButton = document.querySelector('[data-note-add]')

const csrfToken = document.querySelector(
    'meta[name="csrf-token"]'
)?.content

let activeProjectCard = null


/* =========================================================
   OPEN PROJECT DRAWER
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

function openDrawer(card) {
    activeProjectCard = card

    const title = card.dataset.projectTitle
    const client = card.dataset.projectClient
    const clientType =
    card.dataset.projectClientType

const clientLocation =
    card.dataset.projectClientLocation

const clientDescription =
    card.dataset.projectClientDescription

const clientContact =
    card.dataset.projectClientContact

const clientEmail =
    card.dataset.projectClientEmail

const clientColor =
    card.dataset.projectClientColor
    const status = card.dataset.projectStatus
    const deadline = card.dataset.projectDeadline
    const progress = card.dataset.projectProgress

    const notes = JSON.parse(
        card.dataset.projectNotes || '[]'
    )


    /* Project info */

    /* Client details */

if (drawerClientName) {
    drawerClientName.textContent = client
}

if (drawerClientAvatar) {
    drawerClientAvatar.textContent =
        getClientInitials(client)

    drawerClientAvatar.style.background =
        clientColor
}

if (drawerClientType) {
    drawerClientType.textContent =
        clientType || 'Client'
}

if (drawerClientLocation) {
    drawerClientLocation.textContent =
        clientLocation || ''
}

if (drawerClientDescription) {
    drawerClientDescription.textContent =
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
        !clientContact && !clientEmail
}

if (drawerClientCard) {
    drawerClientCard.style.setProperty(
        '--client-accent',
        clientColor
    )
}

    if (drawerTitle) {
        drawerTitle.textContent = title
    }

    if (drawerClient) {
        drawerClient.textContent = client
    }

    if (drawerDeadline) {
        drawerDeadline.value = deadline || ''
    }


    /* Status */

    statusButtons.forEach((button) => {
        const isActive =
            button.dataset.statusButton === status

        button.classList.toggle(
            'is-active',
            isActive
        )
    })


    /* Progress */

    updateProgressUI(progress)


    /* Notes */

    if (drawerNotes) {
        drawerNotes.innerHTML = ''

        if (notes.length === 0) {
            drawerNotes.innerHTML = `
                <p class="drawer-notes__empty">
                    No notes yet.
                </p>
            `
        } else {
            notes.forEach((note) => {

                const item =
                    document.createElement('div')

                item.classList.add(
                    'drawer-note'
                )

                item.innerHTML = `
                    <span class="drawer-note__dot"></span>
                    <span></span>
                `

                item.querySelector(
                    'span:last-child'
                ).textContent = note

                drawerNotes.appendChild(item)
            })
        }
    }


    /* Clear note input */

    if (noteInput) {
        noteInput.value = ''
    }


    /* Open drawer */

    drawer?.classList.add('is-open')
    backdrop?.classList.add('is-open')

    drawer?.setAttribute(
        'aria-hidden',
        'false'
    )
}


/* =========================================================
   CLOSE PROJECT DRAWER
   ========================================================= */

function closeDrawer() {
    drawer?.classList.remove('is-open')
    backdrop?.classList.remove('is-open')

    drawer?.setAttribute(
        'aria-hidden',
        'true'
    )

    activeProjectCard = null
}


/* =========================================================
   PROJECT CARD EVENTS
   ========================================================= */

projectCards.forEach((card) => {

    card.addEventListener('click', () => {
        openDrawer(card)
    })


    card.addEventListener(
        'keydown',
        (event) => {

            if (
                event.key === 'Enter' ||
                event.key === ' '
            ) {
                event.preventDefault()

                openDrawer(card)
            }

        }
    )

})


/* =========================================================
   PROGRESS UI
   ========================================================= */

function updateProgressUI(value) {

    if (progressSlider) {

        progressSlider.value = value

        progressSlider.style.setProperty(
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
            activeProjectCard.querySelector(
                '.project-card__progress-info strong'
            )

        const cardBar =
            activeProjectCard.querySelector(
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


/* =========================================================
   PROGRESS SLIDER
   ========================================================= */

/*
 * Visual update while dragging.
 */
progressSlider?.addEventListener(
    'input',
    (event) => {

        updateProgressUI(
            event.target.value
        )

    }
)


/*
 * Save to Laravel when released.
 */
progressSlider?.addEventListener(
    'change',
    async (event) => {

        if (!activeProjectCard) {
            return
        }


        const projectId =
            activeProjectCard.dataset.projectId

        const previousProgress =
            activeProjectCard.dataset.projectProgress

        const newProgress =
            event.target.value


        progressSlider.disabled = true


        try {

            const response = await fetch(
                `/projects/${projectId}/progress`,
                {
                    method: 'PATCH',

                    headers: {
                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken,
                    },

                    body: JSON.stringify({
                        progress:
                            Number(newProgress),
                    }),
                }
            )


            if (!response.ok) {

                throw new Error(
                    'Could not save project progress.'
                )

            }


            const data =
                await response.json()

            const savedProgress =
                String(data.progress)


            activeProjectCard
                .dataset.projectProgress =
                savedProgress


            updateProgressUI(
                savedProgress
            )

        } catch (error) {

            console.error(error)


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

function updateColumnCounts() {

    document
        .querySelectorAll(
            '[data-status-column]'
        )
        .forEach((column) => {

            const count =
                column.querySelectorAll(
                    '.project-card'
                ).length

            const countElement =
                column.querySelector(
                    '.workflow-column__count'
                )


            if (countElement) {
                countElement.textContent =
                    count
            }

        })

}


statusButtons.forEach((button) => {

    button.addEventListener(
        'click',
        async () => {

            if (!activeProjectCard) {
                return
            }


            const projectId =
                activeProjectCard
                    .dataset.projectId

            const previousStatus =
                activeProjectCard
                    .dataset.projectStatus

            const newStatus =
                button.dataset.statusButton


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
                            method: 'PATCH',

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
                    await response.json()

                const savedStatus =
                    data.status


                /*
                 * Save new status
                 * on the card itself.
                 */

                activeProjectCard
                    .dataset.projectStatus =
                    savedStatus


                /*
                 * Update status buttons.
                 */

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


                /*
                 * Move project card
                 * to the new column.
                 */

                const targetColumn =
                    document.querySelector(
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

            } catch (error) {

                console.error(error)


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

})


/* =========================================================
   PROJECT DEADLINE
   ========================================================= */

drawerDeadline?.addEventListener(
    'change',
    async (event) => {

        if (!activeProjectCard) {
            return
        }


        const projectId =
            activeProjectCard.dataset.projectId

        const previousDeadline =
            activeProjectCard.dataset
                .projectDeadline

        const newDeadline =
            event.target.value


        drawerDeadline.disabled = true


        try {

            const response = await fetch(
                `/projects/${projectId}/deadline`,
                {
                    method: 'PATCH',

                    headers: {
                        'Content-Type':
                            'application/json',

                        'Accept':
                            'application/json',

                        'X-CSRF-TOKEN':
                            csrfToken,
                    },

                    body: JSON.stringify({
                        deadline:
                            newDeadline || null,
                    }),
                }
            )


            if (!response.ok) {

                throw new Error(
                    'Could not save project deadline.'
                )

            }


            const data =
                await response.json()

            const savedDeadline =
                data.deadline || ''


            /*
             * Save deadline
             * on project card.
             */

            activeProjectCard
                .dataset.projectDeadline =
                savedDeadline


            /*
             * Update visible deadline
             * on project card.
             */

            const cardDeadline =
                activeProjectCard
                    .querySelector(
                        '[data-card-deadline]'
                    )


            if (cardDeadline) {

                cardDeadline.textContent =
                    savedDeadline ||
                    'No deadline'

            }


            /*
             * Keep drawer synced.
             */

            drawerDeadline.value =
                savedDeadline

        } catch (error) {

            console.error(error)


            drawerDeadline.value =
                previousDeadline || ''


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
   ADD NOTE
   ========================================================= */

noteAddButton?.addEventListener(
    'click',
    async () => {

        if (
            !activeProjectCard ||
            !noteInput
        ) {
            return
        }


        const content =
            noteInput.value.trim()


        if (!content) {
            return
        }


        const projectId =
            activeProjectCard
                .dataset.projectId


        noteAddButton.disabled = true
        noteAddButton.textContent =
            'Adding...'


        try {

            const response =
                await fetch(
                    `/projects/${projectId}/notes`,
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
                await response.json()


            /*
             * Create note
             * in drawer.
             */

            const noteElement =
                document
                    .createElement('div')

            noteElement
                .classList
                .add('drawer-note')


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


            /*
             * Remove empty state.
             */

            drawerNotes
                ?.querySelector(
                    '.drawer-notes__empty'
                )
                ?.remove()


            drawerNotes?.appendChild(
                noteElement
            )


            /*
             * Update stored notes
             * on project card.
             */

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
                .dataset.projectNotes =
                JSON.stringify(
                    existingNotes
                )


            /*
             * Reset input.
             */

            noteInput.value = ''
            noteInput.focus()

        } catch (error) {

            console.error(error)


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


/* Add note using Enter */

noteInput?.addEventListener(
    'keydown',
    (event) => {

        if (event.key === 'Enter') {

            event.preventDefault()

            noteAddButton?.click()

        }

    }
)


/* =========================================================
   DRAWER CLOSE EVENTS
   ========================================================= */

closeButton?.addEventListener(
    'click',
    closeDrawer
)


backdrop?.addEventListener(
    'click',
    closeDrawer
)


document.addEventListener(
    'keydown',
    (event) => {

        if (event.key === 'Escape') {
            closeDrawer()
        }

    }
)

/* =========================================================
   NEXT DEADLINE WIDGET
   ========================================================= */

const deadlineWidget =
    document.querySelector(
        '[data-deadline-project]'
    )


deadlineWidget?.addEventListener(
    'click',
    () => {

        const projectId =
            deadlineWidget.dataset
                .deadlineProject

        const projectCard =
            document.querySelector(
                `[data-project-card][data-project-id="${projectId}"]`
            )


        if (projectCard) {
            openDrawer(projectCard)
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

            eyes.forEach((eye) => {

                const pupil =
                    eye.querySelector(
                        '.mascot-pupil'
                    )


                if (!pupil) {
                    return
                }


                const rect =
                    eye.getBoundingClientRect()

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


                const distance = 2

                const x =
                    Math.cos(angle) *
                    distance

                const y =
                    Math.sin(angle) *
                    distance


                pupil.style.transform =
                    `translate(${x}px, ${y}px)`

            })

        }
    )


    document.documentElement
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

                            pupil.style
                                .transform =
                                'translate(0, 0)'

                        }

                    }
                )

            }
        )
}