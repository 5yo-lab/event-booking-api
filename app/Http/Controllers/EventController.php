<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;

class EventController
{
    public function show(Event $event): JsonResponse
    {
        return response()->json([
            'id' => $event->id,
            'name' => $event->name,
            'city' => $event->city,
            'venue' => $event->venue,
            'start_date' => $event->start_date->toIso8601String(),
            'capacity' => $event->capacity,
            'base_ticket_price' => $event->base_ticket_price,
            'available_seats' => $event->availableSeats(),
        ]);
    }
}
