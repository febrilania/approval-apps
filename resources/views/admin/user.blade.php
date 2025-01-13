@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <div class="mb-3">
            <!-- Breadcrumb Navigation -->
            <ol class="breadcrumb fs-sm mb-1">
                <li class="breadcrumb-item"><a href="#">Administrator</a></li>
                <li class="breadcrumb-item active" aria-current="page">User</li>
            </ol>
            <h4 class="main-title mb-0">User</h4>
        </div>

        <!-- Button to Add User -->
        <div class="my-3">
            <a href="{{ route('addUser') }}" class="btn btn-primary">Tambah User</a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <!-- User Table -->
        <div>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $index => $user)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->role_name }}</td>
                            <td class="text-center">
                                <!-- Detail Button -->
                                <a href="" class="btn btn-success btn-sm">
                                    <i class="ri-file-list-3-line"></i> Detail
                                </a>
                                
                                <!-- Edit Button -->
                                <a href="{{ route('editUser', $user->id) }}" class="btn btn-primary btn-sm">
                                    <i class="ri-edit-box-line"></i> Edit
                                </a>
                                
                                <!-- Delete Button with Confirmation -->
                                <a href="#" class="btn btn-danger btn-sm"
                                   onclick="confirmDelete(event, '{{ route('destroyUser', $user->id) }}')">
                                   <i class="ri-delete-bin-line"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak Ada Data User.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 for Confirmation -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, url) {
        event.preventDefault(); // Prevent the default action

        // Show SweetAlert2 confirmation dialog
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
                // If confirmed, create a form to send DELETE request
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = url;

                // CSRF Token
                var csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}'; // CSRF Token from Blade template

                // Method Input to indicate DELETE
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
