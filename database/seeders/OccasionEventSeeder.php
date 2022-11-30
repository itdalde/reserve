<?php

namespace Database\Seeders;

use App\Models\OccasionEvent;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class OccasionEventSeeder extends Seeder
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
        $this->truncate('occasion_events');
        OccasionEvent::factory()->times(20)->create();
    }
}
