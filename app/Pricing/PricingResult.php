<?php

namespace App\Pricing;

final readonly class PricingResult
{
    /**
     * @param  list<AppliedDiscount>  $discounts
     */
    public function __construct(
        public float $basePriceTotal,
        public array $discounts,
        public float $finalPrice,
    ) {}

    /**
     * @return array{
     *     base_price_total: float,
     *     discounts: list<array{type: string, label: string, amount: float}>,
     *     final_price: float
     * }
     */
    public function toArray(): array
    {
        return [
            'base_price_total' => round($this->basePriceTotal, 2),
            'discounts' => array_map(fn (AppliedDiscount $d) => $d->toArray(), $this->discounts),
            'final_price' => round($this->finalPrice, 2),
        ];
    }
}
