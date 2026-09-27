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
                'regex:/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/',
            ],

            'accent_color' => [
                'nullable',
                'regex:/^#[0-9A-Fa-f]{6}$/',
            ],
        ]);


        $baseSlug =
            Str::slug(
                $validated['name']
            );


        $slug =
            $baseSlug;

        $number =
            2;


        while (
            Client::where(
                'slug',
                $slug
            )->exists()
        ) {

            $slug =
                $baseSlug .
                '-' .
                $number;

            $number++;
        }


        $client =
            Client::create([
                ...$validated,

                'slug' =>
                    $slug,

                'accent_color' =>
                    $validated['accent_color']
                    ?? '#d4a526',
            ]);


        return response()->json([
            'success' => true,

            'client' => [
                'id' =>
                    $client->id,

                'name' =>
                    $client->name,

                'slug' =>
                    $client->slug,
            ],
        ]);
    }


    public function update(
        Request $request,
        Client $client
    ) {

        $validated =
            $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'type' => [
                    'nullable',
                    'string',
                    'max:255',
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
                    'regex:/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/',
                ],

                'accent_color' => [
                    'nullable',
                    'regex:/^#[0-9A-Fa-f]{6}$/',
                ],
            ]);


        $client->update(
            $validated
        );


        return response()->json([
            'success' =>
                true,

            'client' => [
                'id' =>
                    $client->id,

                'name' =>
                    $client->name,

                'slug' =>
                    $client->slug,

                'type' =>
                    $client->type,

                'location' =>
                    $client->location,

                'description' =>
                    $client->description,

                'contact_name' =>
                    $client->contact_name,

                'contact_email' =>
                    $client->contact_email,

                'accent_color' =>
                    $client->accent_color,
            ],
        ]);
    }


    public function destroy(
        Client $client
    ) {

        if (
            $client
                ->projects()
                ->exists()
        ) {

            return response()->json([
                'success' =>
                    false,

                'message' =>
                    'This client still has projects and cannot be deleted.',
            ], 422);
        }


        $client->delete();


        return response()->json([
            'success' =>
                true,
        ]);
    }
}