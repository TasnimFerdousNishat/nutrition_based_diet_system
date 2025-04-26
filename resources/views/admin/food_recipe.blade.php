<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Information</title>
    <link href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #ffffff;
        }
    </style>
</head>
<body style="background: linear-gradient(to right, #7cfaa8, #fbfbfb);">
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px; background: linear-gradient(to right, #03ff18, #007899);">
          <x-application-mark3></x-application-mark3>
          <hr>
          <div class="card-body p-4 p-md-5">
            <h1 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center" style="color: #ffffff">Add Food Recipe</h1>

            @if(session('success'))

            <div class="alert alert-success">{{ session('success') }}</div>
            
            @endif


            <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="name" id="Name" class="form-control form-control-lg" required />
                    <label class="form-label" for="Name">Food Name</label>
                  </div>
                </div>

              <label class="block text-gray-700" style="margin-top: 10px;">Image of Food</label>
              <input type="file" name="food_photo" class="w-50 p-2 border rounded mb-4" accept="image/*" required>

              <div class="col-md-4 mb-4">
                <div class="form-outline">
                  <input type="number" name="calories" id="Calories" class="form-control form-control-lg" />
                  <label class="form-label" for="Calories">Enter Total Calories</label>
                </div>
              </div>
            </div>

         
            <label class="block text-gray-700">Nutrition Information:</label>
                <div id="nutrition-container">
                    <input type="text" name="nutrition_info[]" class="w-50 p-2 border rounded mb-2">
                </div>
                <button type="button" onclick="addNutrition()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: rgb(226, 119, 43);">Add More</button>


                <div>
                <label class="block text-gray-700">Ingredients:</label>
                <div id="ingredients-container">
                    <input type="text" name="ingredients[]" class="w-50 p-2 border rounded mb-2">
                </div>
                <button type="button" onclick="addIngredient()" class="bg-blue-500 text-white px-2 py-1 rounded" style="background-color: rgb(226, 119, 43)">Add More</button>
                <br>
                <br>
                </div>

                <div>
                <label class="block text-gray-700">Suitable for BMI Levels:</label>
                <br>
                <div class="mb-4 ">
                    <input type="checkbox" name="bmi_levels[]" value="Underweight"> Underweight
                    <input type="checkbox" name="bmi_levels[]" value="Normal"> Normal
                    <input type="checkbox" name="bmi_levels[]" value="Overweight"> Overweight
                    <input type="checkbox" name="bmi_levels[]" value="Obese"> Obese
                </div>
            </div>

              <div class="mb-4">
                <label for="description" class="form-label"></label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Write the Food Recipe"></textarea>
              </div>

              <div class="mt-4 pt-2 text-center">
                <input class="btn  btn-lg" type="submit" value="Add" style="background-color: #005d11; color:#ffffff" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('bootstrap-5.0.2-dist/js/bootstrap.bundle.js') }}"></script>

<script>

        function addIngredient() {
            let container = document.getElementById('ingredients-container');
            let input = document.createElement('input');
            input.type = 'text';
            input.name = 'ingredients[]';
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
</script>


</body>
</html>
