<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Exceptions\InvalidBookingTransitionException;
use App\Exceptions\PaymentDeclinedException;
use App\Models\Booking;
use App\Payments\PaymentGateway;
use Illuminate\Support\Facades\DB;

final class BookingPaymentService
{
    public function __construct(private readonly PaymentGateway $paymentGateway) {}

    public function pay(Booking $booking): Booking
    {
        return DB::transaction(function () use ($booking) {
            $booking = Booking::query()->lockForUpdate()->findOrFail($booking->id);

            if (! $booking->status->canTransitionTo(BookingStatus::Paid)) {
                throw new InvalidBookingTransitionException;
            }

            $result = $this->paymentGateway->createPayment(
                (float) $booking->final_price,
                'booking-'.$booking->id,
            );

            if (! $result->isApproved()) {
                throw new PaymentDeclinedException;
            }

            $booking->status = BookingStatus::Paid;
            $booking->transaction_id = $result->transactionId();
            $booking->save();

            return $booking;
        });
    }
}
