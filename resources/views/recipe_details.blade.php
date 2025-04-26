<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ $recipe->name }} - Recipe Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f8f3;
        }
        .card {
            background-color: #f4f8f0;
            border-radius: 12px;
            border: none;
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
                @if($recipe->food_photo)
                    <img src="{{ asset('storage/' . $recipe->food_photo) }}" alt="{{ $recipe->name }}" class="img-fluid rounded">
                @else
                    <img src="{{ asset('images/default.jpg') }}" class="img-fluid rounded" alt="Default Image">
                @endif
            </div>
            <div class="col-md-6">
                <h2 class="card-title">{{ $recipe->name }}</h2>

                @if($recipe->calories)
                    <p><span class="badge">{{ $recipe->calories }} kcal</span></p>
                @endif

                <p class="text-muted">{{ $recipe->description }}</p>

                @if($recipe->ingredients)
                    <h5 class="section-heading mt-4">Ingredients</h5>
                    <ul>
                        @foreach($recipe->ingredients as $ingredient)
                            <li>{{ $ingredient }}</li>
                        @endforeach
                    </ul>
                @endif

                @if($recipe->nutrition_info)
                    <h5 class="section-heading mt-4">Nutrition Info</h5>
                    <ul>
                        @foreach($recipe->nutrition_info as $key => $value)
                            <li>{{ ucfirst($key) }}: {{ $value }}</li>
                        @endforeach
                    </ul>
                @endif

                @if($recipe->bmi_levels)
                    <h5 class="section-heading mt-4">Recommended for BMI Levels</h5>
                    <ul>
                        @foreach($recipe->bmi_levels as $bmi)
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
