<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\ServiceType;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
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
        $faker = Faker::create();
        // Service Type
        $this->truncate('service_types');
        $serviceTypes = [
            [
                'name' => 'Catering',
                'active' => 1
            ],
            [
                'name' => 'Hospitality Men',
                'active' => 1
            ],
            [
                'name' => 'Hospitality Women',
                'active' => 1
            ]
        ];
        foreach($serviceTypes as $types){
            ServiceType::create($types);
        }

        // Company
        $this->truncate('companies');
        $companies = [
            [
                'user_id' => 1,
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'logo' => $faker->image(),
                'service_type_id' => 1
            ],
            [
                'user_id' => 2,
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'logo' => $faker->image(),
                'service_type_id' => 2
            ],
            [
                'user_id' => 3,
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'logo' => $faker->image(),
                'service_type_id' => 3
            ],
            [
                'user_id' => 7,
                'name' => $faker->company,
                'description' => $faker->paragraph,
                'logo' => $faker->image(),
                'service_type_id' => 3
            ]
        ];
        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
