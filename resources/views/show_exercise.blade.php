<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercises for BMI: {{ $bmi_cond }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>
    <style>
        body {
            background: #f7f9fc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .exercise-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .exercise-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
        }

        .exercise-img {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }

        .exercise-details {
            background: #ffffff;
            padding: 20px;
        }

        .view-details-btn {
            transition: background 0.3s ease;
        }

        .modal-img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <a href="{{ url('/dashboard') }}" class="btn btn-secondary back-btn">
        <i class="bi bi-arrow-left-circle"></i> Go Back to Dashboard
    </a>


    <h2 class="mb-4 text-center fw-bold">Exercises for BMI Level: <span class="text-primary">{{ $bmi_cond}}</span></h2>

    <div class="row g-4">
        @forelse ($exercises as $exercise)
            <div class="col-md-6 col-lg-4">
                <div class="card exercise-card animate__animated animate__fadeInUp">
                    @if($exercise->photo)
                        <img src="{{ asset('storage/' . $exercise->photo) }}" class="exercise-img" alt="{{ $exercise->name }}">
                    @else
                        <img src="https://via.placeholder.com/300x250.png?text=No+Image" class="exercise-img" alt="No Image">
                    @endif
                    <div class="exercise-details">
                        <h5 class="fw-bold">{{ $exercise->name }}</h5>
                        <p class="mb-1"><strong>Duration:</strong> {{ $exercise->duration }}</p>
                        <p><strong>Time:</strong> {{ $exercise->excercise_time }}</p>
                        <button class="btn btn-outline-primary view-details-btn" data-bs-toggle="modal" data-bs-target="#exerciseModal{{ $exercise->id }}">View Details</button>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exerciseModal{{ $exercise->id }}" tabindex="-1" aria-labelledby="exerciseModalLabel{{ $exercise->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exerciseModalLabel{{ $exercise->id }}">{{ $exercise->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($exercise->photo)
                                <img src="{{ asset('storage/' . $exercise->photo) }}" class="modal-img mb-3" alt="{{ $exercise->name }}">
                            @endif
                            <p><strong>Description:</strong></p>
                            <p>{{ $exercise->description }}</p>
                            <hr>
                            <p><strong>Duration:</strong> {{ $exercise->duration }}</p>
                            <p><strong>Outcome:</strong>
                                @if (!empty($exercise->excercise_outcome))
                                    <ul>
                                        @foreach ($exercise->excercise_outcome as $outcome)
                                            <li>{{ $outcome }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <em>No outcomes listed.</em>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    No exercises found for this BMI level.
                </div>
            </div>
        @endforelse
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
