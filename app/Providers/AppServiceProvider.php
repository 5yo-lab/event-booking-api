<?php

namespace App\Providers;

use App\Pricing\PricingCalculator;
use App\Pricing\Rules\EarlyBirdDiscountRule;
use App\Pricing\Rules\GroupDiscountRule;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->tag([
            EarlyBirdDiscountRule::class,
            GroupDiscountRule::class,
        ], 'discount.rules');

        $this->app->singleton(PricingCalculator::class, function ($app) {
            $rules = [];
            foreach ($app->tagged('discount.rules') as $rule) {
                $rules[] = $rule;
            }

            return new PricingCalculator($rules);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
