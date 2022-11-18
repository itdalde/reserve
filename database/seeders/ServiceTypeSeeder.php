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
    public function run(): void
    {
        //
        $this->truncate('service_types');
        $serviceTypes = [
            [
                'name' => 'Catering',
                'active' => 1
            ],
            [
                'name' => 'Hospitality Men',
                'active' => 1
            ],
            [
                'name' => 'Hospitality Women',
                'active' => 1
            ]
        ];

        foreach($serviceTypes as $types){
            ServiceType::create($types);
        }

        // ServiceType::factory()->times(3)->create();
    }
}
