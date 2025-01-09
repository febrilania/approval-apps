@extends('layout.warek')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-3 p-lg-4">
        @if(session('success'))
        <div class="alert alert-success my-2">
            {{ session('success') }}
        </div>
        @endif
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
                        <div>Approve</div>
                        <div>Reject</div>
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
                        <a href="" class="btn btn-primary"><i class="ri-edit-box-line"></i></a>
                        <a href="{{route('approveWarek',['id' => $purchase_request->id])}}" class="btn btn-success"><i
                                class="ri-file-list-3-line"></i></a>
                        <a href="{{route('rejectWarek',['id'=> $purchase_request->id])}}" class="btn btn-danger"><i
                                class="ri-delete-bin-line"></i></a>
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