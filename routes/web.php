<?php

use App\Http\Controllers\ProjectController;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $clients = [
        [
            'name' => 'NoordgroeiT',
            'slug' => 'noordgroeit',
            'type' => 'Non-profit',
            'location' => 'Tilburg-Noord',
            'activeProjects' => 2,
            'status' => 'Active',
        ],
        [
            'name' => 'EHBO',
            'slug' => 'ehbo',
            'type' => 'Association',
            'location' => 'Tilburg',
            'activeProjects' => 1,
            'status' => 'Active',
        ],
        [
            'name' => 'EAA',
            'slug' => 'eaa',
            'type' => 'Initiative',
            'location' => 'Tilburg',
            'activeProjects' => 1,
            'status' => 'Planning',
        ],
    ];

    $selectedSlug = request('client');

    $selectedClient = collect($clients)
        ->firstWhere('slug', $selectedSlug);


    $workflowColumns = [
        [
            'key' => 'design',
            'label' => 'Design',
        ],
        [
            'key' => 'development',
            'label' => 'Development',
        ],
        [
            'key' => 'feedback',
            'label' => 'Waiting for feedback',
        ],
        [
            'key' => 'done',
            'label' => 'Done',
        ],
    ];

    Route::patch(
    '/projects/{project}/progress',
    [ProjectController::class, 'updateProgress']
)->name('projects.progress.update');

$projects = Project::all();

    $visibleProjects = $selectedSlug
    ? collect($projects)
        ->filter(function ($project) use ($selectedClient) {
            return $selectedClient
                && $project['client'] === $selectedClient['name'];
        })
        ->values()
        ->all()
    : $projects;


    return view('dashboard', [
        'waitingForFeedback' => 2,
        'activeProjects' => 5,
        'clientCount' => count($clients),

        'clients' => $clients,
        'selectedClient' => $selectedClient,
        'selectedSlug' => $selectedSlug,

        'workflowColumns' => $workflowColumns,
        'projects' => $visibleProjects,
    ]);
});