<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Order Receipt</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 700px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <h2 style="color: #333;">Thank you for your order from ArtiMart!</h2>

        <p><strong>Order ID:</strong> {{ $order->orderinfo_id }}</p>
        <p><strong>Order Date:</strong> {{ $order->date_placed }}</p>
        <p><strong>Order Status:</strong> {{ $order->status }}</p>

        <h3 style="margin-top: 30px;">Customer Details</h3>
        <p>Name: {{ $customer->fname }} {{ $customer->lname }}</p>
        <p>Address: {{ $customer->addressline }}</p>
        <p>Town: {{ $customer->town }}</p>
        <p>Phone: {{ $customer->phone }}</p>

        <h3 style="border-bottom: 1px solid #ccc; padding-bottom: 10px;">Order Summary:</h3>
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
                @foreach ($cart->items as $item)
                <tr style="border-bottom: 1px solid #eaeaea;">
                    <td>{{ $item['item']['item_name'] }}</td>
                    <td align="center">{{ $item['qty'] }}</td>
                    <td align="right">₱{{ number_format($item['item']['sell_price'], 2) }}</td>
                    <td align="right">₱{{ number_format($item['qty'] * $item['item']['sell_price'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h3 style="margin-top: 30px;">Shipping Info</h3>
        <p><strong>Region:</strong> {{ $shipping->region }}</p>
        <p><strong>Shipping Rate:</strong> ₱{{ number_format($shipping->rate, 2) }}</p>

        <h3 style="margin-top: 30px;">Total Payment</h3>
        <p><strong>Cart Total:</strong> ₱{{ $cartTotal }}</p>
        <p><strong>Shipping Fee:</strong> ₱{{ number_format($shipping->rate, 2) }}</p>
        <h2 style="color: #2e7d32;">Grand Total: ₱{{ $orderTotal }}</h2>

        <p style="margin-top: 30px;">If you have any questions, feel free to contact us.</p>
        <p>ArtiMarTeam</p>
    </div>
</body>

</html>