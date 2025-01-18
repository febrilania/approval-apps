<!-- Tambahkan favicon -->
<link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">
<!-- Jika layout.admin punya bagian head -->
@extends('layout.pengadaan')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-3 p-lg-4">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Requestor</th>
                        <th scope="col">Lock</th>
                        <th scope="col">Status Berkas</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchase_requests as $index => $purchase_request)
                    @if ($purchase_request->status_berkas !== 'draft')
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $purchase_request->user->name }}</td>
                        <td>{{ $purchase_request->created_at->format('dmyHis') }}</td>
                        <td>
                            <span class="badge 
                                {{ $purchase_request->status_berkas === 'proses' ? 'bg-warning' : 'bg-success' }}">
                                {{ ucfirst($purchase_request->status_berkas) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{route('showPR.pengadaan', $purchase_request->id)}}"
                                    class="btn btn-primary btn-sm d-flex align-items-center gap-1" title="Detail">
                                    <i class="ri-file-list-3-line"></i> <span>Detail</span>
                                </a>
                                <a href="{{route('formEditPurchaseRequestPengadaan', $purchase_request->id)}}"
                                    class="btn btn-warning btn-sm d-flex align-items-center gap-1">
                                    <i class="ri-edit-box-line"></i> <span>Edit</span>
                                </a>
                                <a href="{{ route('approvepengadaan', ['id' => $purchase_request->id]) }}"
                                    class="btn btn-success btn-sm d-flex align-items-center gap-1" title="Approve">
                                    <i class="ri-check-fill"></i><span>Setujui</span>
                                </a>
                                <a href="{{ route('rejectPengadaan', ['id' => $purchase_request->id]) }}"
                                    class="btn btn-danger btn-sm d-flex align-items-center gap-1" title="Reject">
                                    <i class="ri-close-fill"></i><span>Tolak</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="alert alert-danger mb-0">
                                Tidak ada Pengajuan
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>