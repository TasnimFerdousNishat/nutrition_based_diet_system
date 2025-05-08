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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <style>

        .chart-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
            flex-direction: column;
        }

        .chart-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
        }

        canvas {
            background: #ffffff;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu-admin')

        <div id="main-content" class="flex-grow-1 p-4">
            <h1 class="fw-bold text-center " style=" background-color:rgba(12, 199, 202, 0.981); color:#ffffff; ">Admin Dashboard</h1>
        </div>
        <div class="col py-3 my-5 d-flex justify-content-center">
            <div class="d-flex gap-2 ">
                <div class="card text-center w-full">
                    <div class="card-body" style="background:#f2563b;">
                        <i class="bi bi-person" style="font-size: 1.5rem; margin-right: 10px;"></i>
                        <h5 class="card-title text-white d-inline-block">Total Users</h5>
                        <p class="card-text text-white">{{$total_users}}</p>
                    </div>
                    
                </div>



                <div class="card text-center w-full">
                    <div class="card-body" style="background:#ffac53;">
                        <h5 class="card-title text-white">Orders</h5>
                        <a href="{{url('/admin/orders/pending')}}">view</a>
                    </div>
                </div>

                <div class="card text-center w-full">
                    <div class="card-body" style="background:#ffac53;">
                        <h5 class="card-title text-white">Approved Orders</h5>
                        <a href="{{url('/admin/orders/approved')}}">view</a>
                    </div>
                </div>

                <div class="card text-center w-full">
                    <div class="card-body" style="background:#dad30d;">
                        <h5 class="card-title text-white">Active Riders</h5>
                        <p class="card-text text-white">this Feature will be available in the future </p>
                    </div>
                </div>


                 <div class="card text-center w-full">
                    <div class="card-body" style="background:#4be210;">
                        <a href="{{url('/approve_consultant')}}"></a>
                        <h5 class="card-title text-white">Consultants Request</h5>
                        <p class="card-text text-white">{{$consultant_request}} </p>
                        <a href="{{url('/approve_consultant')}}">view</a>
                    </div>
                </div>


                <div class="card text-center w-full">
                    <div class="card-body" style="background:#089b8f;">
                        <h5 class="card-title text-white">Total Products</h5>
                        <p class="card-text text-white">this Feature will be available in the future </p>
                    </div>
                </div>


            </div>
        </div>

       
        
        

        <div class="chart-container">
        
            <canvas id="total_user_chart" style="width: 80%; max-width: 800px; margin-top:30px;"></canvas>
        </div>



        <div class="text-center mt-6 my-5">
            <button onclick="toggleFoodForm()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" style="background-color: rgb(163, 234, 58);">Add Food Suggestions</button>
        </div>
        
        <div id="foodForm" class="container text-center mx-auto max-w-lg p-6 bg-white rounded-lg shadow-lg mt-6 hidden">
            <h2 class="text-2xl font-semibold text-center mb-4" style="margin-bottom: 30px;">Add Food Suggestion</h2>
            <hr>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{route('admin.storeFood')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <label class="block text-gray-700">Food Name:</label>
                <input type="text" name="name" class="w-50 p-2 border rounded mb-4" required>

                
                <label class="block text-gray-700">Ingredients:</label>
                <div id="ingredients-container">
                    <input type="text" name="ingredients[]" class="w-50 p-2 border rounded mb-2">
                </div>
                <button type="button" onclick="addIngredient()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: blueviolet">Add More</button>
                <br>
                <br>
                <label class="block text-gray-700">Suitable for BMI Levels:</label>
                <br>
                <div class="mb-4 ">
                    <input type="checkbox" name="bmi_levels[]" value="Underweight"> Underweight
                    <input type="checkbox" name="bmi_levels[]" value="Normal"> Normal
                    <input type="checkbox" name="bmi_levels[]" value="Overweight"> Overweight
                    <input type="checkbox" name="bmi_levels[]" value="Obese"> Obese
                </div>
                
                <label class="block text-gray-700">Meal Time:</label>
                <select name="meal_time" class="w-50 p-2 border rounded mb-4">
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Snack">Snack</option>
                </select>

                <label class="block text-gray-700">Nutrition Information:</label>
                <div id="nutrition-container">
                    <input type="text" name="nutrition_info[]" class="w-50 p-2 border rounded mb-2">
                </div>
                <button type="button" onclick="addNutrition()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: aqua;">Add More</button>
                
                <label class="block text-gray-700" style="margin-top: 10px;">Meal Photo:</label>
                <input type="file" name="photo" class="w-50 p-2 border rounded mb-4" accept="image/*" required>

                <label class="block text-gray-700">Description:</label>
                <textarea name="description" class="w-50 p-2 border rounded mb-4" required></textarea>
                
                
                <div class="text-center mt-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" style="background-color: rgb(51, 188, 1)">Submit</button>
                </div>
            </form>
        </div>



        <div class="text-center mt-6 my-5">
            <button onclick="toggleFoodForm2()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" style="background-color: rgb(163, 234, 58);">Add Food to shop</button>
        </div>




        
        <div id="foodForm2" class="container text-center mx-auto max-w-lg p-6 bg-white rounded-lg shadow-lg mt-6 hidden">
            <h2 class="text-2xl font-semibold text-center mb-4" style="margin-bottom: 30px;">Add Food to Shop</h2>
            <hr>
            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <form action="{{route('admin.storeFood2')}}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <label class="block text-gray-700">Item Name:</label>
                <input type="text" name="name" class="w-50 p-2 border rounded mb-4" required>

                <br>
                <label class="block text-gray-700">Suitable for BMI Levels:</label>
                <br>
                <div class="mb-4 ">
                    <input type="checkbox" name="bmi_levels[]" value="Underweight"> Underweight
                    <input type="checkbox" name="bmi_levels[]" value="Normal"> Normal
                    <input type="checkbox" name="bmi_levels[]" value="Overweight"> Overweight
                    <input type="checkbox" name="bmi_levels[]" value="Obese"> Obese
                </div>
                
                <label class="block text-gray-700">Meal Time:</label>
                <select name="meal_time" class="w-50 p-2 border rounded mb-4">
                    <option value="Breakfast">Breakfast</option>
                    <option value="Lunch">Lunch</option>
                    <option value="Dinner">Dinner</option>
                    <option value="Snack">Snack</option>
                </select>

                <label class="block text-gray-700">Nutrition Information:</label>
                <div id="nutrition-container2">
                    <input type="text" name="nutrition_info2[]" class="w-50 p-2 border rounded mb-2">
                </div>
                <button type="button" onclick="addNutrition2()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: aqua;">Add More</button>
                
                <label class="block text-gray-700" style="margin-top: 10px;">Meal Photo:</label>
                <input type="file" name="photo" class="w-50 p-2 border rounded mb-4" accept="image/*" required>

                <label class="block text-gray-700" style="margin-top: 10px;">Price</label>
                <input type="number" name="price" class="w-50 p-2 border rounded mb-4" required>

                <label class="block text-gray-700">Description:</label>
                <textarea name="description" class="w-50 p-2 border rounded mb-4" required></textarea>
                
                
                <div class="text-center mt-4">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" style="background-color: rgb(51, 188, 1)">Submit</button>
                </div>
            </form>
        </div>

    </div>




    
    <div class="text-center mt-6 my-5">
        <button onclick="toggleFoodForm3()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" style="background-color: rgb(163, 234, 58);">Add Excercise</button>
    </div>




    
    <div id="foodForm3" class="container text-center mx-auto max-w-lg p-6 bg-white rounded-lg shadow-lg mt-6 hidden">
        <h2 class="text-2xl font-semibold text-center mb-4" style="margin-bottom: 30px;">Add Excercise</h2>
        <hr>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('exercise.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <label class="block text-gray-700">Excercise Name:</label>
            <input type="text" name="name" class="w-50 p-2 border rounded mb-4" required>

            <br>
            <label class="block text-gray-700">Suitable for BMI Levels:</label>
            <br>
            <div class="mb-4 ">
                <input type="checkbox" name="bmi_levels[]" value="Underweight"> Underweight
                <input type="checkbox" name="bmi_levels[]" value="Normal"> Normal
                <input type="checkbox" name="bmi_levels[]" value="Overweight"> Overweight
                <input type="checkbox" name="bmi_levels[]" value="Obese"> Obese
            </div>
            
            <label class="block text-gray-700">Excercise Time:</label>
            <select name="excercise_time" class="w-50 p-2 border rounded mb-4">
                <option value="Morning">Morning</option>
                <option value="Evening">Evening</option>
                
            </select>

            <label class="block text-gray-700">Excercise Outcome</label>
            <div id="nutrition-container3">
                <input type="text" name="excercise_outcome[]" class="w-50 p-2 border rounded mb-2">
            </div>
            <button type="button" onclick="addNutrition3()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: aqua;">Add More</button>
            
            <label class="block text-gray-700" style="margin-top: 10px;"> Photo:</label>
            <input type="file" name="photo" class="w-50 p-2 border rounded mb-4" accept="image/*" required>

            <label class="block text-gray-700 mt-2">Duration</label>
          
                <input type="number" name="hours" min="0" placeholder="Hours" class="w-24 p-2 border rounded" required>
                <input type="number" name="minutes" min="0" max="59" placeholder="Minutes" class="w-24 p-2 border rounded" required style="margin-bottom:10px; ">
                
            
            
            

            <label class="block text-gray-700">Description:</label>
            <textarea name="description" class="w-50 p-2 border rounded mb-4" required></textarea>
            
            
            <div class="text-center mt-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" style="background-color: rgb(51, 188, 1)">Submit</button>
            </div>
        </form>
    </div>







    <div class="text-center mt-6 my-5">
        <button onclick="toggleFoodForm4()" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600" style="background-color: rgb(163, 234, 58);">Add Festive wise food Plan</button>
    </div>




    
    <div id="foodForm4" class="container text-center mx-auto max-w-lg p-6 bg-white rounded-lg shadow-lg mt-6 hidden">
        <h2 class="text-2xl font-semibold text-center mb-4" style="margin-bottom: 30px;">Add Festive Food</h2>
        <hr>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{route('festivefood.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <label class="block text-gray-700">Food Name:</label>
            <input type="text" name="name" class="w-50 p-2 border rounded mb-4" required>

            <label class="block text-gray-700">Festive Name</label>
            <input type="text" name="festname" class="w-50 p-2 border rounded mb-4" required>

            <br>
            <label class="block text-gray-700">Suitable for BMI Levels:</label>
            <br>
            <div class="mb-4 ">
                <input type="checkbox" name="bmi_levels[]" value="Underweight"> Underweight
                <input type="checkbox" name="bmi_levels[]" value="Normal"> Normal
                <input type="checkbox" name="bmi_levels[]" value="Overweight"> Overweight
                <input type="checkbox" name="bmi_levels[]" value="Obese"> Obese
            </div>
            
            <label class="block text-gray-700" style="margin-top: 10px;"> Photo:</label>
            <input type="file" name="photo" class="w-50 p-2 border rounded mb-4" accept="image/*" required>


             
            <label class="block text-gray-700">Ingredients:</label>
            <div id="ingredients-container2">
                <input type="text" name="ingredients2[]" class="w-50 p-2 border rounded mb-2">
            </div>
            <button type="button" onclick="addIngredient2()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: blueviolet">Add More</button>
            <br>
            <br>
            
            
            

            <label class="block text-gray-700">Recipe:</label>
            <textarea name="description" class="w-50 p-2 border rounded mb-4" required></textarea>
            
            
            <div class="text-center mt-4">
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded" style="background-color: rgb(51, 188, 1)">Submit</button>
            </div>
        </form>
    </div>



</div>


    @stack('modals')

    @livewireScripts

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const months = @json($months);
            const userCounts = @json($userCounts);

       
            const ctx = document.getElementById("total_user_chart").getContext("2d");

            const gradient = ctx.createLinearGradient(0, 0, 0, 400);

            gradient.addColorStop(0, 'rgba(133, 242, 228)');

            gradient.addColorStop(1, 'rgba(190, 242, 133)');

            new Chart(ctx, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                        label: "User Registrations",
                        backgroundColor: gradient,
                        borderColor: "rgba(252, 194, 3)",
                        pointBackgroundColor: "rgba(232, 104, 49)",
                        pointBorderColor: "green",
                        pointHoverBackgroundColor: "#fff",
                        pointHoverBorderColor: "rgba(255, 99, 132, 1)",
                        borderWidth: 2,
                        data: userCounts,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: {
                            display: true,
                            text: "User Registrations Per Month",
                            font: {
                                size: 18
                            }
                        },
                        legend: {
                            display: true,
                            position: "top"
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });
    </script>






<script>
    function toggleFoodForm() {
            document.getElementById('foodForm').classList.toggle('hidden');
        }

    function toggleFoodForm2() {
            document.getElementById('foodForm2').classList.toggle('hidden');
        }

    
        function toggleFoodForm3() {
            document.getElementById('foodForm3').classList.toggle('hidden');
        }

        function toggleFoodForm4() {
            document.getElementById('foodForm4').classList.toggle('hidden');
        }


        function addIngredient() {
            let container = document.getElementById('ingredients-container');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'ingredients[]';
            input.classList.add('w-full', 'p-2', 'border', 'rounded', 'mb-2');
            container.appendChild(input);
        }


        function addIngredient2() {
            let container = document.getElementById('ingredients-container2');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'ingredients2[]';
            input.classList.add('w-full', 'p-2', 'border', 'rounded', 'mb-2');
            container.appendChild(input);
        }
        
        function addNutrition() {
            let container = document.getElementById('nutrition-container');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'nutrition_info[]';
            input.classList.add('w-full', 'p-2', 'border', 'rounded', 'mb-2');
            container.appendChild(input);
        }



        function addNutrition2() {
            let container = document.getElementById('nutrition-container2');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'nutrition_info2[]';
            input.classList.add('w-full', 'p-2', 'border', 'rounded', 'mb-2');
            container.appendChild(input);
        }


        function addNutrition3() {
            let container = document.getElementById('nutrition-container3');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'excercise_outcome[]';
            input.classList.add('w-full', 'p-2', 'border', 'rounded', 'mb-2');
            container.appendChild(input);
        }
</script>

</body>
</html>
