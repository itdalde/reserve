<?php

namespace Database\Seeders;

use App\Models\Occasion;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

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
        Occasion::factory()->times(2)->create();
    }
}
