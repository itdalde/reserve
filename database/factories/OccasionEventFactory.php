<?php

namespace Database\Factories;

use App\Models\OccasionEvent;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OccasionEventFactory extends Factory
{
    /**
     * The name of the factories corresponding model
     * @var string
     */
    protected $model = OccasionEvent::class;
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
            'name' => $this->faker->name,
            'description' => 'test',
            'address_1' => $this->faker->streetAddress,
            'image' => $this->faker->image(),
            'address_2' => $this->faker->streetName,
            'postal_code' => $this->faker->postcode,
            'province' => $this->faker->country,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'max_capacity' => $this->faker->numberBetween(50, 100),
            'min_capacity' => $this->faker->numberBetween(1, 50),
            'availability_date' => $this->faker->date('Y-m-d', 'now'),
            'availability_time_in' => $this->faker->time('H:i:s', 'now'),
            'availability_time_out' => $this->faker->time('H:i:s', 'now'),
            'active' => $this->faker->numberBetween(0, 1),
            'service_type' => $this->faker->firstName,
            'occasion_type' => $this->faker->lastName,
            'created_at' => Carbon::now()->toDateTimeString(),
            'updated_at' => Carbon::now()->toDateTimeString(),
        ];
    }
}
