<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderPlacedListener
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\OrderPlaced  $event
     * @return void
     */
    public function handle(OrderPlaced $event)
    {
        Log::info('OrderPlacedListener handling event', ['order_id' => $event->order->id]);

        // Store the notification in the database
        Notification::create([
            'order_id' => $event->order->id,
            'type' => 'order',
            'is_read' => false,
        ]);
    }
}
