<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.perencanaan')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-lg rounded-4 border-0">
        <!-- Profile Picture at the Top, Centered -->
        <div class="profile-img-container d-flex justify-content-center mb-4">
            <img src="{{ asset('storage/items/'.Auth::user()->profile_picture) }}" class="img-fluid profile-img"
                alt="Profile Picture">
        </div>

        <div class="card card-body py-4 px-5">
            <h3 class="fw-bold  mb-4 text-center" style="font-size: 2.2rem;">{{ Auth::user()->name }}</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="text-muted mb-1" style="font-size: 1.1rem;">Username</p>
                    <h6 class="text-dark" style="font-size: 1.3rem;">{{ Auth::user()->username }}</h6>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <p class="text-muted mb-1" style="font-size: 1.1rem;">Role</p>
                    <h6 class="text-dark" style="font-size: 1.3rem;">{{ Auth::user()->role->role_name }}</h6>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('editProfilePerencanaan') }}"
                    class="btn btn-primary btn-lg rounded-4 px-5 py-3 shadow-sm">
                    <i class="ri-edit-2-line"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Optional: Add custom styles for spacing and responsiveness -->
<style>
    .card {
        background-color: #fff;
        border-radius: 1.25rem;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card.dark {
        background-color: #1f1f1f;
        color: #fff;
    }

    .card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 50px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 2rem;
    }

    .profile-img-container {
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease;
        margin-bottom: 2rem;
    }

    .profile-img {
        max-width: 300px;
        /* Membesarkan gambar */
        max-height: 300px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .profile-img-container:hover .profile-img {
        transform: scale(1.1);
    }

    .profile-img-container:hover {
        box-shadow: 0 8px 35px rgba(0, 0, 0, 0.2);
    }

    .info-box {
        padding: 1.5rem;
        background-color: #f8f9fa;
        border-radius: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .info-box.dark {
        background-color: #333;
    }

    .info-box h6 {
        font-size: 1.3rem;
        font-weight: 600;
    }

    .info-box p {
        font-size: 1.1rem;
        font-weight: 500;
    }

    .btn {
        font-size: 1.3rem;
        font-weight: 500;
        padding: 1rem 2rem;
        border-radius: 8px;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    /* Dark Mode Adjustments */
    .dark .text-dark {
        color: #f1f1f1;
    }

    .dark .btn-primary {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }

    .dark .btn-primary:hover {
        background-color: #45a049;
        border-color: #45a049;
    }

    /* Responsiveness */
    @media (max-width: 767px) {
        .card-body {
            padding: 1.5rem;
        }

        .profile-img {
            max-width: 220px;
            /* Ukuran gambar lebih kecil di mobile */
            max-height: 220px;
        }

        .card h3 {
            font-size: 2rem;
        }

        .card p {
            font-size: 1rem;
        }

        .btn {
            font-size: 1.1rem;
            padding: 0.75rem 1.5rem;
        }
    }
</style>