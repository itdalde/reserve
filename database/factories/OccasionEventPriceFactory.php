<?php

namespace Database\Factories;

use App\Models\OccasionEventPrice;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OccasionEventPriceFactory extends Factory
{

    /**
     * The name of the factories corresponding model
     * @var string
     */
    protected $model = OccasionEventPrice::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            //
            'occasion_id' => $this->faker->randomNumber(2),
            'plan_id' => $this->faker->randomNumber(2),
            'service_unit' => 'per_guest',
            'service_price' => $this->faker->numberBetween(10, 100),
            'package' => $this->faker->streetName,
            'max_capacity' => $this->faker->numberBetween(50, 100),
            'min_capacity' => $this->faker->numberBetween(1, 50),
            'package_details' => $this->faker->streetName,
            'package_price' => $this->faker->numberBetween(10, 100),
            'active' => $this->faker->numberBetween(0, 1),
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }
}
