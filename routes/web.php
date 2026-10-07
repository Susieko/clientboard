<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get(
    '/',
    [DashboardController::class, 'index']
)->name('dashboard');


/*
|--------------------------------------------------------------------------
| Projects
|--------------------------------------------------------------------------
*/

Route::post(
    '/projects',
    [ProjectController::class, 'store']
)->name('projects.store');

Route::patch(
    '/projects/{project}/progress',
    [ProjectController::class, 'updateProgress']
)->name('projects.progress.update');

Route::patch(
    '/projects/{project}/status',
    [ProjectController::class, 'updateStatus']
)->name('projects.status.update');

Route::patch(
    '/projects/{project}/deadline',
    [ProjectController::class, 'updateDeadline']
)->name('projects.deadline.update');

Route::patch(
    '/projects/{project}/client',
    [ProjectController::class, 'updateClient']
)->name('projects.client.update');

Route::patch(
    '/projects/{project}/title',
    [ProjectController::class, 'updateTitle']
)->name('projects.title.update');

Route::patch(
    '/projects/{project}/archive',
    [ProjectController::class, 'archive']
)->name('projects.archive');

Route::patch(
    '/projects/{project}/restore',
    [ProjectController::class, 'restore']
)->name('projects.restore');

Route::delete(
    '/projects/{project}',
    [ProjectController::class, 'destroy']
)->name('projects.destroy');


/*
|--------------------------------------------------------------------------
| Project notes
|--------------------------------------------------------------------------
*/

Route::post(
    '/projects/{project}/notes',
    [NoteController::class, 'store']
)->name('projects.notes.store');


/*
|--------------------------------------------------------------------------
| Clients
|--------------------------------------------------------------------------
*/

Route::post(
    '/clients',
    [ClientController::class, 'store']
)->name('clients.store');

Route::patch(
    '/clients/{client}',
    [ClientController::class, 'update']
)->name('clients.update');

Route::delete(
    '/clients/{client}',
    [ClientController::class, 'destroy']
)->name('clients.destroy');