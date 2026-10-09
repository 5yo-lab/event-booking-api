<?php

namespace App\Pricing\Rules;

use App\Pricing\AppliedDiscount;
use App\Pricing\DiscountRule;
use App\Pricing\PricingContext;

final class GroupDiscountRule implements DiscountRule
{
    public function apply(PricingContext $context): ?AppliedDiscount
    {
        if ($context->quantity < 5) {
            return null;
        }

        $amount = round($context->subtotal * 0.10, 2);

        if ($amount <= 0) {
            return null;
        }

        return new AppliedDiscount(
            type: 'group',
            label: 'Group discount (10%)',
            amount: $amount,
        );
    }
}
