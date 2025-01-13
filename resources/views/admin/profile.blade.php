@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="row g-0">
            <!-- Profile Picture -->
            <div class="col-md-4 d-flex justify-content-center align-items-center">
                <img src="{{ asset('storage/items/'.Auth::user()->profile_picture) }}" class="img-fluid rounded-3 border border-4 border-light" alt="Profile Picture" style="max-width: 70%; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <!-- User Info -->
                <div class="card-body py-4 px-5 d-flex flex-column justify-content-center">
                    <h3 class="fw-bold mb-2 text-dark">{{ Auth::user()->name }}</h3>
                    <p class="text-muted fs-5">Username: <span class="text-dark">{{ Auth::user()->username }}</span></p>
                    <p class="text-muted fs-5">Role: <span class="text-dark">{{ Auth::user()->role->role_name }}</span></p>
                    <div class="mt-4">
                        <!-- Full Width Button -->
                        <a href="{{ route('editProfileAdmin') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm w-100">
                            <i class="ri-edit-2-line"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add custom styles for spacing and responsiveness -->
<style>
    .card {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        padding: 1.5rem;
    }

    .card h3 {
        font-size: 1.75rem;
        color: #333;
    }

    .card p {
        font-size: 1.125rem;
        color: #555;
    }

    .btn {
        font-size: 1rem;
        padding: 0.75rem;
        border-radius: 8px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
