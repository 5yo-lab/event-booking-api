<?php

namespace App\Pricing\Rules;

use App\Pricing\AppliedDiscount;
use App\Pricing\DiscountRule;
use App\Pricing\PricingContext;

final class EarlyBirdDiscountRule implements DiscountRule
{
    public function apply(PricingContext $context): ?AppliedDiscount
    {
        if (! $context->event->start_date->greaterThan(now()->addDays(30))) {
            return null;
        }

        $amount = round($context->subtotal * 0.15, 2);

        if ($amount <= 0) {
            return null;
        }

        return new AppliedDiscount(
            type: 'early_bird',
            label: 'Early bird (15%)',
            amount: $amount,
        );
    }
}
