<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Picture;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Payment::factory([
            'name' => 'KBZPay',
            'type' => 1,
            'number' => '09797167172',
            'account_name' => 'SAI KWARN KHAM',
        ])->create();
        Payment::factory([
            'name' => 'WavePay',
            'type' => 2,
            'number' => '09797167172',
            'account_name' => 'SAI KWAN KHAN',
        ])->create();
        User::factory(['mobile' => 'moon', 'password' => 'ninja@moon'])->has(Role::factory(['name' => 'admin']))->create();
        $signs = [
            [
                'name' => 'Aries',
                'description' => 'The Ram ♈︎. Sun Sign Dates from March 21st to April 19th. Positive polarity. Cardinal modality. Triplicity, Fire.',
            ],
            [
                'name' => 'Taurus',
                'description' => 'The Bull ♉︎. Sun Sign Dates from April 20th to May 20th. Negative polarity. Fixed modality. Triplicity, Earth.',
            ],
            [
                'name' => 'Gemini',
                'description' => 'The Twins ♊︎. Sun Sign Dates from May 21st to June 21st. Positive polarity. Mutable modality. Triplicity, Air.',
            ],
            [
                'name' => 'Cancer',
                'description' => 'The Crab ♋︎. Sun Sign Dates from June 22nd to July 22nd. Negative polarity. Cardinal modality. Triplicity, Water.',
            ],
            [
                'name' => 'Leo',
                'description' => ' The Lion ♌︎. Sun Sign Dates from July 23rd to August 22nd. Positive polarity. Fixed modality. Triplicity, Fire.',
            ],
            [
                'name' => 'Virgo',
                'description' => 'The Maiden ♍︎. Sun Sign Dates from August 23rd to September 22nd. Negative polarity. Mutable modality. Triplicity, Earth.',
            ],
            [
                'name' => 'Libra',
                'description' => 'The Scales ♎︎. Sun Sign Dates from September 23rd to October 22nd. Positive polarity. Cardinal modality. Triplicity, Air.',
            ],
            [
                'name' => 'Scorpio',
                'description' => 'The The Scorpion ♏︎. Sun Sign Dates from October 23rd to November 22nd. Negative polarity. Fixed modality. Triplicity, Water',
            ],
            [
                'name' => 'Sagittarius',
                'description' => 'The Archer ♐︎. Sun Sign Dates from November 23rd to December 21st. Positive polarity. Mutable modality. Triplicity, Fire.',
            ],
            [
                'name' => 'Capricorn',
                'description' => 'The Goat ♑︎. Sun Sign Dates from December 22nd to January 19th. Negative polarity. Cardinal modality. Triplicity, Earth.',
            ],
            [
                'name' => 'Aquarius',
                'description' => 'The Water bearer ♒︎ . Sun Sign Dates from January 20th to February 18th. Positive polarity. Fixed modality. Triplicity, Air.',
            ],
            [
                'name' => 'Pisces',
                'description' => 'The Fish ♓︎. Sun Sign Dates from February 19th to March 20th. Negative polarity. Mutable modality. Triplicity, Water.'
            ]
        ];

        foreach ($signs as $sign)
            Item::factory([
                'name' => $sign['name'],
                'description' => $sign['description'],
                'price' => 30000
            ])->has(
                Picture::factory(['url' => '/asset/' . strtolower($sign['name']) . '.png'])
            )->create();

        // User::factory()->has(
        //     Order::factory()->hasAttached(
        //         Item::factory()->has(Picture::factory()),
        //         ['quantity' => 1, 'sale_price' => 30000, 'text' => 'my cool text']
        //     )
        // )->create();
    }
}
