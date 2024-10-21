@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fw-bold fs-5">Kategori</p>
        <div>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah Kategori
            </button>
            @if(session('success'))
            <div class="alert alert-success my-2">
                {{ session('success') }}
            </div>
            @endif

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Kategori</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{route('addCategory')}}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="category_name" class="form-label">Nama Kategori</label>
                                    <input type="string" class="form-control" id="category_name" name="category_name"
                                        value="{{old('category_name')}}">
                                </div>
                            </div>
                            @error('category_name')
                            <div>
                                <small class="text-danger">{{$message}}</small>
                            </div>
                            @enderror
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">
                        <div class="text-center">Aksi</div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->category_name }}</td>
                    <td class="text-center">
                        <!-- Button trigger edit modal -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $category->id }}">
                            <i class="ri-edit-box-line"></i>
                        </button>
                        <a href="#" class="btn btn-danger"
                            onclick="confirmDelete(event, '{{ route('deleteCategory', $category->id) }}')">
                            <i class="ri-delete-bin-line"></i>
                        </a>
                    </td>
                </tr>

                <!-- Modal Edit -->
                <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel{{ $category->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $category->id }}">Edit Kategori</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('editCategory', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="category_name{{ $category->id }}" class="form-label">Nama
                                            Kategori</label>
                                        <input type="text" class="form-control" id="category_name{{ $category->id }}"
                                            name="category_name" value="{{ $category->category_name }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @empty
                <tr>
                    <td colspan="3" class="text-center">Kategori tidak ada.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(event, url) {
        event.preventDefault(); // Mencegah perilaku default dari tautan
    
        // Menampilkan SweetAlert2 konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Kategori ini akan dihapus secara permanen.",
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