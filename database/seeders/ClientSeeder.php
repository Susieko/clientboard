<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $noordgroeit = Client::updateOrCreate(
            ['slug' => 'noordgroeit'],
            [
                'name' => 'NoordgroeiT',
                'type' => 'Non-profit',
                'location' => 'Tilburg-Noord',
                'description' => 'A non-profit growing its online home: a warm, easy-to-use website for visitors, volunteers and local initiatives.',
                'contact_name' => null,
                'contact_email' => null,
                'accent_color' => '#78A56D',
            ]
        );

        $ehbo = Client::updateOrCreate(
            ['slug' => 'ehbo'],
            [
                'name' => 'EHBO',
                'type' => 'Association',
                'location' => 'Tilburg',
                'description' => 'A long-running first aid association with courses, lesson schedules, event support and member information.',
                'contact_name' => 'Cees',
                'contact_email' => null,
                'accent_color' => '#D96767',
            ]
        );

        $eaa = Client::updateOrCreate(
            ['slug' => 'eaa'],
            [
                'name' => 'EAA',
                'type' => 'Initiative',
                'location' => 'Tilburg',
                'description' => 'A local energy initiative focused on neighbourhood energy storage, grid capacity and clear resident communication.',
                'contact_name' => 'Jan',
                'contact_email' => null,
                'accent_color' => '#D6A93E',
            ]
        );
    }
}