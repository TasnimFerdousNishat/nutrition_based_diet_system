<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Medicine Timing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-3">
    <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">⬅️ Go Back to Dashboard</a>

    <h2 class="mb-4">💊 Add Medicine Timing</h2>

    <!-- Form Section -->
    <form id="medicineForm">
        <div id="medicine-wrapper">
            <div class="row g-2 mb-2 medicine-group">
                <div class="col-md-5">
                    <input type="text" name="medicine[]" class="form-control" placeholder="Medicine Name" required>
                </div>
                <div class="col-md-4">
                    <input type="time" name="schedule_time[]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-danger w-100 remove-btn">Remove</button>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2 mb-3">
            <button type="button" id="add-more" class="btn btn-outline-primary">+ Add More</button>
            <button type="submit" class="btn btn-success">💾 Save Schedule</button>
        </div>
    </form>

    <!-- Table Section -->
    <h4 class="mb-3">🗓️ Your Medicine Schedule</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle text-center shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Medicine Name</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody id="scheduleTableBody">
                @foreach($schedules as $schedule)
                <tr>
                    <td>{{ $schedule->medicine_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($schedule->schedule_time)->format('h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $('#add-more').click(function () {
        $('#medicine-wrapper').append(`
            <div class="row g-2 mb-2 medicine-group">
                <div class="col-md-5">
                    <input type="text" name="medicine[]" class="form-control" placeholder="Medicine Name" required>
                </div>
                <div class="col-md-4">
                    <input type="time" name="schedule_time[]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <button type="button" class="btn btn-outline-danger w-100 remove-btn">Remove</button>
                </div>
            </div>
        `);
    });

    $(document).on('click', '.remove-btn', function () {
        $(this).closest('.medicine-group').remove();
    });

    $('#medicineForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('medicine.store') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                $('#medicineForm')[0].reset();
                $('.medicine-group').not(':first').remove();
                $('#scheduleTableBody').html('');

                response.schedules.forEach(schedule => {
                    $('#scheduleTableBody').append(`
                        <tr>
                            <td>${schedule.medicine_name}</td>
                            <td>${schedule.schedule_time}</td>
                        </tr>
                    `);
                });
            },
            error: function (xhr) {
                alert("Something went wrong!");
                console.log(xhr.responseText);
            }
        });
    });
</script>

</body>
</html>
