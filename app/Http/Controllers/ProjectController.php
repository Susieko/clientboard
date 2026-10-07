<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'client_id' => [
                'required',
                'exists:clients,id',
            ],
            'status' => [
                'required',
                'in:design,development,feedback,done',
            ],
            'deadline' => [
                'nullable',
                'date',
            ],
            'progress' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ]);

        $project = Project::create($validated);

        $project->load('client');

        return response()->json([
            'success' => true,
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'status' => $project->status,
                'deadline' => $project->deadline,
                'progress' => $project->progress,
                'client' => [
                    'id' => $project->client->id,
                    'name' => $project->client->name,
                    'slug' => $project->client->slug,
                ],
            ],
        ]);
    }

    public function updateProgress(
        Request $request,
        Project $project
    ) {
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

    public function updateStatus(
        Request $request,
        Project $project
    ) {
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

    public function updateDeadline(
        Request $request,
        Project $project
    ) {
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

    public function updateClient(
        Request $request,
        Project $project
    ) {
        $validated = $request->validate([
            'client_id' => [
                'required',
                'exists:clients,id',
            ],
        ]);

        $project->update([
            'client_id' => $validated['client_id'],
        ]);

        return response()->json([
            'success' => true,
            'client_id' => $project->client_id,
        ]);
    }

    public function updateTitle(
        Request $request,
        Project $project
    ) {
        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $project->update([
            'title' => $validated['title'],
        ]);

        return response()->json([
            'success' => true,
            'title' => $project->title,
        ]);
    }

    public function archive(Project $project)
    {
        $project->update([
            'archived_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'archived_at' => $project->archived_at,
        ]);
    }

    public function restore(Project $project)
    {
        $project->update([
            'archived_at' => null,
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroy(Project $project)
    {
        if (! $project->archived_at) {
            return response()->json([
                'success' => false,
                'message' => 'Only archived projects can be permanently deleted.',
            ], 422);
        }

        $project->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
