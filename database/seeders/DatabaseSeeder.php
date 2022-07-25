<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Feature;
use App\Models\Item;
use App\Models\Order;
use App\Models\Picture;
use App\Models\User;
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
                Picture::factory()
            )->create();

        User::factory()->has(
            Order::factory()->hasAttached(
                Item::factory()->has(Picture::factory()),
                ['quantity' => 1, 'sale_price' => 30000, 'text' => 'my cool text']
            )
        )->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
