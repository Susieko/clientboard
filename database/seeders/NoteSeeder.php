<?php

namespace Database\Seeders;

use App\Models\Note;
use App\Models\Project;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        $noordgroeit = Project::where(
            'title',
            'NoordgroeiT website'
        )->firstOrFail();

        $ehbo = Project::where(
            'title',
            'EHBO website'
        )->firstOrFail();

        $eaa = Project::where(
            'title',
            'Initiatief EAA'
        )->firstOrFail();


        Note::updateOrCreate(
            [
                'project_id' => $noordgroeit->id,
                'content' => 'Improve the WordPress structure and reduce hard-coded content.',
            ]
        );

        Note::updateOrCreate(
            [
                'project_id' => $noordgroeit->id,
                'content' => 'Review mobile responsiveness and final visual polish.',
            ]
        );


        Note::updateOrCreate(
            [
                'project_id' => $ehbo->id,
                'content' => 'Update the lesson schedule links.',
            ]
        );

        Note::updateOrCreate(
            [
                'project_id' => $ehbo->id,
                'content' => 'Add the lesson schedule reference to the stamp card page.',
            ]
        );

        Note::updateOrCreate(
            [
                'project_id' => $ehbo->id,
                'content' => 'Replace the requested photos and check final client feedback.',
            ]
        );


        Note::updateOrCreate(
            [
                'project_id' => $eaa->id,
                'content' => 'Define the website scope and project budget.',
            ]
        );
    }
}