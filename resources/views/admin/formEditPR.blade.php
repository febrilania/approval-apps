@extends('layout.admin')

<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <div class="container">
            <h1>Edit Purchase Request</h1>
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('purchaseRequest.update', $purchaseRequest->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Requestor -->
                <div class="form-group my-3">
                    <label for="requestor_id">Requestor</label>
                    <input type="text" class="form-control" id="requestor_id" name="requestor_id"
                        value="{{ $purchaseRequest->user->name }}" required disabled>
                </div>

                <!-- Status Berkas -->
                <div class="form-group my-3">
                    <label for="status_berkas">Status Berkas</label>
                    <select class="form-control" id="status_berkas" name="status_berkas" disabled>
                        <option value="pending" {{ $purchaseRequest->status_berkas == 'pending' ? 'selected' : ''
                            }}>Pending</option>
                        <option value="approved" {{ $purchaseRequest->status_berkas == 'approved' ? 'selected' : ''
                            }}>Approved</option>
                        <option value="rejected" {{ $purchaseRequest->status_berkas == 'rejected' ? 'selected' : ''
                            }}>Rejected</option>
                        <option value="draft" {{ $purchaseRequest->status_berkas == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                    </select>
                </div>

                <!-- File Nota -->
                <div class="form-group my-3">
                    <label for="file_nota">File Nota</label>
                    <input type="file" class="form-control @error('file_nota') is-invalid @enderror" id="file_nota"
                        name="file_nota">
                    @error('file_nota')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pengajuan -->
                <div class="form-group my-3">
                    <label for="pengajuan">Pengajuan</label>
                    <input type="number" step="0.01" class="form-control @error('pengajuan') is-invalid @enderror"
                        id="pengajuan" name="pengajuan" value="{{ old('pengajuan', $purchaseRequest->pengajuan) }}">
                    @error('pengajuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pembelian -->
                <div class="form-group my-3">
                    <label for="pembelian">Pembelian</label>
                    <input type="number" step="0.01" class="form-control @error('pembelian') is-invalid @enderror"
                        id="pembelian" name="pembelian" value="{{ old('pembelian', $purchaseRequest->pembelian) }}">
                    @error('pembelian')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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
                        @foreach($details as $index => $detail)
                        <tr>
                            <input type="hidden" name="detail_id[]" value="{{ $detail->id }}">

                            <!-- Item -->
                            <td>
                                <select name="item_id[]"
                                    class="form-control @error('item_id.' . $index) is-invalid @enderror" required>
                                    @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $detail->item_id == $item->id ? 'selected' : ''
                                        }}>{{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                                @error('item_id.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Quantity -->
                            <td>
                                <input type="number"
                                    class="form-control @error('quantity.' . $index) is-invalid @enderror"
                                    name="quantity[]" value="{{ old('quantity.' . $index, $detail->quantity) }}"
                                    required>
                                @error('quantity.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Status Barang -->
                            <td>
                                <select name="status_barang[]"
                                    class="form-control @error('status_barang.' . $index) is-invalid @enderror">
                                    <option value="pending" {{ $detail->status_barang == 'pending' ? 'selected' : ''
                                        }}>Pending</option>
                                    <option value="approved" {{ $detail->status_barang == 'approved' ? 'selected' : ''
                                        }}>Approved</option>
                                    <option value="rejected" {{ $detail->status_barang == 'rejected' ? 'selected' : ''
                                        }}>Rejected</option>
                                </select>
                                @error('status_barang.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Alasan Pembelian -->
                            <td>
                                <input type="text"
                                    class="form-control @error('alasan_pembelian.' . $index) is-invalid @enderror"
                                    name="alasan_pembelian[]"
                                    value="{{ old('alasan_pembelian.' . $index, $detail->alasan_pembelian) }}">
                                @error('alasan_pembelian.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Rencana Penempatan -->
                            <td>
                                <input type="text"
                                    class="form-control @error('rencana_penempatan.' . $index) is-invalid @enderror"
                                    name="rencana_penempatan[]"
                                    value="{{ old('rencana_penempatan.' . $index, $detail->rencana_penempatan) }}">
                                @error('rencana_penempatan.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Akun Anggaran -->
                            <td>
                                <select name="akun_anggaran_id[]"
                                    class="form-control @error('akun_anggaran_id.' . $index) is-invalid @enderror">
                                    @foreach($akun_anggaran as $akun)
                                    <option value="{{ $akun->id }}" {{ $detail->akun_anggaran_id == $akun->id ?
                                        'selected' : '' }}>
                                        {{ $akun->nama_akun }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('akun_anggaran_id.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Harga Pengajuan -->
                            <td>
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_pengajuan.' . $index) is-invalid @enderror"
                                    name="harga_pengajuan[]"
                                    value="{{ old('harga_pengajuan.' . $index, $detail->harga_pengajuan) }}">
                                @error('harga_pengajuan.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Harga Pengajuan Total -->
                            <td>
                                <input type="number" step="0.01" class="form-control" name="harga_pengajuan_total[]"
                                    value="{{ $detail->harga_pengajuan_total }}" readonly>
                            </td>

                            <!-- Harga Pembelian -->
                            <td>
                                <input type="number" step="0.01"
                                    class="form-control @error('harga_pembelian.' . $index) is-invalid @enderror"
                                    name="harga_pembelian[]"
                                    value="{{ old('harga_pembelian.' . $index, $detail->harga_pembelian) }}">
                                @error('harga_pembelian.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Harga Total -->
                            <td>
                                <input type="number" step="0.01" class="form-control" name="harga_total[]"
                                    value="{{ $detail->harga_total }}" readonly>
                            </td>

                            <!-- Catatan -->
                            <td>
                                <input type="text" class="form-control @error('catatan.' . $index) is-invalid @enderror"
                                    name="catatan[]" value="{{ old('catatan.' . $index, $detail->catatan) }}">
                                @error('catatan.' . $index)
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </td>

                            <!-- Aksi -->
                            <td>
                                <a href="{{ route('purchaseRequest.deleteDetail', [$purchaseRequest->id, $detail->id]) }}"
                                    class="btn btn-danger btn-sm remove-row">
                                    Hapus
                                </a>

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
            akunSelect.required = false;

            akunAnggaran.forEach(akun => {
                const option = document.createElement('option');
                option.value = akun.id;
                option.text = akun.nama_akun; // Ganti dengan field nama_akun yang benar
                akunSelect.appendChild(option);
            });
            akunCell.appendChild(akunSelect);

            // Kolom Harga Pengajuan
            const hargaPengajuanCell = newRow.insertCell();
            const hargaPengajuanInput = document.createElement('input');
            hargaPengajuanInput.type = 'number';
            hargaPengajuanInput.step = '0.01';
            hargaPengajuanInput.name = 'harga_pengajuan[]';
            hargaPengajuanInput.className = 'form-control';
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

            // Kolom Aksi
            const actionCell = newRow.insertCell();
            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'btn btn-danger btn-sm remove-row';
            removeButton.innerText = 'Hapus';
            removeButton.addEventListener('click', function () {
                newRow.remove();
            });
            actionCell.appendChild(removeButton);
        });

        // Event listener untuk menghitung total otomatis
        document.addEventListener('input', function (e) {
            const target = e.target;
            if (target.name === 'quantity[]' || target.name === 'harga_pengajuan[]' || target.name === 'harga_pembelian[]') {
                const row = target.closest('tr');
                const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                const hargaPengajuan = parseFloat(row.querySelector('input[name="harga_pengajuan[]"]').value) || 0;
                const hargaPembelian = parseFloat(row.querySelector('input[name="harga_pembelian[]"]').value) || 0;

                // Hitung total pengajuan dan total pembelian
                const totalPengajuan = quantity * hargaPengajuan;
                const totalPembelian = quantity * hargaPembelian;

                // Set nilai total pada kolom yang sesuai
                row.querySelector('input[name="harga_pengajuan_total[]"]').value = totalPengajuan.toFixed(2);
                row.querySelector('input[name="harga_total[]"]').value = totalPembelian.toFixed(2);
            }
        });

        // Validasi form sebelum submit
        document.querySelector('form').addEventListener('submit', function (e) {
            let isValid = true;

            document.querySelectorAll('tr').forEach(row => {
                const quantity = parseFloat(row.querySelector('input[name="quantity[]"]').value) || 0;
                const hargaPengajuan = parseFloat(row.querySelector('input[name="harga_pengajuan[]"]').value) || 0;

                if (quantity <= 0) {
                    isValid = false;
                    alert('Quantity harus lebih dari 0.');
                }

                if (hargaPengajuan <= 0) {
                    isValid = false;
                    alert('Harga pengajuan harus diisi.');
                }
            });

            if (!isValid) e.preventDefault(); // Batalkan submit jika tidak valid
        });
    });
</script>