@extends('layout.sarpras')

<div class="main main-app p-3 p-lg-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a href="#">Sarpras</a></li>
        </ol>
        <h4 class="main-title mb-0">Item</h4>
    </div>
    <div class="my-3">
        <a href="{{ route('createItem') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Item
        </a>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center">No</th>
                        <th scope="col">Nama Barang</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col" class="text-center">Harga</th>
                        <th scope="col" class="text-center">Gambar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $index => $item)
                    <tr>
                        <th scope="row" class="text-center">{{ $index + 1 }}</th>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->description }}</td>
                        <td class="text-center">{{ 'Rp ' . number_format($item->unit_price, 2, ',', '.') }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/items/'.$item->image) }}" alt="gambar" class="rounded"
                                width="50" height="50">
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="alert alert-danger mb-0">
                                Data Barang belum Tersedia.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>