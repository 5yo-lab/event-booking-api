<?php

namespace App\Payments;

interface PaymentGateway
{
    public function createPayment(float $amount, string $orderId): PaymentResult;
}
