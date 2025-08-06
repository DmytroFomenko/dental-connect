<?php

namespace Database\Seeders;

use App\Models\Dentist;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserWithDentistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                Dentist::factory()->create([
                    'user_id' => $user->id,
                ]);
            });
    }
}
