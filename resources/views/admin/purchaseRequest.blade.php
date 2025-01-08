@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Purchase Request</p>
        <div class="mb-2">
            <!-- Button trigger modal -->
            <a href="{{route('purchaseRequestForm')}}" class="btn btn-primary">Tambah Pengajuan</a>

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
        </div>

        {{-- daftar request --}}
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
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>

                    <th scope="col">
                        <div class="d-flex justify-content-center gap-3">
                            <div>Detail</div>
                            <div>Edit</div>
                            <div>Delete</div>
                            <div>Tracking</div>
                            <div>Ajukan</div>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchase_requests as $index => $purchase_request)
                <tr>
                    <th scope="row">{{$index + 1}}</th>
                    <td>{{$purchase_request->user->name}}</td>
                    <td> @if($purchase_request->created_at)
                        {{ $purchase_request->created_at->format('dmyHis') }}
                        @else
                        <span>Waktu belum diatur</span> <!-- Pesan ketika lock masih null -->
                        @endif
                    </td>
                    <td>{{$purchase_request->status_berkas}}</td>
                    <td class="text-center d-flex justify-content-center gap-3">
                        <a href="" class="btn btn-success"><i class="ri-file-list-3-line"></i></a>
                        <a href="" class="btn btn-primary"><i class="ri-edit-box-line"></i></a>
                        <a href="" class="btn btn-danger"><i class="ri-delete-bin-line"></i></a>
                        <a href="{{ route('trackingAdmin', ['purchase_request_id' => $purchase_request->id]) }}"
                            class="btn btn-warning">
                            <i class="ri-pin-distance-fill"></i>
                        </a>
                        <a href="{{route('ajukanPP',$purchase_request->id)}}" class="btn btn-secondary"><i
                                class="ri-arrow-right-circle-fill"></i></a>
                    </td>
                </tr>
                @empty
                <div class="alert alert-danger">
                    Tidak Ada Pengajuan.
                </div>
                @endforelse
            </tbody>
        </table>
    </div>
</div>