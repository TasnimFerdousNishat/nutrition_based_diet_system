<x-app-layout>

    <body>
        
   

        

  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <div class="d-flex" style="background: linear-gradient(to right, #e1fa7c, #fbfbfb);">
     
        <div id="sidebar" class="p-3 text-white shadow-lg" 
     style="min-height: 100vh; height: auto; width: 250px; background-color: #efd75f; transition: width 0.3s; box-shadow: 4px 0 10px rgba(0, 0, 0, 0.3); border-radius: 10px;">

            <button id="toggleBtn" class="btn btn-light mb-3 " style="background-color: #95bc07; box-shadow: 4px 0 10px rgba(0, 0, 0, 0.3);">☰</button>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white d-flex align-items-center">
                        <span class="sidebar-text"></span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/bmi_calculator')}}" class="nav-link text-white d-flex align-items-center" id="calculateBmiLink">
                        <span class="sidebar-text">Calculate BMI</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-white d-flex align-items-center">
                        <span class="sidebar-text">Foods</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link text-white d-flex align-items-center">
                        <span class="sidebar-text">Show Suggestions</span>
                        <select name="suggestions" style="margin-left: 10px" id="suggestionsDropdown" class="form-control form-control-sm">
                            <option value="No">No</option>
                            <option value="Yes">Yes</option>
                        </select>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{url('/input_details')}}" class="nav-link text-white d-flex align-items-center" id="InputDetailsLink">
                        <span class="sidebar-text">Input Details</span>
                    </a>
                </li>

               

            </ul>
        </div>

     
        <div id="main-content" class="flex-grow-1 p-4">
            <h1 class="fw-bold text-center " style=" background-color:rgba(103, 239, 85, 0.981); ">Dashboard</h1>


                @if (session('error'))

        <div class="alert alert-danger alert-dismissible fade show" role="alert">

            {{ session('error') }}

         

        </div>

    @endif

    @if (session('success'))

        <div class="alert alert-success alert-dismissible fade show" role="alert">

            {{ session('success') }}

            

        </div>

    @endif


            <p class="text-center">Welcome to your dashboard.</p>

    <div class="col py-3 my-5 d-flex justify-content-center">
        <div class="d-flex gap-2 ">

            @if($bmi_cond == 'Underweight')

            <div class="card text-center w-full">
                <div class="card-body" style="background:#f78e0d;border: 2px solid rgb(153, 57, 5);">
                    <h5 class="card-title text-white">Your BMI level is {{$bmi_cond}}</h5>
                    <p class="card-text text-white">Broo! You need to eat as fuck! </p>
                </div>
            </div>
          

            @elseif($bmi_cond =='Normal')

        

            <div class="card text-center w-full justify-content-center">
                <div class="card-body" style="background:#26d707; border: 2px solid rgb(5, 153, 5);">
                    <h5 class="card-title text-white">Your BMI level is {{$bmi_cond}}</h5>
                    <p class="card-text text-white">Damn! You are good ! </p>
                </div>
            </div>
           

            @elseif($bmi_cond=='Overweight')

                <div class="card text-center w-full">
                    <div class="card-body" style="background:#ffee01;border: 2px solid rgb(151, 153, 5);">
                        <h5 class="card-title text-white">Your BMI level is {{$bmi_cond}}</h5>
                        <p class="card-text text-white"> Ahhh! You need to slow down your Eating a bit ! </p>
                    </div>
                </div>
            

            @elseif($bmi_cond =='Obese')

                <div class="card text-center w-full">
                    <div class="card-body" style="background:#fe0d0d;border: 2px solid rgb(153, 10, 5);">
                        <h5 class="card-title text-white">Your BMI level is {{$bmi_cond}}</h5>
                        <p class="card-text text-white"> Holy shit! You are gonna die soon! </p>
                    </div>
                </div>
            

            @endif

            </div>

        </div>

            <div class="Bmi_container ">

                <div class="card text-start shadow-lg">
                    <div class="card-body">
                        <h4 class="card-title">Your BMI Records</h4>
                        <canvas id="bmiChart"></canvas> 
                    </div>
                </div>
            </div>


            
            <div class="suggestions" style="margin-top: 70px">

                <h1 class="text-center" >Here We will show the suggestions</h1>
             
                <div class="row justify-content-center mt-4" id="suggestionsContainer" style="display: none;">
                    @foreach($food_suggestion_data as $food_data)
                    <div class="col-md-4 d-flex justify-content-center">
                        <a href="\welcome" style="text-decoration: none;">
                            <div class="card text-center suggestion-item" 
                                style="width: 250px; height: 300px; margin: 10px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); border-radius: 10px; border: 3px solid #00ca0d; 
                                background-image: url('{{ asset('storage/' . $food_data->photo) }}'); 
                                background-size: cover; background-position: center;">
                
                                <div class="card-body d-flex flex-column justify-content-center align-items-center" 
                                    style="background: rgba(0, 0, 0, 0.5); color: white; width: 100%; height: 100%; border-radius: 10px;">
                                    <h3 class="card-title" style="font-size: 18px;">{{$food_data->name}}</h3>
                                    <p class="card-text" style="font-size: 14px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 90%;">
                                        {{$food_data->description}}
                                    </p>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                
           
            </div>
            
            

        </div>
    </div>



 
    <script>
      document.addEventListener("DOMContentLoaded", function() {
    let suggestionsDropdown = document.getElementById("suggestionsDropdown");
    let suggestionsContainer = document.getElementById("suggestionsContainer");

    function toggleSuggestions() {
        if (suggestionsDropdown.value === "Yes") {
            suggestionsContainer.style.display = "flex";  // Show suggestions in a flex container
        } else {
            suggestionsContainer.style.display = "none"; // Hide suggestions
        }
        localStorage.setItem("suggestionsSetting", suggestionsDropdown.value);
    }

    let savedSetting = localStorage.getItem("suggestionsSetting");
    if (savedSetting) {
        suggestionsDropdown.value = savedSetting; 
        toggleSuggestions();
    }

    suggestionsDropdown.addEventListener("change", toggleSuggestions);
});


