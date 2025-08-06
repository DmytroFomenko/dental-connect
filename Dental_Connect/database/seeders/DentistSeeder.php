<?php

namespace Database\Seeders;

use App\Models\Dentist;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DentistSeeder extends Seeder
{
    public function run(): void
    {
        Dentist::factory()->count(10)->create();
    }
}
