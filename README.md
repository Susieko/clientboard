# Clientboard

A playful client and project management dashboard built with Laravel.

Clientboard started as a learning project to deepen my knowledge of PHP, Laravel and full-stack development while keeping the interface visually creative. Instead of building a standard admin dashboard, I wanted to create a small workspace for managing clients, projects, progress and deadlines with a more distinctive UI.

## Preview

![Clientboard dashboard](./docs/images/dashboard.png)

### Project management

![Clientboard project detail drawer](./docs/images/project-drawer.png)

### Responsive design

![Clientboard mobile view](./docs/images/mobile.png)

## Features

- Client management
- Create, edit and delete clients
- Project creation and editing
- Project cards with status and progress
- Project detail drawer
- Editable deadlines
- Project archive and restore flow
- Permanent deletion protection for active projects
- Notes per project
- Client filtering
- Dashboard statistics
- Next-deadline overview
- Responsive dashboard layout
- Interactive UI states
- Custom animated landscape interface
- Form validation and database persistence

## Built with

- Laravel
- PHP
- Blade
- JavaScript
- Tailwind CSS
- MySQL
- Vite
- Git

## Architecture

Clientboard follows Laravel's MVC structure.

### Models

The application uses Eloquent models for clients, projects and notes.

Relationships include:

- A client has many projects
- A project belongs to a client
- A project has many notes
- A note belongs to a project

### Controllers

Application logic is separated into dedicated controllers:

- `DashboardController`
- `ClientController`
- `ProjectController`
- `NoteController`

Dashboard logic is handled by `DashboardController`, keeping `routes/web.php` focused on routing rather than queries and presentation logic.

### Validation

Client validation is handled through a dedicated Laravel Form Request.

This keeps validation rules outside the controller and gives the controller a clearer responsibility.

Project actions also validate incoming data before updating the database.

### Project workflow

Project statuses are centralized using a PHP enum:

- Design
- Development
- Waiting for feedback
- Done

This avoids repeating status values throughout the application and creates a single source of truth for the project workflow.

## Maintainability

While developing Clientboard, I focused increasingly on keeping the code structured and maintainable.

Some examples include:

- Separating dashboard logic from route definitions
- Using controllers for application logic
- Using Form Requests for validation
- Using Eloquent relationships instead of manually connecting records
- Centralizing workflow states with a PHP enum
- Keeping routes focused on mapping URLs to controller actions
- Using small, focused Git commits while refactoring

The project is still intentionally a learning project, but it has also been used to practice applying MVC and SOLID principles in a real Laravel application.

## What I learned

Clientboard was my first larger Laravel application.

During the project I worked with:

- Laravel routing
- MVC architecture
- Controllers and request handling
- Laravel Form Requests
- Blade templates
- Database migrations
- Eloquent models and relationships
- PHP enums
- CRUD operations
- Form validation
- JSON responses
- Connecting front-end interactions to backend functionality
- Organising a larger application into clearer responsibilities
- Refactoring existing code for maintainability
- Git and incremental commits

Coming from mainly WordPress and front-end development, Clientboard helped me better understand how a modern PHP framework structures an application and how the different layers of an application work together.

## Local setup

Clone the repository and install the PHP dependencies:

```bash
composer install
```

Install the front-end dependencies:

```bash
npm install
```

On Windows PowerShell, use `npm.cmd install` if script execution blocks `npm.ps1`.

Create your local environment file and application key:

```bash
cp .env.example .env
php artisan key:generate
```

Configure the database connection in `.env`, then run the migrations:

```bash
php artisan migrate
```

Start the Laravel development server:

```bash
php artisan serve
```

In a second terminal, start Vite:

```bash
npm run dev
```

On Windows PowerShell, `npm.cmd run dev` can be used instead.

## Testing and build

Run the test suite:

```bash
php artisan test
```

Create a production front-end build:

```bash
npm run build
```

On Windows PowerShell, use `npm.cmd run build` if needed.

## Project status

Clientboard is a learning and portfolio project. The core client and project management flows are functional, and I continue to use the project to practise Laravel architecture, maintainability and full-stack development.
