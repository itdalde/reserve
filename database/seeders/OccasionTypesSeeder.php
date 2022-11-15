<?php

namespace Database\Seeders;

use App\Models\OccasionTypes;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class OccasionTypesSeeder extends Seeder
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
        $this->truncate('occasion_types');
        OccasionTypes::factory()->times(5)->create();
    }
}
