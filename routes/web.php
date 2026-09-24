<?php

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


    $projects = [
        [
            'title' => 'NoordgroeiT website',
            'client' => 'NoordgroeiT',
            'status' => 'development',
            'deadline' => '30 Sep',
            'progress' => 72,
        ],
        [
            'title' => 'EHBO website',
            'client' => 'Petrus Donders',
            'status' => 'feedback',
            'deadline' => '26 Sep',
            'progress' => 94,
        ],
        [
            'title' => 'Initiatief EAA',
            'client' => 'EAA',
            'status' => 'design',
            'deadline' => '10 Oct',
            'progress' => 28,
        ],
        [
            'title' => 'Noordbuiten merge',
            'client' => 'NoordgroeiT',
            'status' => 'done',
            'deadline' => '18 Sep',
            'progress' => 100,
        ],
    ];

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