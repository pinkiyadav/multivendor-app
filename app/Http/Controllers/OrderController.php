<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Events\OrderPlaced;
class OrderController extends Controller
{
    public function checkout()
    {
        $order = Order::create([
            'user_id' => 1,
            'vendor_id' => 1,
            'total' => 1500,
            'status' => 'pending'
        ]);
        // Trigger Event
        event(new OrderPlaced($order));

        return response()->json([
            'message' => 'Order placed successfully',
            'order' => $order
        ]);
    }
    public function orders()
    {
        return Order::all();
    }
}
