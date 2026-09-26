const projectCards = document.querySelectorAll('[data-project-card]')

const drawer = document.querySelector('[data-project-drawer]')
const backdrop = document.querySelector('[data-drawer-backdrop]')
const closeButton = document.querySelector('[data-drawer-close]')

const drawerTitle = document.querySelector('[data-drawer-title]')
const drawerClient = document.querySelector('[data-drawer-client]')
const drawerDeadline = document.querySelector('[data-drawer-deadline]')
const drawerNotes = document.querySelector('[data-drawer-notes]')

const statusButtons = document.querySelectorAll('[data-status-button]')

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


function openDrawer(card) {
    activeProjectCard = card

    const title = card.dataset.projectTitle
    const client = card.dataset.projectClient
    const status = card.dataset.projectStatus
    const deadline = card.dataset.projectDeadline
    const progress = card.dataset.projectProgress
    const notes = JSON.parse(
    card.dataset.projectNotes || '[]'
)


    /* Project info */

    if (drawerTitle) {
        drawerTitle.textContent = title
    }

    if (drawerClient) {
        drawerClient.textContent = client
    }

    if (drawerDeadline) {
        drawerDeadline.textContent = deadline
    }


    /* Status */

    statusButtons.forEach((button) => {
        const isActive =
            button.dataset.statusButton === status

        button.classList.toggle('is-active', isActive)
    })


    /* Progress */

    if (progressSlider) {
        progressSlider.value = progress

        progressSlider.style.setProperty(
            '--progress',
            `${progress}%`
        )
    }

    if (progressLabel) {
        progressLabel.textContent = `${progress}%`
    }

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
            const item = document.createElement('div')

            item.classList.add('drawer-note')

            item.innerHTML = `
                <span class="drawer-note__dot"></span>
                <span></span>
            `

            item.querySelector('span:last-child').textContent = note

            drawerNotes.appendChild(item)
        })
    }
}

    /* Open drawer */

    drawer?.classList.add('is-open')
    backdrop?.classList.add('is-open')

    drawer?.setAttribute('aria-hidden', 'false')

    /* =========================================================
   ADD NOTE
   ========================================================= */

noteAddButton?.addEventListener('click', async () => {
    if (!activeProjectCard || !noteInput) {
        return
    }

    const content = noteInput.value.trim()

    if (!content) {
        return
    }

    const projectId = activeProjectCard.dataset.projectId

    noteAddButton.disabled = true
    noteAddButton.textContent = 'Adding...'

    try {
        const response = await fetch(
            `/projects/${projectId}/notes`,
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },

                body: JSON.stringify({
                    content: content,
                }),
            }
        )

        if (!response.ok) {
            throw new Error('Could not save note.')
        }

        const data = await response.json()


        /* Add note visually to drawer */

        const noteElement = document.createElement('div')

        noteElement.classList.add('drawer-note')

        noteElement.innerHTML = `
            <span class="drawer-note__dot"></span>
            <span></span>
        `

        noteElement.querySelector(
            'span:last-child'
        ).textContent = data.note.content


        /* Remove "No notes yet" if present */

        drawerNotes
            ?.querySelector('.drawer-notes__empty')
            ?.remove()


        drawerNotes?.appendChild(noteElement)


        /* Update card's stored notes */

        const existingNotes = JSON.parse(
            activeProjectCard.dataset.projectNotes || '[]'
        )

        existingNotes.push(data.note.content)

        activeProjectCard.dataset.projectNotes =
            JSON.stringify(existingNotes)


        /* Reset input */

        noteInput.value = ''
        noteInput.focus()

    } catch (error) {
        console.error(error)

        alert('The note could not be saved.')
    } finally {
        noteAddButton.disabled = false
        noteAddButton.textContent = 'Add'
    }
})

noteInput?.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        event.preventDefault()
        noteAddButton?.click()
    }
})
}


function closeDrawer() {
    drawer?.classList.remove('is-open')
    backdrop?.classList.remove('is-open')

    drawer?.setAttribute('aria-hidden', 'true')

    activeProjectCard = null
}


/* =========================================================
   PROJECT CARD EVENTS
   ========================================================= */

projectCards.forEach((card) => {

    card.addEventListener('click', () => {
        openDrawer(card)
    })

    card.addEventListener('keydown', (event) => {

        if (
            event.key === 'Enter' ||
            event.key === ' '
        ) {
            event.preventDefault()

            openDrawer(card)
        }

    })

})


/* =========================================================
   PROGRESS SLIDER
   ========================================================= */

progressSlider?.addEventListener('input', (event) => {

    const value = event.target.value


    /* Slider */

    event.target.style.setProperty(
        '--progress',
        `${value}%`
    )


    /* Drawer label */

    if (progressLabel) {
        progressLabel.textContent = `${value}%`
    }


    /* Project card */

    if (activeProjectCard) {

        activeProjectCard.dataset.projectProgress = value


        const cardLabel =
            activeProjectCard.querySelector(
                '.project-card__progress-info strong'
            )

        const cardBar =
            activeProjectCard.querySelector(
                '.progress-track span'
            )


        if (cardLabel) {
            cardLabel.textContent = `${value}%`
        }

        if (cardBar) {
            cardBar.style.width = `${value}%`
        }

    }

})


/* =========================================================
   CLOSE DRAWER
   ========================================================= */

closeButton?.addEventListener(
    'click',
    closeDrawer
)

backdrop?.addEventListener(
    'click',
    closeDrawer
)

document.addEventListener('keydown', (event) => {

    if (event.key === 'Escape') {
        closeDrawer()
    }

})

/* =========================================================
   CLIENTBOARD MASCOT EYES
   ========================================================= */

const mascot = document.querySelector('[data-brand-mascot]')

if (mascot) {
    const eyes = mascot.querySelectorAll('.mascot-eye')

    window.addEventListener('mousemove', (event) => {

        eyes.forEach((eye) => {
            const pupil = eye.querySelector('.mascot-pupil')

            const rect = eye.getBoundingClientRect()

            const centerX = rect.left + rect.width / 2
            const centerY = rect.top + rect.height / 2

            const angle = Math.atan2(
                event.clientY - centerY,
                event.clientX - centerX
            )

            const distance = 2

            const x = Math.cos(angle) * distance
            const y = Math.sin(angle) * distance

            pupil.style.transform =
                `translate(${x}px, ${y}px)`
        })

    })

    document.documentElement.addEventListener('mouseleave', () => {
        eyes.forEach((eye) => {
            const pupil = eye.querySelector('.mascot-pupil')

            pupil.style.transform = 'translate(0, 0)'
        })
    })
}