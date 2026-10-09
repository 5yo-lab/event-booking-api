<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\BookingPaymentService;
use Illuminate\Http\JsonResponse;

class BookingPaymentController
{
    public function __construct(private readonly BookingPaymentService $bookingPaymentService) {}

    public function store(Booking $booking): JsonResponse
    {
        $booking = $this->bookingPaymentService->pay($booking);

        return response()->json([
            'id' => $booking->id,
            'status' => $booking->status->value,
            'transaction_id' => $booking->transaction_id,
            'final_price' => (float) $booking->final_price,
        ]);
    }
}
