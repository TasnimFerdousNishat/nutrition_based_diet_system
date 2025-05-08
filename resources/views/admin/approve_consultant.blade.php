@php use Illuminate\Support\Facades\Storage; @endphp


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Consultant Requests</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
        .card {
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">Pending Consultant Requests</h2>
        <a href="/admindashboard" class="btn btn-outline-dark">← Back to Dashboard</a>
    </div>

    <input type="text" id="searchInput" class="form-control mb-4" placeholder="Search by name or NID...">

    @if(session('success'))
        <div class="alert alert-success animate__animated animate__fadeInDown">
            {{ session('success') }}
        </div>
    @endif

    @if($req_data->isEmpty())
        <div class="alert alert-info">No pending consultant requests.</div>
    @else
        <div class="row" id="requestList">
            @foreach($req_data as $req)
                <div class="col-md-6 mb-4 request-card" data-name="{{ strtolower($req->name) }}" data-nid="{{ $req->nid }}">
                    <div class="card shadow animate__animated animate__fadeInUp">
                        <div class="card-body">
                            <h5 class="card-title">{{ $req->name }}</h5>
                            <p><strong>NID:</strong> {{ $req->nid }}</p>
                            <p><strong>Address:</strong> {{ $req->address }}</p>
                            <p><strong>Contact:</strong> {{ $req->contact ?? 'N/A' }}</p>
                            <p><strong>Emergency Contact:</strong> {{ $req->em_contact ?? 'N/A' }}</p>
                            <p><strong>Birthday:</strong> {{ $req->birthday }}</p>
                            <p><strong>Gender:</strong> {{ ucfirst($req->gender) }}</p>
                            <p><strong>Description:</strong> {{ $req->description ?? 'N/A' }}</p>

                            <!-- View Buttons that trigger modals -->
                            <button class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#licenseModal{{ $req->id }}">View License</button>
                            <button class="btn btn-sm btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#cvModal{{ $req->id }}">View CV</button>

                            <div class="mt-3">
                                <a href="{{ route('consultant.approve', $req->id) }}" class="btn btn-success btn-sm me-2">Approve</a>
                                <a href="{{ route('consultant.delete', $req->id) }}" class="btn btn-danger btn-sm"
                                   onclick="return confirm('Are you sure you want to delete this request?')">Delete</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- License Modal -->
                <div class="modal fade" id="licenseModal{{ $req->id }}" tabindex="-1" aria-labelledby="licenseLabel{{ $req->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">License Photo</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img src="{{ Storage::url($req->license_photo) }}" class="img-fluid rounded shadow">


                            </div>
                        </div>
                    </div>
                </div>

                <!-- CV Modal -->
                <div class="modal fade" id="cvModal{{ $req->id }}" tabindex="-1" aria-labelledby="cvLabel{{ $req->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">CV Document</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body text-center">
                                <iframe src="{{ Storage::url($req->cv) }}" width="100%" height="500px" class="rounded shadow"></iframe>

                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $req_data->links() }}
        </div>
    @endif

</div>

<!-- Bootstrap Bundle (JS + Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Search Filter Script -->
<script>
    const searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function () {
        const filter = this.value.toLowerCase();
        document.querySelectorAll('.request-card').forEach(card => {
            const name = card.dataset.name;
            const nid = card.dataset.nid;
            card.style.display = (name.includes(filter) || nid.includes(filter)) ? '' : 'none';
        });
    });
</script>

</body>
</html>
