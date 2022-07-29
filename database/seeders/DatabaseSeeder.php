<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $now = now();
        DB::table('payments')->insert([
            [
                'name' => 'KBZPay',
                'type' => 1,
                'number' => '09797167172',
                'account_name' => 'SAI KWARN KHAM',
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'name' => 'WavePay',
                'type' => 2,
                'number' => '09797167172',
                'account_name' => null,
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
        DB::table('users')->insert([
            [
                'mobile' => 'moon',
                'password' => 'ninja@moon',
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);
        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'created_at' => $now,
                'updated_at' => $now
            ],
        ]);
        DB::table('role_user')->insert([
            'user_id' => 1,
            'role_id' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        DB::table('items')->insert(
            [
                [
                    'name' => 'Aries',
                    'description' => 'The Ram ♈︎. Sun Sign Dates from March 21st to April 19th. Positive polarity. Cardinal modality. Triplicity, Fire.',
                    'price' => 30000
                ],
                [
                    'name' => 'Taurus',
                    'description' => 'The Bull ♉︎. Sun Sign Dates from April 20th to May 20th. Negative polarity. Fixed modality. Triplicity, Earth.',
                    'price' => 30000
                ],
                [
                    'name' => 'Gemini',
                    'description' => 'The Twins ♊︎. Sun Sign Dates from May 21st to June 21st. Positive polarity. Mutable modality. Triplicity, Air.',
                    'price' => 30000
                ],
                [
                    'name' => 'Cancer',
                    'description' => 'The Crab ♋︎. Sun Sign Dates from June 22nd to July 22nd. Negative polarity. Cardinal modality. Triplicity, Water.',
                    'price' => 30000
                ],
                [
                    'name' => 'Leo',
                    'description' => ' The Lion ♌︎. Sun Sign Dates from July 23rd to August 22nd. Positive polarity. Fixed modality. Triplicity, Fire.',
                    'price' => 30000
                ],
                [
                    'name' => 'Virgo',
                    'description' => 'The Maiden ♍︎. Sun Sign Dates from August 23rd to September 22nd. Negative polarity. Mutable modality. Triplicity, Earth.',
                    'price' => 30000
                ],
                [
                    'name' => 'Libra',
                    'description' => 'The Scales ♎︎. Sun Sign Dates from September 23rd to October 22nd. Positive polarity. Cardinal modality. Triplicity, Air.',
                    'price' => 30000
                ],
                [
                    'name' => 'Scorpio',
                    'description' => 'The The Scorpion ♏︎. Sun Sign Dates from October 23rd to November 22nd. Negative polarity. Fixed modality. Triplicity, Water',
                    'price' => 30000
                ],
                [
                    'name' => 'Sagittarius',
                    'description' => 'The Archer ♐︎. Sun Sign Dates from November 23rd to December 21st. Positive polarity. Mutable modality. Triplicity, Fire.',
                    'price' => 30000
                ],
                [
                    'name' => 'Capricorn',
                    'description' => 'The Goat ♑︎. Sun Sign Dates from December 22nd to January 19th. Negative polarity. Cardinal modality. Triplicity, Earth.',
                    'price' => 30000
                ],
                [
                    'name' => 'Aquarius',
                    'description' => 'The Water bearer ♒︎ . Sun Sign Dates from January 20th to February 18th. Positive polarity. Fixed modality. Triplicity, Air.',
                    'price' => 30000
                ],
                [
                    'name' => 'Pisces',
                    'description' => 'The Fish ♓︎. Sun Sign Dates from February 19th to March 20th. Negative polarity. Mutable modality. Triplicity, Water.',
                    'price' => 30000
                ]
            ]
        );

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'url' => '/asset/' . strtolower($value->name) . '.png', 'item_id' => $value->id
        ])->toArray());
    }
}
