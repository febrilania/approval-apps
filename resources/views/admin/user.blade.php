@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <div>
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a href="#">Administrator</a></li>
            </ol>
            <h4 class="main-title mb-0">User</h4>
        </div>
        <div class="my-3">
            <a href="{{route('addUser')}}" class="btn btn-primary">Tambah User</a>
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div>
            <div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Role</th>
                            <th scope="col">
                                <div class="text-center">Aksi</div>
                            </th>
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col">
                                <div class="text-center d-flex justify-content-center gap-2">
                                    <div>Detail</div>
                                    <div>Edit</div>
                                    <div>Delete</div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <th scope="row">{{$index + 1}}</th>
                            <td>{{$user->name}}</td>
                            <td>{{$user->role->role_name}}</td>
                            <td class="text-center">
                                <a href="" class="btn btn-success"><i class="ri-file-list-3-line"></i></a>
                                <a href="{{route('editUser', $user->id)}}" class="btn btn-primary"><i
                                        class="ri-edit-box-line"></i></a>
                                <a href="#" class="btn btn-danger"
                                    onclick="confirmDelete(event, '{{ route('destroyUser', $user->id) }}')">
                                    <i class="ri-delete-bin-line"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <div class="alert alert-danger">
                            Data Barang belum Tersedia.
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, url) {
        event.preventDefault(); // Mencegah perilaku default dari tautan
    
        // Menampilkan SweetAlert2 konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengonfirmasi, kirim permintaan DELETE
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
    
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}'; // Token CSRF dari Blade template
    
                var methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
    
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
    
                document.body.appendChild(form);
                form.submit();
            }
        });
    }
    </script>