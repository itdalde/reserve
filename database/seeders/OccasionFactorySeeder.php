<?php

namespace Database\Seeders;

use App\Models\Occasion;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OccasionFactorySeeder extends Seeder
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
        $this->truncate('occasions');
        $faker = Faker::create();
        $occasions = [
            [
                'name' => 'Catering',
                'logo' => $faker->image(),
                'active' => 1
            ],
            [
                'name' => 'Men Occasions',
                'logo' => $faker->image(),
                'active' => 1
            ]
        ];

        foreach($occasions as $occasion) {
            Occasion::create($occasion);
        }
//        Occasion::factory()->times(1)->create();
    }
}
