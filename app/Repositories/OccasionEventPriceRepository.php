<?php

namespace App\Repositories;

use App\Interfaces\OccasionEventPriceInterface;
use App\Models\OccasionEventPrice;

class OccasionEventPriceRepository implements OccasionEventPriceInterface
{

    public function getEventPriceById($eventId)
    {
        return OccasionEventPrice::where('occasion_id', $eventId)->first();
    }
}
