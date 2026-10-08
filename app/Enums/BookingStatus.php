<?php

namespace App\Enums;

enum BookingStatus: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';
    case Expired = 'expired';

    public function canTransitionTo(self $to): bool
    {
        return match ($this) {
            self::Pending => in_array($to, [self::Paid, self::Cancelled, self::Expired], true),
            default => false,
        };
    }
}