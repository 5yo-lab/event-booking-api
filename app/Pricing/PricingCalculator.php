<?php

namespace App\Pricing;

use App\Models\Event;

final class PricingCalculator
{
    /**
     * @param  iterable<DiscountRule>  $rules
     */
    public function __construct(private readonly iterable $rules) {}

    public function calculate(Event $event, int $quantity): PricingResult
    {
        $basePriceTotal = round((float) $event->base_ticket_price * $quantity, 2);
        $context = new PricingContext($event, $quantity, $basePriceTotal);
        $discounts = [];

        foreach ($this->rules as $rule) {
            $applied = $rule->apply($context);

            if ($applied === null) {
                continue;
            }

            $discounts[] = $applied;
            $context->subtotal = round($context->subtotal - $applied->amount, 2);
        }

        return new PricingResult(
            basePriceTotal: $basePriceTotal,
            discounts: $discounts,
            finalPrice: max(0, round($context->subtotal, 2)),
        );
    }
}
