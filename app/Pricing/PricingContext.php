<?php

namespace App\Pricing;

use App\Models\Event;

final class PricingContext
{
    public function __construct(
        public readonly Event $event,
        public readonly int $quantity,
        public float $subtotal,
    ) {}
}
