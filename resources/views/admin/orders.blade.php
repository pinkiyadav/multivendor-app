<h1>Admin Orders</h1>

@if($orders->isEmpty())
    <p>No orders found.</p>
@else
    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Items</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <ul>
                        @foreach($order->items as $item)
                            <li>
                                {{ $item->product->name ?? 'Deleted Product' }} 
                                x {{ $item->quantity }} - {{ $item->price }}
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    {{ $order->items->sum(fn($item) => $item->quantity * $item->price) }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif