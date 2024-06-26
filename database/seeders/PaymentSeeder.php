<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
                'number' => '797167172',
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
    }
}
