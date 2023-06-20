<?php

namespace Database\Seeders;

use App\Models\OccasionEventsPivot;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class OccasionEventsPivotSeeder extends Seeder
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
        $this->truncate('services_pivots');
        OccasionEventsPivot::factory()->times(20)->create();
    }
}
