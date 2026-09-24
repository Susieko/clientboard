<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $noordgroeit = Client::where('slug', 'noordgroeit')->firstOrFail();
        $ehbo = Client::where('slug', 'ehbo')->firstOrFail();
        $eaa = Client::where('slug', 'eaa')->firstOrFail();

        Project::updateOrCreate(
            ['title' => 'NoordgroeiT website'],
            [
                'client_id' => $noordgroeit->id,
                'status' => 'development',
                'deadline' => '2026-09-30',
                'progress' => 72,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'EHBO website'],
            [
                'client_id' => $ehbo->id,
                'status' => 'feedback',
                'deadline' => '2026-09-26',
                'progress' => 94,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'Initiatief EAA'],
            [
                'client_id' => $eaa->id,
                'status' => 'design',
                'deadline' => '2026-10-10',
                'progress' => 28,
            ]
        );

        Project::updateOrCreate(
            ['title' => 'Noordbuiten merge'],
            [
                'client_id' => $noordgroeit->id,
                'status' => 'done',
                'deadline' => '2026-09-18',
                'progress' => 100,
            ]
        );
    }
}