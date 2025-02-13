<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\OrderPlaced;
use App\Events\LowStockNotification;
use App\Listeners\OrderPlacedListener;
use App\Listeners\LowStockNotificationListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        OrderPlaced::class => [
            OrderPlacedListener::class,
        ],
        LowStockNotification::class => [
            LowStockNotificationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}