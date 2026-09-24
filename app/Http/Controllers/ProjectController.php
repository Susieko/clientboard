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
}