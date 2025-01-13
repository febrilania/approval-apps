@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a href="#">Administrator</a></li>
        </ol>
        <h4 class="main-title mb-0">Item</h4>
    </div>

    <div class="my-3">
        <a href="{{ route('createItem') }}" class="btn btn-primary">Tambah Item</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Gambar</th>
                    <th scope="col" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $index => $item)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ 'Rp ' . number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td>
                            <img width="50px" height="50px" src="{{ asset('storage/items/'.$item->image) }}" alt="gambar">
                        </td>
                        <td class="text-center">
                            <a href="{{ route('detailItem', $item->id) }}" class="btn btn-info btn-sm">
                                <i class="ri-file-list-3-line"></i> Detail
                            </a>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                <i class="ri-edit-box-line"></i> Edit
                            </button>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(event, '{{ route('destroyItem', $item->id) }}')">
                                <i class="ri-delete-bin-line"></i> Hapus
                            </a>
                        </td>
                    </tr>

                    <!-- Modal Edit Item -->
                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Item</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('editItem', $item->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="item_name{{ $item->id }}" class="form-label">Nama Item</label>
                                            <input type="text" class="form-control" id="item_name{{ $item->id }}" name="item_name" value="{{ $item->item_name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="category_id{{ $item->id }}" class="form-label">Kategori</label>
                                            <select class="form-control" id="category_id{{ $item->id }}" name="category_id">
                                                <option value="">Pilih Kategori</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $item->category_id === $category->id ? 'selected' : '' }}>
                                                        {{ $category->category_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description{{ $item->id }}" class="form-label">Deskripsi</label>
                                            <textarea class="form-control" id="description{{ $item->id }}" name="description" rows="3">{{ $item->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="unit_price{{ $item->id }}" class="form-label">Harga</label>
                                            <input type="number" class="form-control" id="unit_price{{ $item->id }}" name="unit_price" value="{{ $item->unit_price }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="image{{ $item->id }}" class="form-label">Gambar</label>
                                            <input type="file" class="form-control" id="image{{ $item->id }}" name="image">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Perbarui Item</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger">Data Item belum Tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, url) {
        event.preventDefault(); // Mencegah perilaku default dari tautan
    
        // Menampilkan SweetAlert2 konfirmasi
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Item ini akan dihapus secara permanen.",
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
