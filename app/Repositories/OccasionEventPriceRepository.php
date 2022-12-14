<?php

namespace App\Repositories;

use App\Interfaces\OccasionEventPriceInterface;
use App\Models\OccasionEventPrice;

class OccasionEventPriceRepository implements OccasionEventPriceInterface
{

    public function getEventPriceById($occasion_id)
    {
       return OccasionEventPrice::where('occasion_id', $occasion_id);
    }
}
