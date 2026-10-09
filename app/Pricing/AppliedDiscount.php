<?php

namespace App\Pricing;

final readonly class AppliedDiscount
{
    public function __construct(
        public string $type,
        public string $label,
        public float $amount,
    ) {}

    /**
     * @return array{type: string, label: string, amount: float}
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'label' => $this->label,
            'amount' => round($this->amount, 2),
        ];
    }
}
