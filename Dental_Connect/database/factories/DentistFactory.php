<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dentist>
 */
class DentistFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->lastName . ' ' . $this->faker->firstName . ' ' . $this->faker->firstName,
            'photo_name' => 'null.png',
            'experience' => $this->faker->numberBetween(1, 40),
            'description' => $this->faker->text(50),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
