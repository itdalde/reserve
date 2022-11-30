<?php

namespace Database\Seeders;

use App\Models\CompanyReviews;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CompanyReviewsSeeder extends Seeder
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
        $this->truncate('company_reviews');
        $faker = Faker::create();

        $reviews = [
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],

            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
            [
                'company_id' => $faker->randomElement([1,2,3,4,5,6,7,8,9]),
                'user_id' => $faker->randomElement([2,3,4,5,8]),
                'title' => $faker->words(3, true),
                'description' => $faker->words(10, true),
                'rate' => $faker->randomElement([1,2,3,4,5])
            ],
        ];

        foreach($reviews as $review) {
            CompanyReviews::create($review);
        }
    }
}
