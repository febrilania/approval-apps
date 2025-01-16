<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" href="{{ asset('Dashbyte/HTML/dist/assets/img/U_P.png') }}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.user')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a href="#">User</a></li>
            </ol>
            <h4 class="main-title mb-0">Edit Profile {{Auth::user()->name}}</h4>
        </div>

        <form action="{{route('updateProfile')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control mb-2" name="name" value="{{old('name',$user->name) }}" id="nama">
            @error('name')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control mb-2" name="username" value="{{old('username',$user->username)}}"
                id="username">
            @error('username')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control mb-2" name="password"
                placeholder="Kosongkan saja jika tidak ingin mengganti Password" id="password">
            @error('password')
            <div>
                <small class="text-danger">{{$message}}</small>
            </div>
            @enderror
            <div class="mb-3">
                <label for="role" class="form-label">role</label>
                <select id="role" class="form-select" name="role_id" aria-label="Default select example" disabled>
                    <option value="" disabled>Pilih Role</option>
                    <option value="1" {{ old('role_id', $user->role_id) == 1 ? 'selected' : '' }}>Administrator</option>
                    <option value="2" {{ old('role_id', $user->role_id) == 2 ? 'selected' : '' }}>User</option>
                    <option value="3" {{ old('role_id', $user->role_id) == 3 ? 'selected' : '' }}>Sarpras</option>
                    <option value="4" {{ old('role_id', $user->role_id) == 4 ? 'selected' : '' }}>Perencanaan</option>
                    <option value="5" {{ old('role_id', $user->role_id) == 5 ? 'selected' : '' }}>Pengadaan Barang
                    </option>
                    <option value="6" {{ old('role_id', $user->role_id) == 6 ? 'selected' : '' }}>Wakil Rektor 2
                    </option>
                </select>
                <input type="hidden" name="role_id" value="{{ old('role_id', $user->role_id) }}">
                @error('role_id')
                <div>
                    <small class="text-danger">{{$message}}</small>
                </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                @error('profile_picture')
                <div>
                    <small class="text-danger">{{$message}}</small>
                </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success mt-3">Update User</button>
            <a href="{{route('dashboardUser')}}" class="btn btn-secondary mt-3">Cancel</a>
        </form>
    </div>
</div>