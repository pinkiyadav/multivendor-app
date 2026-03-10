@extends('layouts.app')

@section('content')
<h2>Products</h2>
<div class="row">
    @foreach($products as $product)
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5>{{ $product->name }}</h5>
                    <p>Vendor: {{ $product->vendor->name }}</p>
                    <p>Price: ${{ $product->price }}</p>
                    <p>Stock: {{ $product->stock }}</p>
                    <form method="POST" action="{{ route('cart.add') }}">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control mb-2">
                        <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection