<?php

namespace  App\Interfaces;

interface OccasionEventInterface
{
    public function getEvents();
    public function createEvents($event);
    public function deleteEvent($eventId);
    public function getOccasionEventByType($eventType, $dateFrom, $dateTo);
}
