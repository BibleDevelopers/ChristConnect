<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DonationFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(3),
            'description' => $this->faker->paragraph(),
            'goal_amount' => $this->faker->numberBetween(1000000, 20000000),
            'collected_amount' => $this->faker->numberBetween(0, 5000000),
            'active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
