<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LowStockNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Product $product
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
        Log::info('LowStockNotification event instantiated', ['product_id' => $product->id]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('products');
    }

    /**
     * Set a custom event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'product.low_stock';
    }
}
