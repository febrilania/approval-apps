<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" href="{{ asset('Dashbyte/HTML/dist/assets/img/favicon.png') }}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.user')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Purchase Request</p>

        <!-- Button to trigger modal -->
        <div class="mb-2">
            <a href="{{ route('formPR.user') }}" class="btn btn-primary">Tambah Pengajuan</a>
        </div>

        <!-- Display success and error messages -->
        @if(session('success'))
        <div class="alert alert-success my-2">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger my-2">
            {{ session('error') }}
        </div>
        @endif

        <!-- Purchase Request Table -->
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Requestor</th>
                        <th scope="col">Lock</th>
                        <th scope="col">Status Berkas</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>

                </thead>
                <tbody>
                    @forelse($purchase_requests as $index => $purchase_request)
                    <tr>
                        <th scope="row">{{$index + 1}}</th>
                        <td>{{$purchase_request->user->name}}</td>
                        <td>
                            @if($purchase_request->created_at)
                            {{ $purchase_request->created_at->format('dmyHis') }}
                            @else
                            <span>Waktu belum diatur</span> <!-- Pesan ketika lock masih null -->
                            @endif
                        </td>
                        <td>{{$purchase_request->status_berkas}}</td>
                        <td class="text-center d-flex justify-content-center gap-3">
                            <!-- Detail Button -->
                            <a href="{{route('showPR.user', $purchase_request->id)}}" class="btn btn-success btn-sm"><i
                                    class="ri-file-list-3-line"></i> Detail</a>

                            <!-- Edit Button -->
                            <a href="{{route('formEditPurchaseRequest.user', $purchase_request->id)}}"
                                class="btn btn-primary btn-sm">
                                <i class="ri-edit-box-line"></i> Edit
                            </a>

                            <!-- Delete Button with Confirmation -->
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="confirmDelete(event, '{{ route('deletePurchaseRequest.user', $purchase_request->id) }}')">
                                <i class="ri-delete-bin-line"></i> Hapus
                            </a>

                            <!-- Tracking Button -->
                            <a href="{{ route('tracking.user', ['purchase_request_id' => $purchase_request->id]) }}"
                                class="btn btn-warning btn-sm">
                                <i class="ri-pin-distance-fill"></i> Tracking
                            </a>

                            <!-- Submit Button -->
                            <a href="{{route('ajukanPP.user', $purchase_request->id)}}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-right-circle-fill"></i> Ajukan
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak Ada Pengajuan.</td>
                    </tr>
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
            text: "Request ini akan dihapus secara permanen.",
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