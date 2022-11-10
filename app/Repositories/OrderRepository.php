<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\OccasionEvent;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderInterface
{

    /**
     * This will return all orders
     * @return Collection|array
     */
    public function orders(): Collection|array
    {
        return OccasionEvent::all();
    }

    /**
     * This will create an order
     * @param $event
     * @return void
     */
    public function create($event)
    {
        // TODO: Implement create() method.
    }

    /**
     * Get Order by Event ID
     * @param $eventId
     * @return mixed
     */
    public function getOrderByEventId($eventId)
    {
        return OccasionEvent::where('occasion_id')->all();
    }

    /**
     * Delete Order By ID
     * @param $eventId
     * @return void
     */
    public function delete($eventId)
    {
        OccasionEvent::destroy($eventId);
    }

    /**
     * Update Order event
     * @param $eventId
     * @param $eventDetails
     * @return mixed
     */
    public function update($eventId, $eventDetails)
    {
        return OccasionEvent::where('occasion_id', $eventId)->update($eventDetails);
    }

    /**
     * Get Order by Status
     * @param $eventStatus
     * @return mixed
     */
    public function getOrderByStatus($eventStatus)
    {
        return OccasionEvent::where('status', $eventStatus)->all();
    }
}
