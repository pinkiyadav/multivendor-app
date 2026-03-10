<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\Mail; // <-- Add this
use App\Mail\OrderPlacedMail;       // <-- Make sure this is imported

class SendOrderEmail
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
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;
        // Use raw email for testing to avoid Mailtrap limits
        Mail::raw("Order #{$order->id} has been placed.", function ($message) use ($order) {
            $message->to('pinki.ajay.y@gmail.com')
                    ->subject("Order Confirmation #{$order->id}");
        });

        // Log the order ID for verification
        \Log::info("Order placed ID: " . $order->id);
        // Mail::to('pinki.ajay.y@gmail.com')->send(new OrderPlacedMail($order));
        // \Log::info("Order placed ID: " . $event->order->id);
    }
}
