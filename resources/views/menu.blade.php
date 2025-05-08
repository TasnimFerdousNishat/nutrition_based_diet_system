<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Food Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        #cart-drawer {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100%;
            background: white;
            box-shadow: -2px 0 10px rgba(0,0,0,0.2);
            transition: right 0.3s ease-in-out;
            z-index: 1050;
            padding: 20px;
            overflow-y: auto;
        }

        #cart-drawer.show {
            right: 0;
        }

        .backdrop {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.4);
            z-index: 1040;
        }

        .backdrop.show {
            display: block;
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <a href="{{ url('/dashboard') }}" class="btn btn-secondary">← Return to Dashboard</a>
        </div>
        <div>
            <button class="btn btn-outline-primary" id="cart-toggle">
                🛒 Cart <span class="badge bg-danger" id="cart-count">0</span>
            </button>
        </div>
    </div>

    <div class="input-group mb-4">
        <input type="text" id="search-box" class="form-control" placeholder="Search food...">
        <button class="btn btn-primary" id="search-btn">Search</button>
    </div>

    <div class="row" id="food-list">
        @foreach ($foods as $food)
        <div class="col-md-4 mb-4 food-item" data-name="{{ strtolower($food->name) }}">
            <div class="card">
                <img src="{{ asset('storage/' . $food->photo) }}" class="card-img-top" alt="{{ $food->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $food->name }}</h5>
                    <p class="card-text">{{ $food->description }}</p>
                    <p class="card-text"><strong>${{ $food->price }}</strong></p>
                    <input type="number" min="1" value="1" class="form-control mb-2 quantity" data-id="{{ $food->id }}">
                    <button class="btn btn-success add-to-cart" data-id="{{ $food->id }}">Add to Cart</button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Cart Drawer -->
<div id="cart-drawer">
    <h4 class="d-flex justify-content-between">
        Your Cart 
        <button class="btn btn-sm btn-outline-danger" id="close-cart">✖</button>
    </h4>
    <hr>
    <table class="table table-sm" id="cart-table">
        <thead><tr><th>Name</th><th>Qty</th><th>Price</th><th></th></tr></thead>
        <tbody></tbody>
    </table>

    <div class="mb-3">
        <label>Customer Name</label>
        <input type="text" id="customer-name" class="form-control">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" id="customer-phone" class="form-control">
    </div>
    <div class="mb-3">
        <label>Payment Method</label>
        <select id="payment-method" class="form-control">
            <option value="cash">Cash on Delivery</option>
            <option value="bkash">Bkash</option>
        </select>
    </div>
    <button class="btn btn-primary w-100" id="checkout-btn">Checkout</button>
</div>
<div class="backdrop" id="cart-backdrop"></div>

<!-- Scripts -->
<script>
    let cart = [];

    // Load cart from localStorage
    if (localStorage.getItem('cart')) {
        cart = JSON.parse(localStorage.getItem('cart'));
        updateCart();
    }

    function updateCart() {
        const tbody = $('#cart-table tbody');
        tbody.empty();
        $('#cart-count').text(cart.length);

        cart.forEach(item => {
            const subtotal = item.price * item.quantity;
            tbody.append(`
                <tr>
                    <td>${item.name}</td>
                    <td>${item.quantity}</td>
                    <td>$${item.price}</td>
                    <td><button class="btn btn-sm btn-danger remove-item" data-id="${item.id}">X</button></td>
                </tr>
            `);
        });

        // Save updated cart to localStorage
        localStorage.setItem('cart', JSON.stringify(cart));
    }

    $(document).on('click', '.add-to-cart', function() {
        const id = $(this).data('id');
        const qty = parseInt($(`.quantity[data-id="${id}"]`).val());
        const foodCard = $(this).closest('.card-body');
        const name = foodCard.find('.card-title').text();
        const price = parseFloat(foodCard.find('strong').text().replace('$',''));
        
        const existing = cart.find(i => i.id === id);
        if (existing) {
            existing.quantity += qty;
        } else {
            cart.push({ id, name, price, quantity: qty });
        }

        updateCart();
    });

    $(document).on('click', '.remove-item', function() {
        const id = $(this).data('id');
        cart = cart.filter(item => item.id !== id);
        updateCart();
    });

    $('#checkout-btn').click(function() {
        const name = $('#customer-name').val();
        const phone = $('#customer-phone').val();
        const payment = $('#payment-method').val();

        if (!name || !phone || cart.length === 0) {
            alert('Please fill in all details and add items to cart.');
            return;
        }

        $.ajax({
            url: "{{ route('order.place') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                name,
                phone,
                payment_method: payment,
                cart,
                c_id: {{ Auth::id() ?? 'null' }}
            },
            success: function(response) {
                alert(response.message);
                cart = [];
                localStorage.removeItem('cart');
                updateCart();
                location.reload();
            },
            error: function(xhr) {
                alert('An error occurred while placing the order.');
            }
        });
    });

    $('#search-btn').click(function() {
        const query = $('#search-box').val().toLowerCase();
        $('.food-item').each(function() {
            const name = $(this).data('name');
            $(this).toggle(name.includes(query));
        });
    });

    $('#cart-toggle').click(function () {
        $('#cart-drawer').addClass('show');
        $('#cart-backdrop').addClass('show');
    });

    $('#close-cart, #cart-backdrop').click(function () {
        $('#cart-drawer').removeClass('show');
        $('#cart-backdrop').removeClass('show');
    });
</script>
</body>
</html>
