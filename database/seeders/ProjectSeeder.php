<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::create([
            'title' => 'NoordgroeiT website',
            'client' => 'NoordgroeiT',
            'status' => 'development',
            'deadline' => '2026-09-30',
            'progress' => 72,
        ]);

        Project::create([
            'title' => 'EHBO website',
            'client' => 'EHBO',
            'status' => 'feedback',
            'deadline' => '2026-09-26',
            'progress' => 94,
        ]);

        Project::create([
            'title' => 'Initiatief EAA',
            'client' => 'EAA',
            'status' => 'design',
            'deadline' => '2026-10-10',
            'progress' => 28,
        ]);

        Project::create([
            'title' => 'Noordbuiten merge',
            'client' => 'NoordgroeiT',
            'status' => 'done',
            'deadline' => '2026-09-18',
            'progress' => 100,
        ]);
    }
}