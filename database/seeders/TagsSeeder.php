<?php

namespace Database\Seeders;

use App\Models\Tags;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
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
        $this->truncate('tags');
        $faker = Faker::create();
        $tags = [
            [
                'name' => '4 Halls',
                'company_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Top rated service provider',
                'company_id' => 1,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 1,
                'active' => 1
            ],
            [
                'name' => '2 Halls',
                'company_id' => 2,
                'active' => 1
            ],
            [
                'name' => 'Fast rising service provider',
                'company_id' => 2,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 2,
                'active' => 1
            ],
            /****************/
            [
                'name' => '4 Halls',
                'company_id' => 3,
                'active' => 1
            ],
            [
                'name' => 'Top rated service provider',
                'company_id' => 3,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 3,
                'active' => 1
            ],
            [
                'name' => '2 Halls',
                'company_id' => 4,
                'active' => 1
            ],
            [
                'name' => 'Fast rising service provider',
                'company_id' => 4,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 4,
                'active' => 1
            ],
            /***********************/
            [
                'name' => '4 Halls',
                'company_id' => 6,
                'active' => 1
            ],
            [
                'name' => 'Top rated service provider',
                'company_id' => 6,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 6,
                'active' => 1
            ],
            [
                'name' => '2 Halls',
                'company_id' => 8,
                'active' => 1
            ],
            [
                'name' => 'Fast rising service provider',
                'company_id' => 8,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 8,
                'active' => 1
            ],
            /***********************/
            [
                'name' => '4 Halls',
                'company_id' => 11,
                'active' => 1
            ],
            [
                'name' => 'Top rated service provider',
                'company_id' => 11,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 11,
                'active' => 1
            ],
            [
                'name' => '2 Halls',
                'company_id' => 12,
                'active' => 1
            ],
            [
                'name' => 'Fast rising service provider',
                'company_id' => 12,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 12,
                'active' => 1
            ],
            [
                'name' => '2 Halls',
                'company_id' => 13,
                'active' => 1
            ],
            [
                'name' => 'Fast rising service provider',
                'company_id' => 13,
                'active' => 1
            ],
            [
                'name' => 'Responds quickly',
                'company_id' => 13,
                'active' => 1
            ],
        ];

        foreach ($tags as $tag) {
            Tags::create($tag);
        }
    }
}
