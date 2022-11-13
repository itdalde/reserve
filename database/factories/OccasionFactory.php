<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OccasionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->randomElement(['Catering', 'Mens Event']),
            'active' => 1
        ];
    }
}
