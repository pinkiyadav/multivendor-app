<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\OrderPlaced;
use App\Listeners\SendOrderEmail;
class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        OrderPlaced::class => [
            SendOrderEmail::class,
        ],
    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
