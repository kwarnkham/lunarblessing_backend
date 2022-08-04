<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Order::factory(20)->for(User::factory())->for(Payment::factory())->hasAttached(Item::factory(), ['quantity' => 1, 'sale_price' => 30000])->create();
    }
}
