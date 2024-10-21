@extends('layout.warek')
<div class="main main-app p-3 p-lg-4">
    <div>
        <ol class="breadcrumb fs-sm mb-1">
            <li class="breadcrumb-item"><a href="#">Wakil Rektor 2</a></li>
        </ol>
        <h4 class="main-title mb-0">Item</h4>
    </div>
    <div class="my-3">
        <a href="{{route('createItem')}}" class="btn btn-primary">Tambah Item</a>
    </div>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Barang</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Gambar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $index => $item)
                <tr>
                    <th scope="row">{{$index + 1}}</th>
                    <td>{{$item->item_name}}</td>
                    <td>{{$item->description}}</td>
                    <td>{{ 'Rp ' . number_format($item->unit_price, 2, ',', '.') }}</td>
                    <td colspan="2">
                        <img width="50px" height="50px" src="{{asset('storage/items/'.$item->image)}}" alt="gambar">
                    </td>
                </tr>
                @empty
                <div class="alert alert-danger">
                    Data Barang belum Tersedia.
                </div>
                @endforelse
            </tbody>
        </table>
    </div>
</div>