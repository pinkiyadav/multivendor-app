<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function checkout(CheckoutService $checkout)
    {
        try {
            // Perform checkout
            $checkout->checkout(auth()->user());

            // Redirect to products page with success message
            return redirect()->route('products')
                ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            // If something goes wrong, redirect back with error message
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}