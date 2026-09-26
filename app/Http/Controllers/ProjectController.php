<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function updateProgress(Request $request, Project $project)
    {
        $validated = $request->validate([
            'progress' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ]);

        $project->update([
            'progress' => $validated['progress'],
        ]);

        return response()->json([
            'success' => true,
            'progress' => $project->progress,
        ]);
    }

    public function updateStatus(Request $request, Project $project)
{
    $validated = $request->validate([
        'status' => [
            'required',
            'string',
            'in:design,development,feedback,done',
        ],
    ]);

    $project->update([
        'status' => $validated['status'],
    ]);

    return response()->json([
        'success' => true,
        'status' => $project->status,
    ]);
}

public function updateDeadline(Request $request, Project $project)
{
    $validated = $request->validate([
        'deadline' => [
            'nullable',
            'date',
        ],
    ]);

    $project->update([
        'deadline' => $validated['deadline'],
    ]);

    return response()->json([
        'success' => true,
        'deadline' => $project->deadline,
    ]);
}
}