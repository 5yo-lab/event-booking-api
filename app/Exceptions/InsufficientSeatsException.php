<?php

namespace App\Exceptions;

use RuntimeException;

final class InsufficientSeatsException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Not enough available seats.');
    }
}
