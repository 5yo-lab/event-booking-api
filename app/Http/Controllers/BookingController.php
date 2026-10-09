<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\JsonResponse;

class BookingController
{
    public function __construct(private readonly BookingService $bookingService) {}

    public function store(StoreBookingRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $booking = $this->bookingService->create(
            customerEmail: $validated['customer_email'],
            eventId: $validated['event_id'],
            quantity: $validated['quantity'],
        );

        return response()->json([
            'id' => $booking->id,
            'status' => $booking->status->value,
            'base_price_total' => (float) $booking->base_price_total,
            'discounts' => $booking->discounts,
            'final_price' => (float) $booking->final_price,
        ], 201);
    }
}
