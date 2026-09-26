<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'type' => [
                'nullable',
                'string',
                'max:100',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'contact_name' => [
                'nullable',
                'string',
                'max:255',
            ],

            'contact_email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'accent_color' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
        ]);

        $baseSlug = Str::slug($validated['name']);

        $slug = $baseSlug;
        $number = 2;

        while (
            Client::where('slug', $slug)->exists()
        ) {
            $slug = $baseSlug . '-' . $number;
            $number++;
        }

        $client = Client::create([
            ...$validated,

            'slug' => $slug,

            'accent_color' =>
                $validated['accent_color']
                ?? '#d4a526',
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
}