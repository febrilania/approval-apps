@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <!-- Breadcrumb and Title -->
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a href="#">Administrator</a></li>
            </ol>
            <h4 class="main-title mb-4">Welcome to Dashboard, {{ Auth::user()->name }}!</h4>
        </div>

        <!-- Dashboard Content -->
        <div class="row">
            <!-- Requests Card -->
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Requests</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="ri-file-list-line"></i> Requests</h5>
                        <p class="card-text">Total Requests: <strong>{{ $requestCount }}</strong></p>
                        <a href="{{ route('purchaseRequest') }}" class="btn btn-outline-primary w-100">View Requests</a>
                    </div>
                </div>
            </div>

            <!-- Users Card -->
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Users</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="ri-user-line"></i> Users</h5>
                        <p class="card-text">Total Users: <strong>{{ $usersCount }}</strong></p>
                        <a href="{{ route('user') }}" class="btn btn-outline-warning w-100">View Users</a>
                    </div>
                </div>
            </div>

            <!-- Item Card -->
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card shadow-sm rounded-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Items</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><i class="ri-store-line"></i> Items</h5>
                        <p class="card-text">Total Item: <strong>{{ $itemCount }}</strong></p>
                        <a href="{{route('itemAdmin')}}" class="btn btn-outline-success w-100">View Items</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Features (Optional) -->
        <div class="row">
            <!-- Notifications or Alerts -->
            <div class="col-md-12 mb-4">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Heads Up!</strong> There are new updates available. Check them out in the admin panel.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- Modal for Quick Info -->
        <div class="modal fade" id="quickInfoModal" tabindex="-1" aria-labelledby="quickInfoModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quickInfoModalLabel">Quick Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Here is some additional information or stats for quick access.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save Info</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add custom styles for layout and colors -->
<style>
    .main-title {
        font-size: 2rem;
        color: #333;
        font-weight: 600;
    }

    .card {
        border-radius: 1rem;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-size: 1.2rem;
        text-align: left;
        font-weight: 600;
    }

    .card-body {
        padding: 1.5rem;
    }

    .card-title {
        font-size: 1.3rem;
        font-weight: 500;
    }

    .btn-outline-primary,
    .btn-outline-warning,
    .btn-outline-success {
        font-size: 1rem;
        font-weight: 600;
    }

    .btn-outline-primary:hover,
    .btn-outline-warning:hover,
    .btn-outline-success:hover {
        background-color: #f8f9fa;
    }
</style>

<!-- Bootstrap 5 JS & Popper (for modal and interactions) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script> --}}