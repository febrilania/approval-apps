@extends('layout.sarpras')

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
                                <a href="" class="btn btn-primary btn-sm" title="Detail">
                                    <i class="ri-edit-box-line"></i>
                                </a>
                                <a href="{{ route('approvesarpras', ['id' => $purchase_request->id]) }}"
                                    class="btn btn-success btn-sm" title="Approve">
                                    <i class="ri-file-list-3-line"></i>
                                </a>
                                <a href="{{ route('rejectSarpras', ['id' => $purchase_request->id]) }}"
                                    class="btn btn-danger btn-sm" title="Reject">
                                    <i class="ri-delete-bin-line"></i>
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