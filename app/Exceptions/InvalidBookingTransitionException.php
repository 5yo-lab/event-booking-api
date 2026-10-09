<?php

namespace App\Exceptions;

use RuntimeException;

final class InvalidBookingTransitionException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('This booking cannot be paid in its current status.');
    }
}
