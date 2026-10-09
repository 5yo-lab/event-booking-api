# Event Booking API

## Setup

- PHP 8.3
- PostgreSQL
- Copy `.env.example` to `.env` and set `APP_KEY` (`php artisan key:generate`) and DB credentials
- `composer install`
- `php artisan migrate --seed`
- `php artisan serve` — API base URL `http://localhost:8000/api`

## Endpoints

- GET `/api/events/{id}` — event details and available seats
- POST `/api/bookings` — body: `customer_email`, `event_id`, `quantity`
- POST `/api/bookings/{id}/pay` — pay a pending booking

## Architecture

- Small controllers with DB logic moved to dedicated services
- Seat limits use a DB transaction and `lockForUpdate()` on the event row
- Pricing uses a `DiscountRule` interface, concrete rules, and a `PricingCalculator`
- Payments go through a `PaymentGateway` interface; `NordBankGateway` is bound in `AppServiceProvider`
- API errors return JSON with a `message` field (404, 409, 402, 422)

## Discount order

- Early bird (15%) is applied first when the event start is more than 30 days away
- Group discount (10%) is applied second when quantity is at least 5
- Each percentage is calculated on the subtotal after previous discounts, not always on the original line total

## Not implemented

- Confirmation email after payment would be added next: a `BookingPaid` domain event, a queued listener (`ShouldQueue`), and a mailable using the `log` mail driver, dispatched after the payment transaction

## Possible improvements

- Idempotency keys on create booking and pay to handle client retries safely
- Authentication for API clients
- Booking expiry/Cancel logic
- Integration tests for concurrent bookings and payment edge cases
- OpenAPI description of the API
