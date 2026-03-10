<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;
use Exception;

class CartService
{
    /**
     * Add product to user's cart
     */
    public function addProduct($user, $productId, $qty)
    {
        return DB::transaction(function () use ($user, $productId, $qty) {

            $cart = Cart::firstOrCreate([
                'user_id' => $user->id
            ]);

            $product = Product::findOrFail($productId);

            // Check if product already exists in cart
            $cartItem = CartItem::where('cart_id', $cart->id)
                        ->where('product_id', $productId)
                        ->first();

            $newQty = $qty;

            if ($cartItem) {
                $newQty = $cartItem->quantity + $qty;
            }

            // Stock validation
            if ($newQty > $product->stock) {
                throw new Exception("Requested quantity exceeds available stock");
            }

            // Add or update cart item
            CartItem::updateOrCreate(
                [
                    'cart_id' => $cart->id,
                    'product_id' => $productId
                ],
                [
                    'quantity' => $newQty
                ]
            );

            return $cart->load('items.product.vendor');
        });
    }

    /**
     * Update product quantity in cart
     */
    public function updateProduct($userId, $productId, $qty)
    {
        $cart = Cart::where('user_id', $userId)->firstOrFail();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->firstOrFail();

        $product = Product::findOrFail($productId);

        if ($qty > $product->stock) {
            throw new Exception("Requested quantity exceeds stock");
        }

        $cartItem->quantity = $qty;
        $cartItem->save();

        return $cartItem;
    }

    /**
     * Remove product from cart
     */
    public function removeProduct($userId, $productId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) return false;

        return CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->delete();
    }

    /**
     * Get cart items grouped by vendor
     */
    public function getCartGroupedByVendor($userId)
    {
        $cart = Cart::with(['items.product.vendor'])
            ->where('user_id', $userId)
            ->first();

        $grouped = [];

        if (!$cart) return $grouped;

        foreach ($cart->items as $item) {
            $vendorName = $item->product->vendor->name ?? 'Unknown Vendor';

            $grouped[$vendorName][] = [
                'product_id' => $item->product->id,
                'product_name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total' => $item->product->price * $item->quantity
            ];
        }

        return $grouped;
    }

    /**
     * Get total quantity and price for the cart
     */
    public function getCartTotals($userId)
    {
        $cart = Cart::with('items.product')
            ->where('user_id', $userId)
            ->first();

        $totals = [
            'quantity' => 0,
            'total_price' => 0,
        ];

        if (!$cart) return $totals;

        foreach ($cart->items as $item) {
            $totals['quantity'] += $item->quantity;
            $totals['total_price'] += $item->quantity * $item->product->price;
        }

        return $totals;
    }

    /**
     * Clear the cart after checkout
     */
    public function clearCart($userId)
    {
        $cart = Cart::where('user_id', $userId)->first();

        if ($cart) {
            $cart->items()->delete();
        }
    }
}