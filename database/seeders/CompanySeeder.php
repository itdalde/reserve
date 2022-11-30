<?php

namespace Database\Seeders;

use App\Models\Company;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CompanySeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->truncate('companies');
        $faker = Faker::create();

        $companies = [
            [
                'user_id' => 1,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 2,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 3,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 4,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 6,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 8,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 11,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 12,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
            [
                'user_id' => 13,
                'name' => $faker->company,
                'description' => $faker->words(50, true),
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => $faker->randomElement([1,2,3]),
                'phone_number' => $faker->phoneNumber,
                'location' => $faker->address,
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ]
        ];

        foreach($companies as $company) {
            Company::create($company);
        }
    }
}
