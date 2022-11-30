<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OccasionTypesFactory extends Factory
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
            'name' => $this->faker->randomElement(['Catering', 'Hospitality Men', 'Hospitality Women']),
            'image' => 'https://via.placeholder.com/150',
            'base_price' => $this->faker->numberBetween(850, 1000),
            'occasion_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
