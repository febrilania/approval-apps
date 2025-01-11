<?php

namespace App\Http\Controllers;

use App\Models\AkunAnggaran;
use App\Models\Item;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    // public function update(Request $request, $id)
    // {

    //     // Validasi data
    //     $request->validate([
    //         'pengajuan' => 'required|numeric|min:0',
    //         'pembelian' => 'required|numeric|min:0',
    //         'item_id.*' => 'required|exists:items,id',
    //         'quantity.*' => 'required|numeric|min:1',
    //         'harga_pengajuan.*' => 'required|numeric|min:0',
    //         'harga_pembelian.*' => 'nullable|numeric|min:0',
    //         'file_nota' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    //         'detail_id.*' => 'nullable|exists:purchase_requests_detail,id,purchase_request_id,' . $id, // Memastikan detail_id hanya ada untuk purchase_request yang sama

    //     ]);

    //     DB::beginTransaction();
    //     try {
    //         // Cari Purchase Request
    //         $purchaseRequest = PurchaseRequest::findOrFail($id);

    //         // Update Purchase Request
    //         $purchaseRequest->pengajuan = $request->pengajuan;
    //         $purchaseRequest->pembelian = $request->pembelian;

    //         // Simpan file jika ada
    //         if ($request->hasFile('file_nota')) {
    //             if ($purchaseRequest->file_nota) {
    //                 Storage::delete($purchaseRequest->file_nota); // Hapus file lama
    //             }
    //             $path = $request->file('file_nota')->store('notas'); // Simpan file baru
    //             $purchaseRequest->file_nota = $path;
    //         }

    //         $purchaseRequest->save();

    //         // Handle penghapusan detail
    //         $existingDetailIds = $request->detail_id ?? [];
    //         $deletedDetails = PurchaseRequestDetail::where('purchase_request_id', $purchaseRequest->id)
    //             ->whereNotIn('id', $existingDetailIds)
    //             ->delete();

    //         // Loop untuk menyimpan atau mengupdate detail
    //         foreach ($request->item_id as $key => $itemId) {
    //             $detailId = $request->detail_id[$key] ?? null;
    //             PurchaseRequestDetail::updateOrCreate(
    //                 ['id' => $detailId], // Update jika detail_id ada
    //                 [
    //                     'purchase_request_id' => $purchaseRequest->id,
    //                     'item_id' => $itemId,
    //                     'quantity' => $request->quantity[$key],
    //                     'status_barang' => $request->status_barang[$key],
    //                     'alasan_pembelian' => $request->alasan_pembelian[$key],
    //                     'rencana_penempatan' => $request->rencana_penempatan[$key],
    //                     'akun_anggaran_id' => $request->akun_anggaran_id[$key],
    //                     'harga_pengajuan' => $request->harga_pengajuan[$key],
    //                     'harga_pengajuan_total' => $request->harga_pengajuan_total[$key],
    //                     'harga_pembelian' => $request->harga_pembelian[$key],
    //                     'harga_total' => $request->harga_total[$key],
    //                     'catatan' => $request->catatan[$key],
    //                 ]
    //             );
    //         }

    //         DB::commit(); // Commit perubahan
    //         return redirect()->back()->with('success', 'Purchase Request berhasil diupdate.');
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Rollback jika terjadi kesalahan
    //         return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
    //     }
    // }
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Cari Purchase Request
            $purchaseRequest = PurchaseRequest::findOrFail($id);

            // Update Purchase Request
            $purchaseRequest->pengajuan = $request->pengajuan;
            $purchaseRequest->pembelian = $request->pembelian;

            // Simpan file jika ada
            if ($request->hasFile('file_nota')) {
                if ($purchaseRequest->file_nota) {
                    Storage::delete($purchaseRequest->file_nota); // Hapus file lama
                }
                $path = $request->file('file_nota')->store('notas'); // Simpan file baru
                $purchaseRequest->file_nota = $path;
            }

            $purchaseRequest->save();

            // Handle penghapusan detail
            $existingDetailIds = $request->detail_id ?? [];
            PurchaseRequestDetail::where('purchase_request_id', $purchaseRequest->id)
                ->whereNotIn('id', $existingDetailIds)
                ->delete();

            // Loop untuk menyimpan atau mengupdate detail
            foreach ($request->item_id as $key => $itemId) {
                $detailId = $request->detail_id[$key] ?? null;
                PurchaseRequestDetail::updateOrCreate(
                    ['id' => $detailId], // Update jika detail_id ada
                    [
                        'purchase_request_id' => $purchaseRequest->id,
                        'item_id' => $itemId,
                        'quantity' => $request->quantity[$key],
                        'status_barang' => $request->status_barang[$key],
                        'alasan_pembelian' => $request->alasan_pembelian[$key],
                        'rencana_penempatan' => $request->rencana_penempatan[$key],
                        'akun_anggaran_id' => $request->akun_anggaran_id[$key],
                        'harga_pengajuan' => $request->harga_pengajuan[$key],
                        'harga_pengajuan_total' => $request->harga_pengajuan_total[$key],
                        'harga_pembelian' => $request->harga_pembelian[$key],
                        'harga_total' => $request->harga_total[$key],
                        'catatan' => $request->catatan[$key],
                    ]
                );
            }

            DB::commit(); // Commit perubahan
            return redirect()->back()->with('success', 'Purchase Request berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi kesalahan
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
