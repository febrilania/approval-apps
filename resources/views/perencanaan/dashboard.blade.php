<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.perencanaan')
<div class="main main-app p-3 p-lg-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a href="#">Perencanaan</a></li>
        </ol>
        <h4 class="main-title mb-0">Welcome to Dashboard {{Auth::user()->name}}</h4>
    </div>
</div>