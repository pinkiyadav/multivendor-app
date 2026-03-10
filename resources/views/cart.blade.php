@extends('layouts.app')

@section('content')
<h2>Your Cart</h2>

@if(empty($cart) || count($cart) === 0)
    <p>Your cart is empty.</p>
@else
    @foreach($cart as $vendor => $items)
        <h4>{{ $vendor }}</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>${{ $item['price'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ $item['total'] }}</td>
                        <td>
                            <form method="POST" action="{{ route('cart.remove') }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                <button class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
    <form method="POST" action="{{ route('checkout') }}">
        @csrf
        <button class="btn btn-success">Checkout</button>
    </form>
@endif
@endsection