<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            background-color: #f9f8f3;
        }

        .card {
            background: #b5ff6c; /* soft green background */
            border-radius: 15px;
            transition: transform 0.2s ease-in-out, box-shadow 0.2s;
            border: none;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .card-title {
            color: #4b5320; /* earthy green */
        }

        .section-heading {
            color: #2e5e2e;
        }

        .badge {
            background-color: #c9e4c5;
            color: #2e5e2e;
        }

        .card-footer {
            background-color: #e3efdd;
            border-top: none;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-banner />
    @livewire('navigation-menu-food')

    <div class="container py-5">
        <h2 class="text-center mb-4 section-heading">Explore Our Healthy Recipes</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($recipes as $recipe)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if($recipe->food_photo)
                            <img src="{{ asset('storage/public/food_photos/' . $recipe->food_photo) }}" alt="Recipe Image" class="card-img-top" style="height: 200px; object-fit: cover; border-top-left-radius: 15px; border-top-right-radius: 15px;">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Default Image" class="card-img-top">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $recipe->name }}</h5>

                            @if($recipe->calories)
                                <p><span class="badge">{{ $recipe->calories }} kcal</span></p>
                            @endif

                            @if(!empty($recipe->nutrition_info))
                                <p class="fw-semibold mb-1">Nutrition Info:</p>
                                <ul class="mb-2">
                                    @foreach($recipe->nutrition_info as $key => $value)
                                        <li>{{ ucfirst($key) }}: {{ $value }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(!empty($recipe->ingredients))
                                <p class="fw-semibold mb-1">Ingredients:</p>
                                <ul class="mb-2">
                                    @foreach($recipe->ingredients as $ingredient)
                                        <li>{{ $ingredient }}</li>
                                    @endforeach
                                </ul>
                            @endif

                            @if(!empty($recipe->bmi_levels))
                                <p class="fw-semibold mb-1">Suitable for BMI Levels:</p>
                                <ul class="mb-2">
                                    @foreach($recipe->bmi_levels as $bmi)
                                        <li>{{ $bmi }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <div class="card-footer text-end">
                            <a href="{{ route('recipes.show', $recipe->id) }}" class="btn btn-success btn-sm">View Details</a>
                        </div>


                        
                           
                       
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Optional Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
