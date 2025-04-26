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
<body style="background: linear-gradient(to right, #7cdffa, #fbfbfb);">
<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px; background: linear-gradient(to right, #03c4ff, #007899);">
          <x-application-mark3></x-application-mark3>
          <hr>
          <div class="card-body p-4 p-md-5">
            <h1 class="mb-4 pb-2 pb-md-0 mb-md-5 text-center" style="color: #ffffff">Register As a Consultant</h1>

            <form method="POST" action="{{ route('consultant.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="name" id="Name" class="form-control form-control-lg" required />
                    <label class="form-label" for="Name">Your Name</label>
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="nid" id="Nid" class="form-control form-control-lg" required />
                    <label class="form-label" for="Nid">Your National Identity</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="address" id="Address" class="form-control form-control-lg" required />
                    <label class="form-label" for="Address">Your Address</label>
                  </div>
                </div>

                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="contact" id="Contact" class="form-control form-control-lg" />
                    <label class="form-label" for="Contact">Contact</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-4">
                  <div class="form-outline">
                    <input type="text" name="em_contact" id="EmergencyContact" class="form-control form-control-lg" />
                    <label class="form-label" for="EmergencyContact">Your Emergency Contact</label>
                  </div>
                </div>

                <div class="col-md-6 mb-4 d-flex align-items-center">
                  <div class="form-outline datepicker w-100">
                    <input type="date" name="birthday" class="form-control form-control-lg" id="birthdayDate" required style="color: #03409b" />
                    <label for="birthdayDate" class="form-label">Birthday</label>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 mb-4">
                  <h6 class="mb-2 pb-1">Gender: </h6>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="femaleGender" value="female" checked />
                    <label class="form-check-label" for="femaleGender">Female</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="maleGender" value="male" />
                    <label class="form-check-label" for="maleGender">Male</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" id="otherGender" value="other" />
                    <label class="form-check-label" for="otherGender">Other</label>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <label class="form-label" for="license_photo">Image of Medical License</label>
                <input type="file" name="license_photo" id="license_photo" class="form-control" accept="image/*" required>
              </div>

              <div class="mb-4">
                <label class="form-label" for="cv">Upload Your CV</label>
                <input type="file" name="cv" id="cv" class="form-control" accept="application/pdf" required>
              </div>

              <div class="mb-4">
                <label for="description" class="form-label">Cover Letter / Application</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Write a cover letter or application..."></textarea>
              </div>

              <div class="mt-4 pt-2 text-center">
                <input class="btn btn-lg" type="submit" value="Add" style="background-color: #00265f; color:#ffffff" />
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('bootstrap-5.0.2-dist/js/bootstrap.bundle.js') }}"></script>

</body>
</html>
