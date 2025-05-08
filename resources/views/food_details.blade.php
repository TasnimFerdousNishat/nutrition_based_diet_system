<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $food_details_data->name }} - Food Suggestion Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
        }
        .card {
            background-color: #ffffff;
            border-radius: 12px;
            border: none;

            border :3px solid #7af37a;
        }
        .card-title {
            color: #2e5e2e;
        }
        .badge {
            background-color: #d7eedc;
            color: #2e5e2e;
        }
        .section-heading {
            color: #4a7c59;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3"><i class="bi bi-arrow-left"></i> Back</a>

    <div class="card shadow-lg p-4">
        <div class="row g-4">
            <div class="col-md-6">
                @if($food_details_data->photo)
                    <img src="{{ asset('storage/' . $food_details_data->photo) }}" alt="{{ $food_details_data->name }}" class="img-fluid rounded">
                @else
                    <img src="{{ asset('images/default.jpg') }}" class="img-fluid rounded" alt="Default Image">
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="card-title">{{ $food_details_data->name }}</h2>

                @if($food_details_data->meal_time)
                    <p><span class="badge">{{ ucfirst($food_details_data->meal_time) }} Meal</span></p>
                @endif

                <p class="text-muted">{{ $food_details_data->description }}</p>

                @if($food_details_data->ingredients && is_array($food_details_data->ingredients))
                    <h5 class="section-heading mt-4">Ingredients</h5>
                    <ul>
                        @foreach($food_details_data->ingredients as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                @endif

                @if($food_details_data->nutrition_info && is_array($food_details_data->nutrition_info))
                    <h5 class="section-heading mt-4">Nutrition Info</h5>
                    <ul>
                        @foreach($food_details_data->nutrition_info as $key => $value)
                            <li>{{ ucfirst($key) }}: {{ $value }}</li>
                        @endforeach
                    </ul>
                @endif

                @if($food_details_data->bmi_levels && is_array($food_details_data->bmi_levels))
                    <h5 class="section-heading mt-4">Recommended for BMI Levels</h5>
                    <ul>
                        @foreach($food_details_data->bmi_levels as $bmi)
                            <li>{{ $bmi }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
