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
            [
                'name' => 'Catering',
                'active' => 1
            ],
            [
                'name' => 'Men Occasions',
                'active' => 1
            ]
        ];
    }
}
