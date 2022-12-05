<?php

namespace Database\Seeders;

use App\Models\OccasionEvent;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class OccasionEventSeeder extends Seeder
{

    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        //
        $this->truncate('occasion_events');
        $faker = Faker::create();
        $occasionEvents = [
            [
                'company_id' => 1,
                'name' => 'PEARL INTERNATIONAL BUFFET MENU',
                'price' => $faker->randomElement([650, 750, 850, 550, 950]),
                'description' => $faker->words(10, true),
                'address_1' => $faker->address,
                'address_2' => $faker->address,
                'postal_code' => $faker->postcode,
                'province' => 'Qatar',
                'image' => 'https://via.placeholder.com/280',
                'city' => 'Doha',
                'country' => 'Qatar',
                'max_capacity' => 150,
                'min_capacity' => 100,
                'availability_start_date' =>  $faker->date('Y-m-d', 'now'),
                'availability_end_date' => $faker->date('Y-m-d', 'now'),
                'availability_time_in' => $faker->time('H:i:s', 'now'),
                'availability_time_out' => $faker->time('H:i:s', 'now'),
                'active' => 1,
                'service_type' => 1,
                'occasion_type' => 0,
                'availability_slot' => 2,
                'description_arabic' => $faker->words(10, true)
            ],
            [
                'company_id' => 1,
                'name' => 'CORAL INTERNATIONAL BUFFET MENU',
                'price' => $faker->randomElement([650, 750, 850, 550, 950]),
                'description' => $faker->words(10, true),
                'address_1' => $faker->address,
                'address_2' => $faker->address,
                'postal_code' => $faker->postcode,
                'province' => 'Qatar',
                'image' => 'https://via.placeholder.com/280',
                'city' => 'Doha',
                'country' => 'Qatar',
                'max_capacity' => 150,
                'min_capacity' => 100,
                'availability_start_date' =>  $faker->date('Y-m-d', 'now'),
                'availability_end_date' => $faker->date('Y-m-d', 'now'),
                'availability_time_in' => $faker->time('H:i:s', 'now'),
                'availability_time_out' => $faker->time('H:i:s', 'now'),
                'active' => 1,
                'service_type' => 1,
                'occasion_type' => 0,
                'availability_slot' => 2,
                'description_arabic' => $faker->words(10, true)
            ],
            [
                'company_id' => 1,
                'name' => 'DIAMOND BUFFET MENU',
                'price' => $faker->randomElement([650, 750, 850, 550, 950]),
                'description' => $faker->words(10, true),
                'address_1' => $faker->address,
                'address_2' => $faker->address,
                'postal_code' => $faker->postcode,
                'province' => 'Qatar',
                'image' => 'https://via.placeholder.com/280',
                'city' => 'Doha',
                'country' => 'Qatar',
                'max_capacity' => 200,
                'min_capacity' => 150,
                'availability_start_date' =>  $faker->date('Y-m-d', 'now'),
                'availability_end_date' => $faker->date('Y-m-d', 'now'),
                'availability_time_in' => $faker->time('H:i:s', 'now'),
                'availability_time_out' => $faker->time('H:i:s', 'now'),
                'active' => 1,
                'service_type' => 1,
                'occasion_type' => 0,
                'availability_slot' => 2,
                'description_arabic' => $faker->words(10, true)
            ],
            [
                'company_id' => 2,
                'name' => 'Breakfast Buffet',
                'price' => 300,
                'description' => 'Outside Catering',
                'address_1' => $faker->address,
                'address_2' => $faker->address,
                'postal_code' => $faker->postcode,
                'province' => 'Porto Qatar, The Pearl, Qatar',
                'image' => 'https://via.placeholder.com/280',
                'city' => 'Doha',
                'country' => 'Qatar',
                'max_capacity' => 200,
                'min_capacity' => 150,
                'availability_start_date' =>  $faker->date('Y-m-d', 'now'),
                'availability_end_date' => $faker->date('Y-m-d', 'now'),
                'availability_time_in' => $faker->time('H:i:s', 'now'),
                'availability_time_out' => $faker->time('H:i:s', 'now'),
                'active' => 1,
                'service_type' => 1,
                'occasion_type' => 0,
                'availability_slot' => 2,
                'description_arabic' => $faker->words(10, true)
            ],
            [
                'company_id' => 2,
                'name' => 'White Palace',
                'price' => 300,
                'description' => 'Doha',
                'address_1' => $faker->address,
                'address_2' => $faker->address,
                'postal_code' => $faker->postcode,
                'province' => 'Porto Qatar, The Pearl, Qatar',
                'image' => 'https://via.placeholder.com/280',
                'city' => 'Doha',
                'country' => 'Qatar',
                'max_capacity' => 200,
                'min_capacity' => 150,
                'availability_start_date' =>  $faker->date('Y-m-d', 'now'),
                'availability_end_date' => $faker->date('Y-m-d', 'now'),
                'availability_time_in' => $faker->time('H:i:s', 'now'),
                'availability_time_out' => $faker->time('H:i:s', 'now'),
                'active' => 1,
                'service_type' => 1,
                'occasion_type' => 0,
                'availability_slot' => 2,
                'description_arabic' => $faker->words(10, true)
            ],

        ];

        foreach($occasionEvents as $event) {
            OccasionEvent::create($event);
        }
        // OccasionEvent::factory()->times(20)->create();
    }
}
