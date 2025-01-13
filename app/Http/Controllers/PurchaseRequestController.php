<?php

namespace App\Http\Controllers;

use App\Models\AkunAnggaran;
use App\Models\Item;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;



class PurchaseRequestController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // ID user yang sedang login
        $roleId = Auth::user()->role_id; // ID role user yang sedang login

        // Pembuat request dan admin bisa melihat semua request mereka berdasarkan requestor_id
        if ($roleId === 1 || $roleId === 2) {
            // Gunakan relasi untuk mendapatkan purchase request berdasarkan requestor_id
            $purchase_requests = PurchaseRequest::whereHas('user', function ($query) use ($userId) {
                $query->where('id', $userId); // Memastikan hanya request yang dibuat oleh user yang terlihat
            })->with('user', 'approvals')->get();
        } else {
            // Approver hanya bisa melihat purchase request yang menjadi giliran mereka
            $purchase_requests = PurchaseRequest::whereHas('approvals', function ($query) use ($userId) {
                $query->where('approver_id', $userId)
                    ->where('is_current_stage', true);
            })->with('user', 'approvals')->get();
        }

        // Ambil informasi requestor (jika diperlukan untuk view)
        $requestor_id = PurchaseRequest::with('user')->get();

        // Arahkan ke view sesuai role user
        if ($roleId === 1) { // Admin
            return view('admin/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif ($roleId === 2) { // Pembuat request
            return view('user/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif ($roleId === 3) { // Sarpras
            return view('sarpras/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif ($roleId === 4) { // Perencanaan
            return view('perencanaan/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif ($roleId === 5) { // Pengadaan
            return view('pengadaan/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif ($roleId === 6) { // Warek
            return view('warek/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        }
    }

    public function showPurchaseRequestForm()
    {
        // Hapus ID purchase request dari session jika pertama kali masuk form
        session()->forget('purchase_request_id');

        $items = Item::all();
        $akun_anggaran = AkunAnggaran::all();

        // Jangan ambil purchase request dari sebelumnya jika session sudah dihapus
        $purchaseRequest = null;
        $details = [];

        return view('admin.detailPurchaseRequestForm', [
            'items' => $items,
            'akun_anggaran' => $akun_anggaran,
            'purchaseRequest' => $purchaseRequest,
            'details' => $details
        ]);
    }

    public function addPurchaseRequest(Request $request)
    {
        $requestor = Auth::user();

        // Ambil purchase_request_id dari session
        $purchase_request_id = session('purchase_request_id');

        // Jika belum ada purchase request, buat yang baru
        if (!$purchase_request_id) {
            $purchaseRequest = PurchaseRequest::create([
                'requestor_id' => $requestor->id,
                'pengajuan' => 0,
                'pembelian' => 0,
                'status_berkas' => 'draft',
                'file_nota' => null,
            ]);

            // Simpan ID purchase request ke session
            session(['purchase_request_id' => $purchaseRequest->id]);
        } else {
            // Ambil purchase request yang sedang aktif
            $purchaseRequest = PurchaseRequest::find($purchase_request_id);
        }

        // Tambahkan detail ke purchase request
        $detail = PurchaseRequestDetail::create([
            'purchase_request_id' => $purchaseRequest->id,
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'status_barang' => 'pending',
            'alasan_pembelian' => $request->alasan_pembelian,
            'rencana_penempatan' => $request->rencana_penempatan,
            'akun_anggaran_id' => $request->akun_anggaran_id,
            'harga_pengajuan' => $request->harga_pengajuan,
            'harga_pengajuan_total' => $request->harga_pengajuan * $request->quantity,
            'catatan' => $request->catatan ?? '',
        ]);

        // Kirim respons JSON ke client (AJAX)
        return response()->json([
            'item_name' => $detail->item->item_name,
            'quantity' => $detail->quantity,
            'harga_pengajuan' => $detail->harga_pengajuan,
            'alasan_pembelian' => $detail->alasan_pembelian,
            'rencana_penempatan' => $detail->rencana_penempatan,
            'catatan' => $detail->catatan,
            'akun_anggaran_name' => $detail->akunAnggaran ? $detail->akunAnggaran->nama_akun : '-',
        ]);
    }

    public function storeDetailPurchaseRequest(Request $request, $purchaseRequestId)
    {
        // Hitung total harga pengajuan
        $harga_pengajuan_total = $request->input('quantity') * $request->input('harga_pengajuan');

        // Buat detail baru yang terkait dengan purchase request
        PurchaseRequestDetail::create([
            'purchase_request_id' => $purchaseRequestId,
            'item_id' => $request->input('item_id'),
            'quantity' => $request->input('quantity'),
            'status_barang' => 'pending',
            'alasan_pembelian' => $request->input('alasan_pembelian'),
            'rencana_penempatan' => $request->input('rencana_penempatan'),
            'akun_anggaran_id' => $request->input('akun_anggaran_id'),
            'harga_pengajuan' => $request->input('harga_pengajuan'),
            'harga_pengajuan_total' => $harga_pengajuan_total,
            'catatan' => $request->input('catatan', ''),
        ]);
    }

    public function deletePurchaseRequest($id)
    {
        $purchase_request = PurchaseRequest::findOrFail($id);
        if ($purchase_request->status_berkas !== 'draft') {
            return redirect()->back()->with('error', 'Purchase request tidak bisa dihapus karena sudah dalam proses pengajuan.');
        } else {
            $purchase_request->delete();
            return redirect()->back()->with('success', 'Purchase request berhasil dihapus.');
        }
    }

    public function submitAjukan($id)
    {
        $idRequest =  PurchaseRequest::findOrFail($id);
        if ($idRequest->status_berkas !== 'draft') {
            return redirect()->back()->with('error', 'Purchase request tidak bisa diajukan karena sudah dalam proses pengajuan.');
        } else if ($idRequest->status_berkas == 'rejected') {
            return redirect()->back()->with('error', 'berkas pengajuan telah ditolak');
        }

        $idRequest->status_berkas = 'process';
        $idRequest->save();

        $stages = [
            ['approver_id' => 2, 'stage' => 1, 'is_current_stage' => true],
            ['approver_id' => 3, 'stage' => 2, 'is_current_stage' => false],
            ['approver_id' => 4, 'stage' => 3, 'is_current_stage' => false],
            ['approver_id' => 5, 'stage' => 4, 'is_current_stage' => false],
            ['approver_id' => 4, 'stage' => 5, 'is_current_stage' => false],
            ['approver_id' => 3, 'stage' => 6, 'is_current_stage' => false],
            ['approver_id' => 2, 'stage' => 7, 'is_current_stage' => false],
        ];

        foreach ($stages as $stageData) {
            $idRequest->approvals()->create($stageData);
        }


        return redirect()->back()->with('success', 'Purchase request berhasil diajukan.');
    }

    public function formEdit($id)
    {
        // Mencari PurchaseRequest berdasarkan ID
        $purchaseRequest = PurchaseRequest::findOrFail($id);

        // Mengambil semua data Item dan Akun Anggaran
        $items = Item::all();
        $akun_anggaran = AkunAnggaran::all();

        // Mengambil detail PurchaseRequest berdasarkan purchase_request_id
        $details = PurchaseRequestDetail::where('purchase_request_id', $id)->get();

        // Mengirimkan data ke view
        return view('admin.formEditPR', compact('items', 'akun_anggaran', 'purchaseRequest', 'details'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'pengajuan' => 'nullable|numeric|min:0',
            'pembelian' => 'nullable|numeric|min:0',
            'file_nota' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'item_id.*' => 'required|exists:items,id',
            'quantity.*' => 'required|numeric|min:1',
            'status_barang.*' => 'required|string|in:pending,approved,rejected',
            'alasan_pembelian.*' => 'nullable|string',
            'rencana_penempatan.*' => 'nullable|string',
            'akun_anggaran_id.*' => 'nullable|exists:akun_anggaran,id',
            'harga_pengajuan.*' => 'nullable|numeric|min:0',
            'harga_pembelian.*' => 'nullable|numeric|min:0',
            'catatan.*' => 'nullable|string',
        ]);

        $purchaseRequest = PurchaseRequest::findOrFail($id);

        // Update file nota jika ada
        if ($request->hasFile('file_nota')) {
            // Hapus file lama jika ada
            if ($purchaseRequest->file_nota) {
                Storage::disk('public')->delete($purchaseRequest->file_nota);
            }

            // Simpan file ke disk publik
            $filePath = $request->file('file_nota')->store('notas', 'public');
            $purchaseRequest->file_nota = $filePath;
        }

        // Update data utama Purchase Request
        $purchaseRequest->pengajuan = $request->input('pengajuan');
        $purchaseRequest->pembelian = $request->input('pembelian');
        $purchaseRequest->save();

        // Update detail Purchase Request
        $detailIds = $request->input('detail_id', []);
        $itemIds = $request->input('item_id', []);
        $quantities = $request->input('quantity', []);
        $statusBarangs = $request->input('status_barang', []);
        $alasanPembelians = $request->input('alasan_pembelian', []);
        $rencanaPenempatans = $request->input('rencana_penempatan', []);
        $akunAnggaranIds = $request->input('akun_anggaran_id', []);
        $hargaPengajuans = $request->input('harga_pengajuan', []);
        $hargaPengajuanTotals = $request->input('harga_pengajuan_total', []);
        $hargaPembelians = $request->input('harga_pembelian', []);
        $hargaTotals = $request->input('harga_total', []);
        $catatans = $request->input('catatan', []);

        foreach ($itemIds as $index => $itemId) {
            if (!empty($detailIds[$index])) {
                // Jika detail_id ada, update data yang sudah ada
                $detail = PurchaseRequestDetail::findOrFail($detailIds[$index]);
            } else {
                // Jika detail_id kosong, buat entri baru
                $detail = new PurchaseRequestDetail();
                $detail->purchase_request_id = $purchaseRequest->id;
            }

            $detail->item_id = $itemId;
            $detail->quantity = $quantities[$index];
            $detail->status_barang = $statusBarangs[$index];
            $detail->alasan_pembelian = $alasanPembelians[$index];
            $detail->rencana_penempatan = $rencanaPenempatans[$index];
            $detail->akun_anggaran_id = $akunAnggaranIds[$index] ?? null;
            $detail->harga_pengajuan = $hargaPengajuans[$index];
            $detail->harga_pengajuan_total = $hargaPengajuanTotals[$index];
            $detail->harga_pembelian = $hargaPembelians[$index];
            $detail->harga_total = $hargaTotals[$index];
            $detail->catatan = $catatans[$index];

            $detail->save();
        }

        return redirect()->back()->with('success', 'Purchase Request berhasil diupdate.');
    }
    public function deleteDetail($purchaseRequestId, $detailId)
    {
        // Temukan purchase request dan detail yang ingin dihapus
        $purchaseRequest = PurchaseRequest::findOrFail($purchaseRequestId);
        $detail = $purchaseRequest->purchaseRequestDetails()->findOrFail($detailId);

        // Hapus detail tersebut
        $detail->delete();

        return redirect()->route('formEditPurchaseRequestAdmin', $purchaseRequestId)
            ->with('success', 'Detail Purchase Request berhasil dihapus.');
    }

    public function showPR($id)
    {
        $purchase_request = PurchaseRequest::with(['purchaseRequestDetails.item', 'purchaseRequestDetails.akunAnggaran'])->findOrFail($id);
        // dd($purchase_request);

        return view('admin/showPR', compact('purchase_request'));
    }
}
