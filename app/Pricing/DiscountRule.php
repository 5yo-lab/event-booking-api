<?php

namespace App\Pricing;

interface DiscountRule
{
    public function apply(PricingContext $context): ?AppliedDiscount;
}
