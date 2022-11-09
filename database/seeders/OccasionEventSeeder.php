<?php

namespace Database\Seeders;

use App\Models\OccasionEvent;
use App\Models\OccasionEventPrice;
use Carbon\Carbon as Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OccasionEventSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        OccasionEvent::truncate();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {

            DB::table('occasion_events')->insert([
                'occasion_id' => $i,
                'name' => $faker->name,
                'description' => 'test',
                'address_1' => $faker->streetAddress,
                'image' => $faker->image(),
                'address_2' => $faker->streetName,
                'postal_code' => $faker->postcode,
                'province' => $faker->country,
                'city' => $faker->city,
                'country' => $faker->country,
                'max_capacity' => $faker->numberBetween(50, 100),
                'min_capacity' => $faker->numberBetween(1, 50),
                'availability_date' => $faker->date('Y-m-d', 'now'),
                'availability_time_in' => $faker->time('H:i:s', 'now'),
                'availability_time_out' => $faker->time('H:i:s', 'now'),
                'active' => $faker->numberBetween(0, 1),
                'service_type' => $faker->firstName,
                'occasion_type' => $faker->lastName,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);

            DB::table('occasion_event_prices')->insert([
                'occasion_id' => $i,
                'plan_id' => $i,
                'service_unit' => 'per_person',
                'service_price' => $faker->numberBetween(10, 100),
                'package' => $faker->streetName,
                'max_capacity' => $faker->numberBetween(50, 100),
                'min_capacity' => $faker->numberBetween(1, 50),
                'package_details' => 'details',
                'package_price' => $faker->numberBetween(10, 100),
                'active' => $faker->numberBetween(0, 1),
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ]);
        }
    }
}
