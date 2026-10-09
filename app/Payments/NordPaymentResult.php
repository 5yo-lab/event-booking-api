<?php

namespace App\Payments;

final readonly class NordPaymentResult implements PaymentResult
{
    public function __construct(
        private string $transactionId,
        private bool $approved,
    ) {}

    public function transactionId(): string
    {
        return $this->transactionId;
    }

    public function isApproved(): bool
    {
        return $this->approved;
    }
}
