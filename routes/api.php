<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BookingPaymentController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

Route::get('events/{event}', [EventController::class, 'show']);

Route::post('bookings', [BookingController::class, 'store']);

Route::post('bookings/{booking}/pay', [BookingPaymentController::class, 'store']);