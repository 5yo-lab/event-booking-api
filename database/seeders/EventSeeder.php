<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'name' => 'Nordic PHP Conference',
                'city' => 'Copenhagen',
                'venue' => 'Bella Center',
                'start_date' => Carbon::now()->addDays(45)->setTime(9, 0),
                'capacity' => 500,
                'base_ticket_price' => 199.00,
            ],
            [
                'name' => 'Baltic Jazz Festival',
                'city' => 'Tallinn',
                'venue' => 'Song Festival Grounds',
                'start_date' => Carbon::now()->addDays(60)->setTime(18, 30),
                'capacity' => 1200,
                'base_ticket_price' => 89.50,
            ],
            [
                'name' => 'Startup Summit Sofia',
                'city' => 'Sofia',
                'venue' => 'NDK',
                'start_date' => Carbon::now()->addDays(14)->setTime(10, 0),
                'capacity' => 300,
                'base_ticket_price' => 149.00,
            ],
            [
                'name' => 'Winter Tech Meetup',
                'city' => 'Helsinki',
                'venue' => 'Paasitorni',
                'start_date' => Carbon::now()->addDays(21)->setTime(17, 0),
                'capacity' => 80,
                'base_ticket_price' => 35.00,
            ],
            [
                'name' => 'Arena Rock Night',
                'city' => 'Stockholm',
                'venue' => 'Avicii Arena',
                'start_date' => Carbon::now()->addDays(90)->setTime(20, 0),
                'capacity' => 50,
                'base_ticket_price' => 120.00,
            ],
        ];

        foreach ($events as $event) {
            Event::query()->create($event);
        }
    }
}
