<!DOCTYPE html>
<html>
<head>
    <title>Pending Orders</title>
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        button { padding: 5px 10px; background-color: green; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

<h2>Pending Orders</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Items</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody id="orderTable">
        @foreach($orders as $order)
        <tr id="order_{{ $order->id }}">
            <td>{{ $order->id }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->customer_phone }}</td>
            <td>{{ $order->total_price }}</td>
            <td>
                <ul>
                    @foreach($order->orderItems as $item)
                    <li>{{ $item->foodItem->name }} (x{{ $item->quantity }})</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <button onclick="approveOrder({{ $order->id }})">Approve</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function approveOrder(orderId) {
        $.ajax({
            url: '/admin/orders/approve/' + orderId,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
                $('#order_' + orderId).remove();
            }
        });
    }
</script>

</body>
</html>
