<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyReviewsFactory extends Factory
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
            'company_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9]),
            'user_id' => $this->faker->randomElement([2,3,4,5,8]),
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->words(10, true),
            'rate' => $this->faker->randomElement([1,2,3,4,5])
        ];
    }
}
