<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Status Update</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 700px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Hello {{ $customer->name }},</h2>

        <p>We wanted to let you know that the status of your order has been updated.</p>

        <h3 style="margin-top: 30px;">Order Details</h3>
        <p><strong>Order ID:</strong> {{ $order->orderinfo_id }}</p>
        <p><strong>Date Placed:</strong> {{ $order->date_placed }}</p>
        <p><strong>Status:</strong> <span style="color: #2e7d32; font-weight: bold;">{{ ucfirst($order->status) }}</span></p>

        @if(strtolower($order->status) === 'shipped')
            <p><strong>Date Shipped:</strong> {{ $order->date_shipped }}</p>
        @elseif(strtolower($order->status) === 'delivered')
            <p><strong>Date Shipped:</strong> {{ $order->date_shipped }}</p>
            <p><strong>Date Delivered:</strong> {{ $order->date_delivered }}</p>
        @endif

        <h3 style="margin-top: 30px;">Shipping Details</h3>
        @if(count($items) > 0)
        <p><strong>Shipping Region:</strong> {{ $items[0]->shipping_region }}</p>
        <p><strong>Shipping Rate:</strong> ₱{{ number_format($items[0]->shipping_rate, 2) }}</p>
        @endif

        <h3 style="margin-top: 30px;">Customer Information</h3>
        <p><strong>Name:</strong> {{ $customer->name }}</p>
        <p><strong>Address:</strong> {{ $customer->addressline }}</p>
        <p><strong>Town:</strong> {{ $customer->town }}</p>
        <p><strong>Phone:</strong>  {{ $customer->phone }}</p>

        <h3 style="margin-top: 30px;">Ordered Items</h3>
        <table width="100%" cellpadding="10" cellspacing="0" style="border-collapse: collapse;">
            <thead style="background-color: #f3f3f3;">
                <tr>
                    <th align="left">Item</th>
                    <th align="center">Qty</th>
                    <th align="right">Price</th>
                    <th align="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
            @php $subtotal = 0; @endphp
            @foreach ($items as $item)
                @php 
                    $itemSubtotal = $item->quantity * $item->sell_price; 
                    $subtotal += $itemSubtotal; 
                @endphp
                <tr style="border-bottom: 1px solid #eaeaea;">
                    <td>{{ $item->item_name }}</td>
                    <td align="center">{{ $item->quantity }}</td>
                    <td align="right">₱{{ number_format($item->sell_price, 2) }}</td>
                    <td align="right">₱{{ number_format($itemSubtotal, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div style="margin-top: 20px; text-align: right;">
            <p><strong>Subtotal:</strong> ₱{{ number_format($subtotal, 2) }}</p>
            @if(count($items) > 0)
            <p><strong>Shipping:</strong> ₱{{ number_format($items[0]->shipping_rate, 2) }}</p>
            @endif
            <h3 style="color: #2e7d32;">
                <strong>Grand Total: ₱{{ number_format(isset($grandTotal) ? $grandTotal : ($subtotal + (count($items) > 0 ? $items[0]->shipping_rate : 0)), 2) }}</strong>
            </h3>
        </div>

        <h3 style="margin-top: 30px; color: #2e7d32;">Thank you for shopping with us!</h3>
        <p>If you have any questions or need further assistance, feel free to contact us at any time.</p>

        <p style="margin-top: 40px;">Warm regards,</p>
        <p><strong>ArtiMarTeam</strong></p>
    </div>
</body>

</html>