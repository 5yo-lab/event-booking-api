<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\BookingStatus;

class Event extends Model
{
    protected $fillable = [
        'name',
        'city',
        'venue',
        'start_date',
        'capacity',
        'base_ticket_price',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'capacity' => 'integer',
            'base_ticket_price' => 'decimal:2',
        ];
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function takenSeats(): int
    {
        return (int) $this->bookings()
            ->whereIn('status', [BookingStatus::Pending, BookingStatus::Paid])
            ->sum('quantity');
    }

    public function availableSeats(): int
    {
        return max(0, $this->capacity - $this->takenSeats());
    }
}