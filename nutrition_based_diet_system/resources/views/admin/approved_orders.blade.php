<!DOCTYPE html>
<html>
<head>
    <title>Approved Orders</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: center;
        }

        th {
            background-color: #f8f8f8;
        }

        .delivered {
            color: green;
            font-weight: bold;
        }

        .not-delivered {
            color: red;
            font-weight: bold;
        }

        ul {
            padding-left: 0;
            list-style-type: none;
        }
    </style>
</head>
<body>

<h2>Approved Orders</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Phone</th>
            <th>Total</th>
            <th>Items</th>
            <th>Delivery Status</th> <!-- ✅ Added column header -->
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
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
                @if($order->is_delivered)
                    <span class="delivered">Delivered</span>
                @else
                    <span class="not-delivered">Not Delivered</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
