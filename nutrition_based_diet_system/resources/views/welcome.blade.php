<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel Home</title>
    
    <!-- Bootstrap CSS -->
    <link href="/bootstrap-5.0.2-dist/css/bootstrap.css" rel="stylesheet">

    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">


</head>
<body class="bg-white ">
    
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: #92ff5c;">

        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/"> 

                <img src="{{ asset('images/applogo.png') }}" alt="Logo" style="height: 50px;">
            
            </a>
            
            <!-- Navbar Toggler -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a class="btn" href="{{ route('dashboard') }}" style="border: 2px solid rgb(71, 150, 10); color: rgb(71, 150, 10);">Dashboard</a>
                            </li>
                        @else
                        <li class="nav-item me-2">
                            <a class="btn" href="{{ route('login') }}" style="border: 2px solid rgb(71, 150, 10); color: rgb(71, 150, 10);">Log in</a>
                        </li>
                        
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="btn" href="{{ route('register') }} " style="background-color: rgb(71, 150, 10); color: rgb(255, 255, 255)">Register</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>


   


    
    <div class="container-fluid text-center p-5 banner" >
        <h1>Welcome to Our Nutrition Based Diet Plan System</h1>
        <p>Your tagline or slogan goes here.</p>
    </div>

    <section class="container text-center my-5 services">
        <h2 class="mb-4">Our Services</h2>
        <div class="service-slider">
            <div class="service-slide">
                <div class="card shadow-sm p-4 border-0">
                    <i class="bi bi-nutrition mx-auto text-success" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Nutrition Planning</h4>
                    <p>Get a personalized diet plan that fits your lifestyle and health goals.</p>
                </div>
            </div>
            <div class="service-slide">
                <div class="card shadow-sm p-4 border-0">
                    <i class="bi bi-heart-pulse mx-auto text-danger" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Health Monitoring</h4>
                    <p>Track your progress and maintain a healthy lifestyle with expert guidance.</p>
                </div>
            </div>
            <div class="service-slide">
                <div class="card shadow-sm p-4 border-0">
                    <i class="bi bi-basket3 mx-auto text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Dietary Supplements</h4>
                    <p>Explore a wide range of healthy supplements curated by nutritionists.</p>
                </div>
            </div>

            <div class="service-slide">
                <div class="card shadow-sm p-4 border-0">
                    <i class="bi bi-basket3 mx-auto text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Dietary Supplements</h4>
                    <p>Explore a wide range of healthy supplements curated by nutritionists.</p>
                </div>
            </div>

            <div class="service-slide">
                <div class="card shadow-sm p-4 border-0">
                    <i class="bi bi-basket3 mx-auto text-primary" style="font-size: 3rem;"></i>
                    <h4 class="mt-3">Dietary Supplements</h4>
                    <p>Explore a wide range of healthy supplements curated by nutritionists.</p>
                </div>
            </div>
        </div>
    </section>


   

       
    </div>
    
    

    
    
    <!-- Bootstrap JS -->
    <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.js"></script>
    <script src="{{ asset('js/welcome.js') }}"></script>
</body>

</html>