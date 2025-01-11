@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <div class="container">
            <h1>Edit Purchase Request</h1>
            <form action="#" method="POST">
                @csrf
                @method('PUT') <!-- Karena ini adalah form edit, kita gunakan method PUT -->

                <!-- Form untuk data Purchase Request -->
                <div class="form-group">
                    <label for="requestor_id">Requestor ID</label>
                    <input type="text" class="form-control" id="requestor_id" name="requestor_id" value="{{ $purchaseRequest->requestor_id }}" required>
                </div>

                <div class="form-group">
                    <label for="status_berkas">Status Berkas</label>
                    <select class="form-control" id="status_berkas" name="status_berkas" required>
                        <option value="pending" {{ $purchaseRequest->status_berkas == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $purchaseRequest->status_berkas == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ $purchaseRequest->status_berkas == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="draft" {{ $purchaseRequest->status_berkas == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="file_nota">File Nota</label>
                    <input type="text" class="form-control" id="file_nota" name="file_nota" value="{{ $purchaseRequest->file_nota }}">
                </div>

                <div class="form-group">
                    <label for="pengajuan">Pengajuan</label>
                    <input type="number" step="0.01" class="form-control" id="pengajuan" name="pengajuan" value="{{ $purchaseRequest->pengajuan }}" required>
                </div>

                <div class="form-group">
                    <label for="pembelian">Pembelian</label>
                    <input type="number" step="0.01" class="form-control" id="pembelian" name="pembelian" value="{{ $purchaseRequest->pembelian }}" required>
                </div>

                <!-- Tabel untuk menampilkan detail Purchase Request -->
                <h3>Details</h3>
                <table class="table table-bordered" id="details-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Status Barang</th>
                            <th>Alasan Pembelian</th>
                            <th>Rencana Penempatan</th>
                            <th>Akun Anggaran</th>
                            <th>Harga Pengajuan</th>
                            <th>Harga Pengajuan Total</th>
                            <th>Harga Pembelian</th>
                            <th>Harga Total</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($details as $detail)
                        <tr>
                            <td>
                                <select name="item_id[]" class="form-control" required>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $detail->item_id == $item->id ? 'selected' : '' }}>{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" class="form-control" name="quantity[]" value="{{ $detail->quantity }}" required>
                            </td>
                            <td>
                                <select name="status_barang[]" class="form-control" required>
                                    <option value="pending" {{ $detail->status_barang == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $detail->status_barang == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ $detail->status_barang == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="alasan_pembelian[]" value="{{ $detail->alasan_pembelian }}" required>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="rencana_penempatan[]" value="{{ $detail->rencana_penempatan }}" required>
                            </td>
                            <td>
                                <select name="akun_anggaran_id[]" class="form-control" required>
                                    @foreach($akun_anggaran as $akun)
                                    <option value="{{ $akun->id }}" {{ $detail->akun_anggaran_id == $akun->id ? 'selected' : '' }}>{{ $akun->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="harga_pengajuan[]" value="{{ $detail->harga_pengajuan }}" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="harga_pengajuan_total[]" value="{{ $detail->harga_pengajuan_total }}" readonly>
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="harga_pembelian[]" value="{{ $detail->harga_pembelian }}">
                            </td>
                            <td>
                                <input type="number" step="0.01" class="form-control" name="harga_total[]" value="{{ $detail->harga_total }}" readonly>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="catatan[]" value="{{ $detail->catatan }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Tombol untuk menambahkan detail baru -->
                <button type="button" class="btn btn-success" id="add-detail">Tambah Detail</button>

                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Update Purchase Request</button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Mendapatkan data items dan akun_anggaran dari view
    const items = @json($items);
    const akunAnggaran = @json($akun_anggaran);

    // Fungsi untuk menambahkan baris detail baru
    document.getElementById('add-detail').addEventListener('click', function () {
        const table = document.getElementById('details-table').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();

        // Kolom Item
        const itemCell = newRow.insertCell();
        const itemSelect = document.createElement('select');
        itemSelect.name = 'item_id[]';
        itemSelect.className = 'form-control';
        itemSelect.required = true;

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.text = item.item_name; // Ganti dengan field item_name yang benar
            itemSelect.appendChild(option);
        });
        itemCell.appendChild(itemSelect);

        // Kolom Quantity
        const quantityCell = newRow.insertCell();
        const quantityInput = document.createElement('input');
        quantityInput.type = 'number';
        quantityInput.name = 'quantity[]';
        quantityInput.className = 'form-control';
        quantityInput.required = true;
        quantityCell.appendChild(quantityInput);

        // Kolom Status Barang
        const statusCell = newRow.insertCell();
        const statusSelect = document.createElement('select');
        statusSelect.name = 'status_barang[]';
        statusSelect.className = 'form-control';
        statusSelect.required = true;
        ['pending', 'approved', 'rejected'].forEach(status => {
            const option = document.createElement('option');
            option.value = status;
            option.text = status.charAt(0).toUpperCase() + status.slice(1);
            statusSelect.appendChild(option);
        });
        statusCell.appendChild(statusSelect);

        // Kolom Alasan Pembelian
        const alasanCell = newRow.insertCell();
        const alasanInput = document.createElement('input');
        alasanInput.type = 'text';
        alasanInput.name = 'alasan_pembelian[]';
        alasanInput.className = 'form-control';
        alasanInput.required = true;
        alasanCell.appendChild(alasanInput);

        // Kolom Rencana Penempatan
        const rencanaCell = newRow.insertCell();
        const rencanaInput = document.createElement('input');
        rencanaInput.type = 'text';
        rencanaInput.name = 'rencana_penempatan[]';
        rencanaInput.className = 'form-control';
        rencanaInput.required = true;
        rencanaCell.appendChild(rencanaInput);

        // Kolom Akun Anggaran
        const akunCell = newRow.insertCell();
        const akunSelect = document.createElement('select');
        akunSelect.name = 'akun_anggaran_id[]';
        akunSelect.className = 'form-control';
        akunSelect.required = true;
        akunAnggaran.forEach(akun => {
            const akunOption = document.createElement('option');
            akunOption.value = akun.id;
            akunOption.text = akun.name; // Ganti dengan field name yang benar
            akunSelect.appendChild(akunOption);
        });
        akunCell.appendChild(akunSelect);

        // Kolom Harga Pengajuan
        const hargaPengajuanCell = newRow.insertCell();
        const hargaPengajuanInput = document.createElement('input');
        hargaPengajuanInput.type = 'number';
        hargaPengajuanInput.step = '0.01';
        hargaPengajuanInput.name = 'harga_pengajuan[]';
        hargaPengajuanInput.className = 'form-control';
        hargaPengajuanInput.required = true;
        hargaPengajuanCell.appendChild(hargaPengajuanInput);

        // Kolom Harga Pengajuan Total
        const hargaPengajuanTotalCell = newRow.insertCell();
        const hargaPengajuanTotalInput = document.createElement('input');
        hargaPengajuanTotalInput.type = 'number';
        hargaPengajuanTotalInput.step = '0.01';
        hargaPengajuanTotalInput.name = 'harga_pengajuan_total[]';
        hargaPengajuanTotalInput.className = 'form-control';
        hargaPengajuanTotalInput.readOnly = true;
        hargaPengajuanTotalCell.appendChild(hargaPengajuanTotalInput);

        // Kolom Harga Pembelian
        const hargaPembelianCell = newRow.insertCell();
        const hargaPembelianInput = document.createElement('input');
        hargaPembelianInput.type = 'number';
        hargaPembelianInput.step = '0.01';
        hargaPembelianInput.name = 'harga_pembelian[]';
        hargaPembelianInput.className = 'form-control';
        hargaPembelianCell.appendChild(hargaPembelianInput);

        // Kolom Harga Total
        const hargaTotalCell = newRow.insertCell();
        const hargaTotalInput = document.createElement('input');
        hargaTotalInput.type = 'number';
        hargaTotalInput.step = '0.01';
        hargaTotalInput.name = 'harga_total[]';
        hargaTotalInput.className = 'form-control';
        hargaTotalInput.readOnly = true;
        hargaTotalCell.appendChild(hargaTotalInput);

        // Kolom Catatan
        const catatanCell = newRow.insertCell();
        const catatanInput = document.createElement('input');
        catatanInput.type = 'text';
        catatanInput.name = 'catatan[]';
        catatanInput.className = 'form-control';
        catatanCell.appendChild(catatanInput);

        // Kolom Aksi (Tombol Hapus)
        const aksiCell = newRow.insertCell();
        const removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.className = 'btn btn-danger btn-sm remove-row';
        removeButton.textContent = 'Hapus';
        removeButton.addEventListener('click', function () {
            table.deleteRow(newRow.rowIndex - 1);
        });
        aksiCell.appendChild(removeButton);
    });

    // Fungsi untuk menghapus baris detail
    document.querySelectorAll('.remove-row').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            row.remove();
        });
    });
});
</script>
