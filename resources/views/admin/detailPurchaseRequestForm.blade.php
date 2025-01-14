<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" href="{{ asset('Dashbyte/HTML/dist/assets/img/favicon.png') }}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Add Request</p>

        <!-- Form Add Request -->
        <form id="addRequestForm">
            @csrf
            <div class="mb-3">
                <label for="item_id" class="form-label">Item</label>
                <select name="item_id" id="item_id" class="form-control">
                    @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->item_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="akun_anggaran_id" class="form-label">Akun Anggaran</label>
                <select name="akun_anggaran_id" id="akun_anggaran_id" class="form-control">
                    @foreach($akun_anggaran as $akun)
                    <option value="{{ $akun->id }}">{{ $akun->nama_akun }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input class="form-control" type="number" name="quantity" id="quantity">
            </div>
            <div class="mb-3">
                <label for="harga_pengajuan" class="form-label">Harga Pengajuan</label>
                <input class="form-control" type="number" name="harga_pengajuan" id="harga_pengajuan" step="0.01">
            </div>
            <div class="mb-3">
                <label for="alasan_pembelian" class="form-label">Alasan Pembelian</label>
                <input class="form-control" type="text" name="alasan_pembelian" id="alasan_pembelian">
            </div>
            <div class="mb-3">
                <label class="form-label" for="rencana_penempatan">Rencana Penempatan</label>
                <input class="form-control" type="text" name="rencana_penempatan" id="rencana_penempatan">
            </div>
            <div class="mb-3">
                <label class="form-label" for="catatan">Catatan</label>
                <input class="form-control" type="text" name="catatan" id="catatan">
            </div>
            <button class="btn btn-primary" type="submit">Add Request</button>
        </form>

        <!-- Tampilkan Detail Purchase Request -->
        <h4 class="mt-4">Detail Request</h4>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Harga Pengajuan</th>
                    <th>Alasan Pembelian</th>
                    <th>Rencana Penempatan</th>
                    <th>Akun Anggaran</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody id="detailsTableBody">
                <!-- Detail request akan ditambahkan di sini -->
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addRequestForm').on('submit', function(e) {
            e.preventDefault(); // Mencegah form reload halaman

            $.ajax({
                type: 'POST',
                url: '{{ route('addPurchaseRequest') }}', // Route untuk menambah detail
                data: $(this).serialize(),
                success: function(response) {
                    // Tambahkan detail ke dalam tabel tanpa reload halaman
                    var newRow = `
                        <tr>
                            <td>${response.item_name}</td>
                            <td>${response.quantity}</td>
                            <td>${response.harga_pengajuan}</td>
                            <td>${response.alasan_pembelian}</td>
                            <td>${response.rencana_penempatan}</td>
                            <td>${response.akun_anggaran_name}</td>
                            <td>${response.catatan}</td>
                        </tr>
                    `;
                    $('#detailsTableBody').append(newRow);

                    // Kosongkan form setelah berhasil menambah item
                    $('#addRequestForm')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script>