document.getElementById("toggleBtn").addEventListener("click", function () {
            let sidebar = document.getElementById("sidebar");
            let sidebarTexts = document.querySelectorAll(".sidebar-text");

            let option = document.getElementById("suggestionsDropdown");

            if (sidebar.style.width === "250px") {
                sidebar.style.width = "60px";
                sidebarTexts.forEach(text => text.style.display = "none");
                option.style.display = "none";
            } else {
                sidebar.style.width = "250px";
                sidebarTexts.forEach(text => text.style.display = "inline");
                option.style.display = "block";

            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            const bmiData = @json($bmiRecords->pluck('bmi'));
            const labels = @json($bmiRecords->pluck('created_at')->map(function($date) {
                return \Carbon\Carbon::parse($date)->format('M d');
            }));

            const ctx = document.getElementById('bmiChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'BMI Progress',
                        data: bmiData,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderWidth: 2,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    scales: {
                        y: {
                            beginAtZero: false
                        }
                    }
                }
            });
        });



        document.getElementById('calculateBmiLink').addEventListener('click', function(e) {
            e.preventDefault();

            fetch('/validation', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'error') {
                    alert(data.message); 
                } else {
                    window.location.href = '/bmi_calculator';
                }
            })
            .catch(error => console.error('Error:', error));
        });



        document.addEventListener("DOMContentLoaded", function () {

        setTimeout(function () {

            let alerts = document.querySelectorAll('.alert');

            alerts.forEach(alert => {

                alert.style.transition = "opacity 0.5s";

                alert.style.opacity = "0";

                setTimeout(() => alert.remove(), 500);

            });

        }, 5000); 

    });

    </script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




</body>
</x-app-layout>
