<?php

namespace Database\Seeders;

use App\Models\OccasionServiceTypePivot;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class OccasionServiceTypePivotsSeeder extends Seeder
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
        $this->truncate('occasion_service_type_pivots');
        $pivots = [
            [
                'occasion_id' => 1,
                'service_type_id' => 1
            ],
            [
                'occasion_id' => 1,
                'service_type_id' => 3
            ],
            [
                'occasion_id' => 2,
                'service_type_id' => 1
            ],[
                'occasion_id' => 2,
                'service_type_id' => 2
            ]
        ];

        foreach($pivots as $pivot) {
            OccasionServiceTypePivot::create($pivot);
        }
    }
}
