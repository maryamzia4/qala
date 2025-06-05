<!DOCTYPE html>
<html>
<head>
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Thank you for your order, {{ $user->name }}!</h1>
    <p>Your order #{{ $order->id }} has been successfully placed.</p>
    <p>Total Amount Paid: ${{ $order->total_price }}</p>
    <p>Status: {{ ucfirst($order->status) }}</p>

    <h3>Order Details:</h3>
    <ul>
        @foreach($order->items as $item)
            <li>{{ $item->product->name }} (x{{ $item->quantity }}) - ${{ $item->price * $item->quantity }}</li>
        @endforeach
    </ul>

    <p>We will notify the artist about your order. You can track your order in your account.</p>
    
    <p>Thanks for shopping with us!</p>
</body>
</html>
