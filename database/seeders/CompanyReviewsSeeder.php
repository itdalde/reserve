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
        CompanyReviews::factory()->times(30)->create();
    }
}
