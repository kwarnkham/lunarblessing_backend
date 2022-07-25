<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feature;
use App\Models\Item;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $signs = [
            [
                'name' => 'Aries',
                'description' => 'The Ram ♈︎. Sun Sign Dates from March 21st to April 19th. Positive polarity. Cardinal modality. Triplicity, Fire.',
            ],
            [
                'name' => 'Taurus',
                'description' => 'The Bull ♉︎. Sun Sign Dates from April 20th to May 20th. Negative polarity. Fixed modality. Triplicity, Earth.',

            ]
        ];

        foreach ($signs as $sign)
            Item::factory([
                'name' => $sign['name'],
                'description' => $sign['description'],
                'price' => 30000
            ])->has(
                Feature::factory()
            )->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
