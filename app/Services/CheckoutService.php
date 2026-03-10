<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Events\OrderPlaced;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutService
{
    public function checkout($user)
    {
        return DB::transaction(function () use ($user) {

            $cart = $user->cart()->with('items.product.vendor')->first();

            if (!$cart || $cart->items->isEmpty()) {
                throw new Exception('Cart is empty');
            }

            $total = 0;

            // Check stock and calculate total
            foreach ($cart->items as $item) {
                if ($item->quantity > $item->product->stock) {
                    throw new Exception("Not enough stock for product: {$item->product->name}");
                }

                $total += $item->product->price * $item->quantity;
            }

            // Create a single order
            $order = Order::create([
                'user_id' => $user->id,
                'total' => $total,
                'status' => 'paid' // Payment is immediately paid
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                // Debug product
    // if (!$item->product) {
    //     dd("Product not loaded for cart item ID {$item->id}, product_id: {$item->product_id}");
    // }

    // // Debug vendor_id
    // dd("Cart item ID {$item->id}, Product ID {$item->product_id}, Vendor ID: " . ($item->product->vendor_id ?? 'NULL'));
    
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'vendor_id' => $item->product->vendor_id, // ✅ store vendor here
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'status' => 'paid',
                'amount' => $total
            ]);

            // Fire event
            event(new OrderPlaced($order));

            // Clear cart
            $cart->items()->delete();

            return $order;
        });
    }
}