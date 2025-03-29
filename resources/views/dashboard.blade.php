<x-app-layout>

    <body >
        

    <!-- Include Bootstrap (if not already included in your layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <div class="d-flex" style="background: linear-gradient(to right, #e1fa7c, #fbfbfb);">
        <!-- Sidebar -->
        <div id="sidebar" class="vh-100 p-3 text-white shadow-lg" 
            style=" height:100%; width: 250px; background-color: #efd75f; transition: width 0.3s; box-shadow: 4px 0 10px rgba(0, 0, 0, 0.3);  border-radius: 10px;">
            <button id="toggleBtn" class="btn btn-light mb-3 " style="background-color: #95bc07; box-shadow: 4px 0 10px rgba(0, 0, 0, 0.3);">☰</button>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link text-white d-flex align-items-center">
                        <span class="sidebar-text">BMI based Suggestions</span>
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

        <!-- Main Content -->
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


            <p class="text-center">Welcome to your Jetstream dashboard.</p>

            <div class="Bmi_container" style="margin-top: 50px ">
                <div class="card text-start">
                    <div class="card-body">
                        <h4 class="card-title">Your BMI Records</h4>
                        <canvas id="bmiChart"></canvas> 
                    </div>
                </div>
            </div>


            
            <div class="suggestions">
                <h1 class="text-center" style="margin-top: 70px">Here We will show the suggestions</h1>

                <div class="suggestions_card text-center" id="suggestions" style="display: none; margin-top: 40px;">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title">Title</h3>
                                    <p class="card-text">Text</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>



 
    <script>
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
            let suggestionsDropdown = document.getElementById("suggestionsDropdown");
            let suggestionsDiv = document.getElementById("suggestions");

            function togglesuggestions() {
                if (suggestionsDropdown.value === "Yes") {
                    suggestionsDiv.style.display = "block";
                } else {
                    suggestionsDiv.style.display = "none";
                }
        
                localStorage.setItem("suggestionsSetting", suggestionsDropdown.value);
            }

    
            let savedSetting = localStorage.getItem("suggestionsSetting");
            if (savedSetting) {
                suggestionsDropdown.value = savedSetting; 
                togglesuggestions(); 
            }

         
            suggestionsDropdown.addEventListener("change", togglesuggestions);
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
                    alert(data.message); // Show the message using an alert
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


  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

</body>
</x-app-layout>
