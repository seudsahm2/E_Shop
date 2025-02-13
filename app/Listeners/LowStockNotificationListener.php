<?php

namespace App\Listeners;

use App\Events\LowStockNotification;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LowStockNotificationListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\LowStockNotification  $event
     * @return void
     */
    public function handle(LowStockNotification $event)
    {
        Log::info('LowStockNotificationListener handling event', ['product_id' => $event->product->id]);

        // Save the notification to the database
        Notification::create([
            'product_id' => $event->product->id,
            'type' => 'low_stock',
            'is_read' => false,
        ]);
    }
}
