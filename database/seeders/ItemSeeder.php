<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        DB::table('items')->insert(
            [
                [
                    'name' => 'Aries',
                    'description' => 'The Ram ♈︎. Sun Sign Dates from March 21st to April 19th. Positive polarity. Cardinal modality. Triplicity, Fire.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Taurus',
                    'description' => 'The Bull ♉︎. Sun Sign Dates from April 20th to May 20th. Negative polarity. Fixed modality. Triplicity, Earth.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Gemini',
                    'description' => 'The Twins ♊︎. Sun Sign Dates from May 21st to June 21st. Positive polarity. Mutable modality. Triplicity, Air.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Cancer',
                    'description' => 'The Crab ♋︎. Sun Sign Dates from June 22nd to July 22nd. Negative polarity. Cardinal modality. Triplicity, Water.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Leo',
                    'description' => ' The Lion ♌︎. Sun Sign Dates from July 23rd to August 22nd. Positive polarity. Fixed modality. Triplicity, Fire.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Virgo',
                    'description' => 'The Maiden ♍︎. Sun Sign Dates from August 23rd to September 22nd. Negative polarity. Mutable modality. Triplicity, Earth.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Libra',
                    'description' => 'The Scales ♎︎. Sun Sign Dates from September 23rd to October 22nd. Positive polarity. Cardinal modality. Triplicity, Air.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Scorpio',
                    'description' => 'The The Scorpion ♏︎. Sun Sign Dates from October 23rd to November 22nd. Negative polarity. Fixed modality. Triplicity, Water',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Sagittarius',
                    'description' => 'The Archer ♐︎. Sun Sign Dates from November 23rd to December 21st. Positive polarity. Mutable modality. Triplicity, Fire.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Capricorn',
                    'description' => 'The Goat ♑︎. Sun Sign Dates from December 22nd to January 19th. Negative polarity. Cardinal modality. Triplicity, Earth.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Aquarius',
                    'description' => 'The Water bearer ♒︎ . Sun Sign Dates from January 20th to February 18th. Positive polarity. Fixed modality. Triplicity, Air.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Pisces',
                    'description' => 'The Fish ♓︎. Sun Sign Dates from February 19th to March 20th. Negative polarity. Mutable modality. Triplicity, Water.',
                    'price' => 30000,
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            ]
        );

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'url' => '/asset/' . strtolower($value->name) . '.png', 'item_id' => $value->id,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'url' => '/items/' . strtolower($value->name) . '-off.jpeg', 'item_id' => $value->id,
            'type' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'type' => 3,
            'url' => '/items/' . strtolower($value->name) . '-on.jpeg', 'item_id' => $value->id,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'type' => 4,
            'url' => '/items/' . strtolower($value->name) . '-lid-off.jpeg', 'item_id' => $value->id,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'type' => 5,
            'url' => '/items/' . strtolower($value->name) . '-lid-on.jpeg', 'item_id' => $value->id,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'url' => '/items/' . strtolower($value->name) . '-set.jpeg', 'item_id' => $value->id,
            'type' => 6,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'url' => '/items/' . strtolower($value->name) . '-night.jpeg', 'item_id' => $value->id,
            'type' => 6,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());

        DB::table('pictures')->insert(DB::table('items')->get()->map(fn ($value) => [
            'url' => '/items/' . strtolower($value->name) . '.jpeg', 'item_id' => $value->id,
            'type' => 6,
            'created_at' => $now,
            'updated_at' => $now
        ])->toArray());
    }
}
