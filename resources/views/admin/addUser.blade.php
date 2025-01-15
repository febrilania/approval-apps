<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Tambah User</p>
        <form action="{{route('registerUser')}}" method="post" enctype="multipart/form-data">
            @csrf
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control mb-2" name="name" value="{{old('name')}}" id="nama">
            @error('name')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control mb-2" name="username" value="{{old('username')}}" id="username">
            @error('username')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control mb-2" name="password" value="{{old('password')}}" id="password">
            @error('password')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <div class="mb-3">
                <label for="role" class="form-label">role</label>
                <select id="role" class="form-select" name="role_id" aria-label="Default select example">
                    <option selected>Open this select menu</option>
                    <option value="1">Administrator</option>
                    <option value="2">User</option>
                    <option value="3">Sarpras</option>
                    <option value="4">Perencanaan</option>
                    <option value="5">Pengadaan Barang</option>
                    <option value="6">Wakil Rektor 2</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control"
                    accept="profile_picture/*" onchange="previewImage(event)">
                @error('profile_picture')
                <div>
                    <small class="text-danger">{{$message}}</small>
                </div>
                @enderror
            </div>

            <div class="mb-3">
                <img id="image_preview" src="#" alt="Image Preview" style="display: none; max-width: 200px;">
            </div>
            <button type="submit" class="btn btn-success mt-3">Tambah Data</button>
            <a href="{{ route('user') }}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>
<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('image_preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>