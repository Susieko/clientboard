<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $validated = $request->validate([
            'content' => [
                'required',
                'string',
                'max:500',
            ],
        ]);

        $note = $project->notes()->create([
            'content' => $validated['content'],
        ]);

        return response()->json([
            'success' => true,
            'note' => [
                'id' => $note->id,
                'content' => $note->content,
            ],
        ]);
    }
}