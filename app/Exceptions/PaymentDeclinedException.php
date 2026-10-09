<?php

namespace App\Exceptions;

use RuntimeException;

final class PaymentDeclinedException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Payment was declined by the provider.');
    }
}
