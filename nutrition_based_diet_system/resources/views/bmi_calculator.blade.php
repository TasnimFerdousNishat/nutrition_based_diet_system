<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMI check and User registration </title>
    <link href="{{ asset('bootstrap-5.0.2-dist/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
</head>
<body>
<section class="vh-100 gradient-custom">


    
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
        
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-5">
          <div class="logo text-center">  <x-application-mark2 class="block h-9 w-auto" /></div>
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center">BMI Calculator</h3>

            <form method="POST" action="{{ route('bmi.store') }}">
              @csrf

              <div class="row text-center">
                <div class="col-md-4 mb-4">
                  <div class="form-outline">
                    <input type="number" name="height" id="Height" class="form-control form-control-lg" />
                    <label class="form-label" for="Height">Enter Your Height in cm</label>
                  </div>
                </div>

                <div class="col-md-4 mb-4">
                  <div class="form-outline">
                    <input type="number" name="weight" id="Weight" class="form-control form-control-lg" />
                    <label class="form-label" for="Weight">Enter Your Weight IN KG</label>
                  </div>
                </div>
              </div>

              <div class="mt-4 pt-2 text-center">
                <p>Once you calculate, Based on your BMI, You will see food suggestions in the dashboard</p>
                <input class="btn btn-primary btn-lg" type="submit" value="Calculate" style="background-color: rgb(94, 255, 0)" />
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
function toggleMenstrualCycleInput() {
    let femaleGender = document.getElementById("femaleGender").checked;
    let menstrualCycleInput = document.getElementById("menstrualCycleInput");

    if (femaleGender) {
        menstrualCycleInput.style.display = "block";
    } else {
        menstrualCycleInput.style.display = "none";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    toggleMenstrualCycleInput();
});
</script>

</body>
</html>
