<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function store(ClientRequest $request)
    {
        $validated = $request->validated();

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $number = 2;

        while (Client::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $number;
            $number++;
        }

        $client = Client::create([
            ...$validated,
            'slug' => $slug,
            'accent_color' => $validated['accent_color'] ?? '#d4a526',
        ]);

        return response()->json([
            'success' => true,
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'slug' => $client->slug,
            ],
        ]);
    }

    public function update(
        ClientRequest $request,
        Client $client
    ) {
        $validated = $request->validated();

        $client->update($validated);

        return response()->json([
            'success' => true,
            'client' => [
                'id' => $client->id,
                'name' => $client->name,
                'slug' => $client->slug,
                'type' => $client->type,
                'location' => $client->location,
                'description' => $client->description,
                'contact_name' => $client->contact_name,
                'contact_email' => $client->contact_email,
                'accent_color' => $client->accent_color,
            ],
        ]);
    }

    public function destroy(Client $client)
    {
        if ($client->projects()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This client still has projects and cannot be deleted.',
            ], 422);
        }

        $client->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}