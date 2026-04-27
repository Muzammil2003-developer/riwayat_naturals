<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #222;">
    <h2 style="margin-bottom: 10px;">New Order Received</h2>

    <p>A new order has been placed on the website.</p>

    <h3 style="margin-bottom: 6px;">Order Info</h3>
    <ul style="padding-left: 18px;">
        <li><strong>Order ID:</strong> #{{ $order->id }}</li>
        <li><strong>Date:</strong> {{ $order->created_at?->format('Y-m-d H:i:s') }}</li>
        <li><strong>Item Type:</strong> {{ $order->product ? 'Product' : 'Package' }}</li>
        <li><strong>Item Name:</strong> {{ $order->product->name ?? $order->package->name ?? 'N/A' }}</li>
        <li><strong>Quantity:</strong> {{ $order->quantity }}</li>
        <li><strong>Total Price:</strong> {{ number_format((float) $order->total_price, 2) }}</li>
        <li><strong>Status:</strong> {{ ucfirst($order->status) }}</li>
    </ul>

    <h3 style="margin-bottom: 6px;">Customer Info</h3>
    <ul style="padding-left: 18px;">
        <li><strong>Name:</strong> {{ $order->customer_name }}</li>
        <li><strong>Phone:</strong> {{ $order->customer_phone }}</li>
        <li><strong>Address:</strong> {{ $order->customer_address }}</li>
    </ul>
</body>
</html>
