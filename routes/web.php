<?php

use App\Http\Controllers\ProjectController;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    /*
    |--------------------------------------------------------------------------
    | Clients
    |--------------------------------------------------------------------------
    */

    $clients = Client::orderBy('name')->get();

    $selectedSlug = request('client');

    $selectedClient = $selectedSlug
        ? $clients->firstWhere('slug', $selectedSlug)
        : null;


    /*
    |--------------------------------------------------------------------------
    | Workflow
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | Projects
    |--------------------------------------------------------------------------
    */

    $projects = Project::with('client')->get();

    $visibleProjects = $selectedClient
        ? $projects
            ->where('client_id', $selectedClient->id)
            ->values()
        : $projects;


    /*
    |--------------------------------------------------------------------------
    | Dashboard stats
    |--------------------------------------------------------------------------
    */

    $waitingForFeedback = $projects
        ->where('status', 'feedback')
        ->count();

    $activeProjects = $projects
        ->where('status', '!=', 'done')
        ->count();

    $clientCount = $clients->count();


    return view('dashboard', [
        'waitingForFeedback' => $waitingForFeedback,
        'activeProjects' => $activeProjects,
        'clientCount' => $clientCount,

        'clients' => $clients,
        'selectedClient' => $selectedClient,
        'selectedSlug' => $selectedSlug,

        'workflowColumns' => $workflowColumns,
        'projects' => $visibleProjects,
    ]);
});


Route::patch(
    '/projects/{project}/progress',
    [ProjectController::class, 'updateProgress']
)->name('projects.progress.update');