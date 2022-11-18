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
        $occasions = [
            [
                'name' => 'Catering',
                'active' => 1
            ],
            [
                'name' => 'Men Occasions',
                'active' => 1
            ]
        ];

        foreach($occasions as $occasion) {
            Occasion::create($occasion);
        }
//        Occasion::factory()->times(1)->create();
    }
}
