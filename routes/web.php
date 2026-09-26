<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProjectController;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;


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

    $projects = Project::with(['client', 'notes'])->get();

    $visibleProjects = $selectedClient
        ? $projects
            ->where('client_id', $selectedClient->id)
            ->values()
        : $projects;

/*
|--------------------------------------------------------------------------
| Next deadline
|--------------------------------------------------------------------------
*/

$nextDeadlineProject = $visibleProjects
    ->where('status', '!=', 'done')
    ->filter(function ($project) {
        if (!$project->deadline) {
            return false;
        }

        return Carbon::parse($project->deadline)
            ->startOfDay()
            ->gte(today());
    })
    ->sortBy(function ($project) {
        return Carbon::parse($project->deadline)
            ->startOfDay()
            ->timestamp;
    })
    ->first();


$nextDeadline = null;

if ($nextDeadlineProject) {

    $deadlineDate = Carbon::parse(
        $nextDeadlineProject->deadline
    )->startOfDay();

    $daysUntil = (int) today()
        ->diffInDays($deadlineDate);

    $nextDeadline = [
        'id' => $nextDeadlineProject->id,
        'title' => $nextDeadlineProject->title,
        'client' => $nextDeadlineProject->client?->name
            ?? 'No client',
        'date' => $deadlineDate->format('j M'),
        'days' => $daysUntil,
    ];
}
    /*
|--------------------------------------------------------------------------
| Selected client stats
|--------------------------------------------------------------------------
*/

$selectedClientStats = null;
$selectedClientInitials = null;

if ($selectedClient) {

    $clientProjects = $projects
        ->where('client_id', $selectedClient->id)
        ->values();

    $openClientProjects = $clientProjects
        ->where('status', '!=', 'done')
        ->values();


    $nextDeadlineProject = $openClientProjects
        ->filter(function ($project) {

            if (!$project->deadline) {
                return false;
            }

            return Carbon::parse($project->deadline)
                ->startOfDay()
                ->gte(today());

        })
        ->sortBy('deadline')
        ->first();


    $selectedClientStats = [
        'open_projects' => $openClientProjects->count(),

        'average_progress' => $clientProjects->isNotEmpty()
            ? (int) round($clientProjects->avg('progress'))
            : 0,

        'next_deadline' => $nextDeadlineProject
            ? Carbon::parse($nextDeadlineProject->deadline)
                ->format('j M')
            : null,
    ];


    /*
     * Create initials for the avatar.
     *
     * NoordgroeiT -> NO
     * EHBO        -> EH
     * Initiatief EAA -> IE
     */

    $nameParts = preg_split(
        '/\s+/',
        trim($selectedClient->name)
    );

    if (count($nameParts) === 1) {

        $selectedClientInitials =
            strtoupper(
                mb_substr(
                    $nameParts[0],
                    0,
                    2
                )
            );

    } else {

        $selectedClientInitials =
            strtoupper(
                mb_substr($nameParts[0], 0, 1)
                .
                mb_substr($nameParts[1], 0, 1)
            );

    }
}


    /*
    |--------------------------------------------------------------------------
    | Dashboard stats
    |--------------------------------------------------------------------------
    */

$waitingForFeedback = $visibleProjects
    ->where('status', 'feedback')
    ->count();

$activeProjects = $visibleProjects
    ->where('status', '!=', 'done')
    ->count();

$clientCount = $selectedClient
    ? 1
    : $clients->count();


    return view('dashboard', [
        'waitingForFeedback' => $waitingForFeedback,
        'activeProjects' => $activeProjects,
        'clientCount' => $clientCount,

        'clients' => $clients,
        'selectedClient' => $selectedClient,
        'selectedSlug' => $selectedSlug,

        'workflowColumns' => $workflowColumns,
        'projects' => $visibleProjects,
        'nextDeadline' => $nextDeadline,

        'selectedClientStats' => $selectedClientStats,
'selectedClientInitials' => $selectedClientInitials,
    ]);
});


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

Route::post(
    '/projects/{project}/notes',
    [NoteController::class, 'store']
)->name('projects.notes.store');