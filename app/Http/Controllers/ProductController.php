<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Load all products with their vendors
        $products = Product::with('vendor')->get();

        // Return the Blade view with products
        return view('products', compact('products'));
    }
}
