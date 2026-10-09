<?php

namespace App\Payments;

use Illuminate\Support\Str;

final class NordBankGateway implements PaymentGateway
{
    public function createPayment(float $amount, string $orderId): PaymentResult
    {
        return new NordPaymentResult(
            transactionId: 'nord-'.Str::uuid()->toString(),
            approved: true,
        );
    }
}
