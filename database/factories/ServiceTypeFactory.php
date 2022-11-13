<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceTypeFactory extends Factory
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
            'active' => 1
        ];
    }
}
