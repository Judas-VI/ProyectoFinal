<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// Event listener for guest cart merging was removed to simplify flow.

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // No automatic guest-cart merging. Users must be authenticated to use cart.
    }
}
