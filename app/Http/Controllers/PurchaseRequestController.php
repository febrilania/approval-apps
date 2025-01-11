<?php

namespace App\Http\Controllers;

use App\Models\AkunAnggaran;
use App\Models\Item;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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

    public function deletePurchaseRequest($id) {
        $purchase_request = PurchaseRequest::findOrFail($id);
        if($purchase_request->status_berkas !== 'draft') {
            return redirect()->back()->with('error', 'Purchase request tidak bisa dihapus karena sudah dalam proses pengajuan.');
        }else{
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

}
