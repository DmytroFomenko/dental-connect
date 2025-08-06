<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'patient_name' => $this->faker->name(),
            'phone' => $this->faker->numerify('050#######'),
            'status' => $this->faker->randomElement(['new', 'processed']),
            'created_at' => $this->faker->dateTimeBetween('-10 days', 'now'),
        ];
    }
}
