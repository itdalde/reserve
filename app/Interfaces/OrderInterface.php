<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function orders();
    public function create($event);
    public function getOrderByEventId($eventId);
    public function delete($eventId);
    public function update($eventId, $eventDetails);
    public function getOrderByStatus($eventStatus);
}
