@extends('layout.user')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-3 p-lg-4">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Requestor</th>
                    <th scope="col">Lock</th>
                    <th scope="col">Status Berkas</th>
                    <th scope="col">
                        <div class="text-center">Aksi</div>
                    </th>
                </tr>
            </thead>
            <tr>
                <td scope="col"></td>
                <td scope="col"></td>
                <td scope="col"></td>
                <td scope="col"></td>
                <td scope="col">
                    <div class="text-center d-flex justify-content-center gap-2">
                        <div>Detail</div>
                        <div>Tolak</div>
                        <div>Terima</div>
                    </div>
                </td>
            </tr>
            <tbody>
                @forelse ($purchase_requests as $index => $purchase_request)
                @if ($purchase_request->status_berkas !== 'draft')
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $purchase_request->user->name }}</td>
                    <td>{{ $purchase_request->created_at->format('dmyHis') }}</td>
                    <td>{{ $purchase_request->status_berkas }}</td>
                    <td class="text-center">
                        <a href="" class="btn btn-success"><i class="ri-file-list-3-line"></i></a>
                        <a href="" class="btn btn-primary"><i class="ri-edit-box-line"></i></a>
                        <a href="" class="btn btn-danger"><i class="ri-delete-bin-line"></i></a>
                    </td>
                </tr>
                @endif
                @empty
                <div class="alert alert-danger">
                    tidak ada Pengajuan
                </div>
                @endforelse
            </tbody>
        </table>
    </div>
</div>