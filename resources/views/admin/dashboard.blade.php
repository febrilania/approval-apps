@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a href="#">Administrator</a></li>
        </ol>
        <h4 class="main-title mb-0">Welcome to Dashboard {{ Auth::user()->name }}</h4>
    </div>
    <div class="my-4">
        <div class="card">
            <div class="card-header bg-primary">
                Requests
            </div>
            <div class="card-body">
                <h5 class="card-title"><i class="ri-file-list-line"></i> Request</h5>
                <p class="card-text">Total Requests : {{ $requestCount }}</p> <!-- Menampilkan jumlah request -->
                <a href="{{route('purchaseRequest')}}" class="btn btn-primary">Lihat Request</a>
            </div>
        </div>
    </div>
    <div class="my-4">
        <div class="card">
            <div class="card-header bg-warning">
                Users
            </div>
            <div class="card-body">
                <h5 class="card-title"><i class="ri-user-line"></i>Users</h5>
                <p class="card-text">Total Users : {{ $usersCount }}</p> <!-- Menampilkan jumlah request -->
                <a href="{{route('user')}}" class="btn btn-primary">Lihat Users</a>
            </div>
        </div>
    </div>
</div>