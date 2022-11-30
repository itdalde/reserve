<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OccasionEventsPivotFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'occasion_event_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
            'occasion_id' => $this->faker->randomElement([1,2])
        ];
    }
}
