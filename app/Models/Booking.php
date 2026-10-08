<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'event_id',
        'customer_email',
        'quantity',
        'status',
        'base_price_total',
        'discounts',
        'final_price',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'status' => BookingStatus::class,
            'base_price_total' => 'decimal:2',
            'discounts' => 'array',
            'final_price' => 'decimal:2',
        ];
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}