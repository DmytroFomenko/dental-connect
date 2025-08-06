<?php

namespace Database\Seeders;

use App\Models\Dentist;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dentist = Dentist::find(3);

        if (!$dentist) {
            $this->command->warn('Dentist with ID 3 not found. Please seed dentists first.');
            return;
        }

        // Створюємо 5 ордерів тільки для нього
        Order::factory()->count(20)->create([
            'dentist_id' => $dentist->id,
        ]);
    }

}
