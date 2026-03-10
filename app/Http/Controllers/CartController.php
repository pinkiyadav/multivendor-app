<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
use App\Models\Cart;
class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Add product to cart
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = auth()->user(); // use authenticated user

        $this->cartService->addProduct($user, $request->product_id, $request->quantity);

        return redirect()->back()->with('success', 'Product added to cart!');
        // or for API: return response()->json(['message' => 'Added to cart']);
    }

    // Show cart grouped by vendor
    public function index()
    {
        $user = auth()->user();

        $cart = $this->cartService->getCartGroupedByVendor($user->id);

        return view('cart', compact('cart'));
    }
    // Remove an item from cart
    public function remove(Request $request)
    {
        $itemId = $request->input('id'); // or 'cart_id' depending on your frontend

        $cartItem = Cart::find($itemId);

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['success' => true, 'message' => 'Item removed from cart']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found'], 404);
    }
}