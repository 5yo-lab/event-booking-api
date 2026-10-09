<?php

namespace App\Payments;

interface PaymentResult
{
    public function transactionId(): string;

    public function isApproved(): bool;
}
