<?php

namespace Database\Seeders;

use App\Models\ServiceType;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
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
        $this->truncate('service_types');
        ServiceType::factory()->times(3)->create();
    }
}
