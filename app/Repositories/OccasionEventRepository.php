<?php

namespace App\Repositories;


use App\Interfaces\OccasionEventInterface;
use App\Interfaces\OccasionEventPriceInterface;
use App\Models\OccasionEvent;
use App\Models\OccasionEventPrice;
use Illuminate\Support\Collection;

class OccasionEventRepository implements OccasionEventInterface
{
    private OccasionEventPriceInterface $occasionEventPriceRepository;
    public function __construct(
        OccasionEventPriceInterface $occasionEventPriceRepository
    )
    {
        $this->occasionEventPriceRepository = $occasionEventPriceRepository;
    }


    public function getEvents(): Collection | array
    {
        $occasions = OccasionEvent::all();
        foreach($occasions as $occasion)
        {
            $occasion_price = $this->occasionEventPriceRepository->getEventPriceById($occasion->occasion_id);
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
