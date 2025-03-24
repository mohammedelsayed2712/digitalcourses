<?php

namespace App\Listeners;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Laravel\Cashier\Events\WebhookReceived;

class ChargeSucceededListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookReceived $event): void
    {
        if ($event->payload['type'] === 'charge.succeeded') {
            $metadata = $event->payload['data']['object']['metadata'];
            $cart = Cart::find($metadata['cart_id']);

            if ($event->payload['data']['object']['status'] == 'succeeded') {
                $order = Order::create([
                    'user_id' => $metadata['user_id'],
                ]);
                $order->courses()->attach($cart->courses->pluck('id')->toArray());
                $cart->delete();
            }
        }
    }
}
