<?php

namespace App\Repositories;


use App\Interfaces\OccasionEventInterface;
use App\Models\OccasionEvent;
use App\Models\OccasionEventPrice;

class OccasionEventRepository implements OccasionEventInterface
{

    public function getEvents()
    {
        $occasions = OccasionEvent::all();
        foreach($occasions as $occasion)
        {
            $occasion_price = OccasionEventPrice::where('occasion_id', $occasion->occasion_id);
        }
        return $occasions;
    }

    public function createEvents($event)
    {
        // TODO: Implement createEvents() method.
    }

    public function deleteEvent($eventId)
    {
        // TODO: Implement deleteEvent() method.
        OccasionEvent::destroy($eventId);
    }
}
