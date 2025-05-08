<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Festive Diet Plans</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 36px;
            animation: fadeIn 1s ease-in-out;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #2980b9;
        }

        .accordion {
            background: linear-gradient(45deg, #ff7a18, #af002d 70%);
            color: white;
            cursor: pointer;
            padding: 15px 20px;
            margin-bottom: 10px;
            border: none;
            outline: none;
            text-align: left;
            font-size: 20px;
            font-weight: 600;
            border-radius: 10px;
            transition: background 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        .active, .accordion:hover {
            background: linear-gradient(45deg, #e96000, #93001f 70%);
        }

        .panel {
            padding: 0 0 20px;
            display: none;
            overflow: hidden;
        }

        .food-card {
            display: flex;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }

        .food-card:hover {
            transform: scale(1.02);
        }

        .food-photo {
            width: 220px;
            height: 220px;
            object-fit: cover;
        }

        .food-details {
            padding: 20px;
            flex: 1;
        }

        .food-details h3 {
            margin: 0 0 10px;
            font-size: 22px;
            color: #333;
        }

        .bmi-tag {
            display: inline-block;
            background-color: #00c292;
            color: white;
            font-size: 13px;
            padding: 5px 12px;
            margin: 4px 4px 0 0;
            border-radius: 20px;
        }

        .view-btn {
            margin-top: 10px;
            padding: 8px 15px;
            background: #e67e22;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .view-btn:hover {
            background: #d35400;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 10px;
            width: 70%;
            max-width: 600px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 26px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>

<div class="container">
    <a href="/dashboard" class="back-btn">← Back to Dashboard</a>
    <h1>Festive Diet Plans</h1>

    @php
        $grouped = $festiveFoods->groupBy('festname');
    @endphp

    @foreach($grouped as $festname => $foods)
        <button class="accordion">{{ ucfirst($festname) }} Diet Plan</button>
        <div class="panel">
            @foreach($foods as $food)
                <div class="food-card">
                    <img src="{{ asset('storage/' . $food->photo) }}" class="food-photo" alt="{{ $food->name }}">
                    <div class="food-details">
                        <h3>{{ $food->name }}</h3>
                        <p><strong>BMI Levels:</strong></p>
                        @if($food->bmi_levels)
                            @foreach($food->bmi_levels as $bmi)
                                <span class="bmi-tag">{{ $bmi }}</span>
                            @endforeach
                        @else
                            <span style="color: #777;">No specific BMI levels</span>
                        @endif
                        <br>
                        <button class="view-btn" data-id="{{ $food->id }}">View Description</button>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<!-- Modal -->
<div id="descModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div id="modal-body">
            <h3>Loading...</h3>
        </div>
    </div>
</div>

<script>
    // Accordion
    const acc = document.getElementsByClassName("accordion");
    for (let i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            const panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }

    // Modal
    $(document).ready(function() {
        $('.view-btn').on('click', function() {
            var foodId = $(this).data('id');

            $.ajax({
                url: '/festive-food/' + foodId,
                method: 'GET',
                success: function(data) {
                    $('#modal-body').html(`
                        <h3>${data.name}</h3>
                        <p><strong>Description:</strong> ${data.description}</p>
                        <p><strong>Ingredients:</strong> ${data.ingredients.join(', ')}</p>
                        <p><strong>BMI Levels:</strong> ${data.bmi_levels.length ? data.bmi_levels.join(', ') : 'None'}</p>
                    `);
                    $('#descModal').fadeIn();
                },
                error: function() {
                    $('#modal-body').html('<p>Something went wrong. Please try again.</p>');
                    $('#descModal').fadeIn();
                }
            });
        });

        $('.close').on('click', function() {
            $('#descModal').fadeOut();
        });

        $(window).on('click', function(e) {
            if (e.target == document.getElementById('descModal')) {
                $('#descModal').fadeOut();
            }
        });
    });
</script>

</body>
</html>
