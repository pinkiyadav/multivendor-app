<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ✅ Admin role check
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        // Load all orders with related user, items, products, and vendors
        $orders = Order::with(['user', 'items.product', 'items.product.vendor'])->get();

        return view('admin.orders', compact('orders'));
    }

    public function show($orderId)
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        $order = Order::with(['user', 'items.product', 'items.product.vendor'])
            ->findOrFail($orderId);

        return view('admin.order-detail', compact('order'));
    }
}