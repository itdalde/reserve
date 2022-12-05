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
               'name' => 'The Ritz - Carlton',
               'description' => 'Doha',
               'logo' => 'https://via.placeholder.com/150',
               'service_type_id' => 1,
               'phone_number' => '+(974) 33317799',
               'location' => 'Pearl Qatar, Doha',
               'rating' => $faker->randomElement([1,2,3,4,5]),
               'base_price' => $faker->randomElement([850, 375, 650])
           ],
            [
                'user_id' => 1,
                'name' => 'Yasmine Palace',
                'description' => 'European Style',
                'logo' => 'https://via.placeholder.com/150',
                'service_type_id' => 1,
                'phone_number' => '+(974) 4411 1502',
                'location' => 'La Croisette 31 Parcel 18 Unit 396/397 - Porto Arabia, The Pearl, Qatar',
                'rating' => $faker->randomElement([1,2,3,4,5]),
                'base_price' => $faker->randomElement([850, 375, 650])
            ],
        ];

        foreach($companies as $company) {
            Company::create($company);
        }
    }
}
