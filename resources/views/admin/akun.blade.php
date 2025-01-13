@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        @if(session('success'))
        <div class="alert alert-success my-2">
            {{ session('success') }}
        </div>
        @endif
        <p class="fw-bold fs-5">Akun</p>
        <!-- Tombol untuk memunculkan modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahAkunAnggaran">
            Tambah Akun Anggaran
        </button>

        <!-- Modal -->
        <div class="modal" id="modalTambahAkunAnggaran" tabindex="-1" aria-labelledby="modalTambahAkunAnggaranLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahAkunAnggaranLabel">Tambah Akun Anggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('akun.create') }}" method="post">
                            @csrf
                            @method('post')
                            <div class="mb-3">
                                <label for="akun" class="form-label">Akun Anggaran</label>
                                <input type="text" class="form-control" id="akun" name="nama_akun" required>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-4">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Akun</th>
                        <th colspan="2" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($akun as $index => $akun)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $akun->nama_akun }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditAkunAnggaran{{ $akun->id }}">
                                Edit
                            </button>
                        </td>

                        <!-- Modal Edit Akun Anggaran -->
                        <div class="modal fade" id="modalEditAkunAnggaran{{ $akun->id }}" tabindex="-1" aria-labelledby="modalEditAkunAnggaranLabel{{ $akun->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalEditAkunAnggaranLabel{{ $akun->id }}">Edit Akun Anggaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('akun.update', $akun->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="akun" class="form-label">Nama Akun</label>
                                                <input type="text" class="form-control" id="akun" name="nama_akun" value="{{ $akun->nama_akun }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <td class="text-center">
                            <form action="{{ route('akun.delete', $akun->id) }}" method="post" id="deleteForm{{ $akun->id }}">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-danger" onclick="confirmDelete(event, {{ $akun->id }})">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-danger">Data Akun belum tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(event, akunId) {
        event.preventDefault(); // Prevent default form submission

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Akun ini akan dihapus secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, submit the form with the delete request
                document.getElementById('deleteForm' + akunId).submit();
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
