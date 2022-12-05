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
            'company_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9]),
            'name' => $this->faker->randomElement(['Catering', 'Photography', 'Videography', 'Hosting', 'Music Band', 'Sound Equipment']),
            'price' => $this->faker->randomElement([650, 750, 850, 550, 950]),
            'description' => $this->faker->words(10, true),
            'address_1' => $this->faker->address,
            'address_2' => $this->faker->address,
            'postal_code' => $this->faker->postcode,
            'province' => $this->faker->country,
            'image' => 'https://via.placeholder.com/280',
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'max_capacity' => $this->faker->randomElement([10, 25, 50, 100]),
            'min_capacity' => $this->faker->randomElement([1, 3, 5, 8]),
            'availability_start_date' =>  $this->faker->date('Y-m-d', 'now'),
            'availability_end_date' => $this->faker->date('Y-m-d', 'now'),
            'availability_time_in' => $this->faker->time('H:i:s', 'now'),
            'availability_time_out' => $this->faker->time('H:i:s', 'now'),
            'active' => 1,
            'service_type' => $this->faker->randomElement([1,2,3]),
            'occasion_type' => 0,
            'availability_slot' => 2,
            'description_arabic' => $this->faker->words(10, true)
        ];
    }
}
