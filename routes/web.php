<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard', [
        'waitingForFeedback' => 2,
        'activeProjects' => 5,
        'clientCount' => 3,

        'clients' => [
            [
                'name' => 'NoordgroeiT',
                'slug' => 'noordgroeit',
            ],
            [
                'name' => 'EHBO',
                'slug' => 'ehbo',
            ],
            [
                'name' => 'EAA',
                'slug' => 'eaa',
            ],
        ],

        'selectedClient' => [
    'name' => 'NoordgroeiT',
    'type' => 'Foundation',
    'location' => 'Tilburg-Noord',
    'activeProjects' => 2,
    'status' => 'Active',
],
    ]);
});