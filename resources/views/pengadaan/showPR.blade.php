<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.pengadaan')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <!-- Header -->
        <p class="fs-3 fw-bolder">Detail Pengajuan</p>
        <a href="javascript:history.back()"
            class="btn btn-secondary d-flex align-items-center gap-1 justify-content-center">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
        <hr>
        <!-- Informasi Pengajuan -->
        <div class="row mb-4">
            <div class="col-lg-6 mb-3">
                <div class="card shadow-sm border-0">

                    <div class="card-body">
                        <h5 class="card-title">Informasi Pengajuan</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Requestor:</strong> {{ $purchase_request->user->name }}
                            </li>
                            <li class="list-group-item"><strong>Status Berkas:</strong> {{
                                $purchase_request->status_berkas }}</li>
                            <li class="list-group-item"><strong>Pengajuan:</strong> {{ $purchase_request->pengajuan }}
                            </li>
                            <li class="list-group-item"><strong>Pembelian:</strong> {{ $purchase_request->pembelian }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="card-title">File Nota</h5>
                        @if($purchase_request->file_nota)
                        <img src="{{ asset('storage/'.$purchase_request->file_nota) }}" alt="File Nota"
                            class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                        @else
                        <p class="text-muted">Tidak ada file nota yang diunggah.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <!-- Detail Barang -->
        <p class="fs-5 fw-normal">Detail Barang</p>
        <div class="row">
            @foreach($purchase_request->purchaseRequestDetails as $detail)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card shadow-sm h-100 border-0">
                    <img src="{{ asset('storage/items/'. $detail->item->image) }}" alt="Gambar Barang"
                        class="card-img-top" style="width: 100%; height: 200px; object-fit: contain;">
                    <div class="card-body">
                        <h5 class="card-title text-truncate">{{ $detail->item->item_name }}</h5>
                        <p class="card-text text-muted">{{ $detail->item->description }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Harga:</strong> {{ $detail->item->unit_price }}</li>
                            <li class="list-group-item"><strong>Jumlah:</strong> {{ $detail->quantity }}</li>
                            <li class="list-group-item"><strong>Status Barang:</strong> {{ $detail->status_barang }}
                            </li>
                            <li class="list-group-item"><strong>Alasan:</strong> {{ $detail->alasan_pembelian ?? '-' }}
                            </li>
                            <li class="list-group-item"><strong>Akun Anggaran:</strong> {{
                                $detail->akunAnggaran->nama_akun ?? '-' }}</li>
                            <li class="list-group-item"><strong>Harga Pengajuan:</strong> {{ $detail->harga_pengajuan }}
                            </li>
                            <li class="list-group-item"><strong>Total Pengajuan:</strong> {{
                                $detail->harga_pengajuan_total }}</li>
                            <li class="list-group-item"><strong>Harga Pembelian:</strong> {{ $detail->harga_pembelian }}
                            </li>
                            <li class="list-group-item"><strong>Total:</strong> {{ $detail->harga_total }}</li>
                        </ul>
                    </div>
                    <div class="card-footer text-muted">
                        <small>Catatan: {{ $detail->catatan ?? 'Tidak ada catatan' }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>