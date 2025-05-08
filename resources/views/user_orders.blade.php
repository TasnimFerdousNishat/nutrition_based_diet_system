<!DOCTYPE html>
<html>
<head>
    <title>Your Approved Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

        button {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }

        button:hover {
            background-color: #45a049;
        }

        .no-orders {
            color: red;
            font-size: 18px;
            font-weight: bold;
        }

        .top-bar {
            margin-top: 20px;
        }

        .top-bar a {
            text-decoration: none;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("button.mark-delivered").click(function(event) {
                event.preventDefault();
                var orderId = $(this).data("order-id");

                $.ajax({
                    url: "/order/" + orderId + "/mark-delivered",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        $("#order-" + orderId + " .status").text("Delivered").addClass("delivered").removeClass("not-delivered");
                        $("#order-" + orderId + " .action").html("<span>Delivered</span>");
                        alert(response.message);

                        $("#order-" + orderId).fadeOut(500, function() {
                            $(this).remove();
                            if ($("tbody tr").length === 0) {
                                $("#orders-table tbody").html('<tr><td colspan="6" class="no-orders">You don\'t have any orders.</td></tr>');
                            }
                        });
                    },
                    error: function() {
                        alert("An error occurred while marking the order as delivered.");
                    }
                });
            });
        });
    </script>
</head>
<body>

<h2>Your Orders</h2>

<div class="top-bar">
    <a href="{{ route('dashboard') }}">
        <button>Back to Dashboard</button>
    </a>
</div>

<table id="orders-table">
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
    <tbody>
        @forelse($orders as $order)
        <tr id="order-{{ $order->id }}">
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
            <td class="action">
                @if(!$order->is_delivered)
                    <button class="mark-delivered" data-order-id="{{ $order->id }}">Mark as Delivered</button>
                @else
                    <span class="delivered">Delivered</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="no-orders">You don't have any orders.</td>
        </tr>
        @endforelse
    </tbody>
</table>

</body>
</html>
