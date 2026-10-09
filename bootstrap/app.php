<?php

use App\Exceptions\InsufficientSeatsException;
use App\Exceptions\InvalidBookingTransitionException;
use App\Exceptions\PaymentDeclinedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

function apiNotFoundMessage(?string $model): string
{
    return match (class_basename($model)) {
        'Event' => 'Event not found.',
        'Booking' => 'Booking not found.',
        default => 'Resource not found.',
    };
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        $exceptions->render(function (ModelNotFoundException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json(['message' => apiNotFoundMessage($e->getModel())], 404);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            $previous = $e->getPrevious();

            if (! $previous instanceof ModelNotFoundException) {
                return null;
            }

            return response()->json(['message' => apiNotFoundMessage($previous->getModel())], 404);
        });

        $exceptions->render(function (InsufficientSeatsException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json(['message' => $e->getMessage()], 409);
        });

        $exceptions->render(function (InvalidBookingTransitionException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json(['message' => $e->getMessage()], 409);
        });

        $exceptions->render(function (PaymentDeclinedException $e, Request $request) {
            if (! $request->is('api/*')) {
                return null;
            }

            return response()->json(['message' => $e->getMessage()], 402);
        });
    })->create();
