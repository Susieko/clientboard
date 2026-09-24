const projectCards = document.querySelectorAll('[data-project-card]')

const drawer = document.querySelector('[data-project-drawer]')
const backdrop = document.querySelector('[data-drawer-backdrop]')
const closeButton = document.querySelector('[data-drawer-close]')

const drawerTitle = document.querySelector('[data-drawer-title]')
const drawerClient = document.querySelector('[data-drawer-client]')
const drawerDeadline = document.querySelector('[data-drawer-deadline]')

const statusButtons = document.querySelectorAll('[data-status-button]')

const progressSlider = document.querySelector(
    '[data-drawer-progress-slider]'
)

const progressLabel = document.querySelector(
    '[data-drawer-progress-label]'
)

let activeProjectCard = null


function openDrawer(card) {
    activeProjectCard = card

    const title = card.dataset.projectTitle
    const client = card.dataset.projectClient
    const status = card.dataset.projectStatus
    const deadline = card.dataset.projectDeadline
    const progress = card.dataset.projectProgress


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


    /* Open drawer */

    drawer?.classList.add('is-open')
    backdrop?.classList.add('is-open')

    drawer?.setAttribute('aria-hidden', 'false')
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