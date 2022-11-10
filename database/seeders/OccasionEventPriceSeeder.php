<?php

namespace Database\Seeders;

use App\Models\OccasionEventPrice;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class OccasionEventPriceSeeder extends Seeder
{
    use DisableForeignKeys, TruncateTable;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->truncate('occasion_event_prices');
        OccasionEventPrice::factory()->times(10)->create();
    }
}
