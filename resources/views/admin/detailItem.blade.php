@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm rounded-4 overflow-hidden border-0">
        <div class="row">
            <div class="col-md-6 mb-4">
                <!-- Item Image -->
                <div class="image-container d-flex justify-content-center">
                    <img src="{{ asset('storage/items/'.$item->image) }}" class="img-fluid rounded-3 shadow-lg" alt="gambar" />
                </div>
            </div>
            <div class="col-md-6">
                <!-- Item Details -->
                <h3 class="fw-bold mb-2">{{ $item->item_name }}</h3>
                <p class="text-muted fs-5 mb-4">Price: <span class="text-success">{{ number_format($item->unit_price, 0, ',', '.') }} IDR</span></p>
                
                <!-- Description or Additional Information -->
                <div class="bg-light p-3 rounded-3 shadow-sm mb-4">
                    <p class="mb-0">Here you can add more details about the item, such as description, specifications, and additional features. This area can be used to give more context to the item.</p>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('itemAdmin') }}" class="btn btn-secondary w-50">
                        <i class="ri-arrow-left-line"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .image-container img {
        max-width: 100%;
        height: auto;
        object-fit: cover;
    }
    
    .card {
        background-color: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card h3 {
        font-size: 1.75rem;
        color: #333;
    }

    .card p {
        font-size: 1rem;
        color: #555;
    }

    .card .text-muted {
        color: #777;
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

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }

    .shadow-lg {
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
</style>
