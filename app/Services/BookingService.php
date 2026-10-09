<?php

namespace App\Services;

use App\Enums\BookingStatus;
use App\Exceptions\InsufficientSeatsException;
use App\Models\Booking;
use App\Models\Event;
use App\Pricing\PricingCalculator;
use Illuminate\Support\Facades\DB;

final class BookingService
{
    public function __construct(private readonly PricingCalculator $pricingCalculator) {}

    public function create(string $customerEmail, int $eventId, int $quantity): Booking
    {
        return DB::transaction(function () use ($customerEmail, $eventId, $quantity) {
            $event = Event::query()->lockForUpdate()->findOrFail($eventId);

            if ($quantity > $event->availableSeats()) {
                throw new InsufficientSeatsException;
            }

            $pricing = $this->pricingCalculator->calculate($event, $quantity);

            return Booking::query()->create([
                'event_id' => $event->id,
                'customer_email' => $customerEmail,
                'quantity' => $quantity,
                'status' => BookingStatus::Pending,
                'base_price_total' => $pricing->basePriceTotal,
                'discounts' => array_map(
                    fn ($discount) => $discount->toArray(),
                    $pricing->discounts,
                ),
                'final_price' => $pricing->finalPrice,
            ]);
        });
    }
}
