<?php

namespace Database\Seeders;

use App\Models\OccasionEventsPivot;
use Database\Traits\DisableForeignKeys;
use Database\Traits\TruncateTable;
use Illuminate\Database\Seeder;

class OccasionPivotSeeder extends Seeder
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

        $this->truncate('occasion_events_pivots');

        $occasionEvents = [
            [
                'occasion_event_id' => 1,
                'occasion_id' => 1
            ],
            [
                'occasion_event_id' => 2,
                'occasion_id' => 1
            ],
            [
                'occasion_event_id' => 3,
                'occasion_id' => 1
            ],
            [
                'occasion_event_id' => 4,
                'occasion_id' => 1
            ],
            [
                'occasion_event_id' => 5,
                'occasion_id' => 1
            ]
        ];

        foreach($occasionEvents as $occasion) {
            OccasionEventsPivot::create($occasion);
        }
    }
}
