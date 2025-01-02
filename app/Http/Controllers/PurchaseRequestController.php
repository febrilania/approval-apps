<?php

namespace App\Http\Controllers;

use App\Models\AkunAnggaran;
use App\Models\Item;
use App\Models\PurchaseRequest;
use App\Models\PurchaseRequestDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PurchaseRequestController extends Controller
{
    public function index()
    {
        $requestor_id = PurchaseRequest::with('user')->get();
        $purchase_requests = PurchaseRequest::all();
        if (Auth::user()->role_id === 1) {
            return view('admin/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif (Auth::user()->role_id === 2) {
            return view('user/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif (Auth::user()->role_id === 3) {
            return view('sarpras/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif (Auth::user()->role_id === 4) {
            return view('perencanaan/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif (Auth::user()->role_id === 5) {
            return view('pengadaan/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        } elseif (Auth::user()->role_id === 6) {
            return view('warek/purchaseRequest', compact('purchase_requests', 'requestor_id'));
        }
    }

    // public function addPurchaseRequest(Request $request)
    // {
    //     $requestor = Auth::user();
    //     $validatedData = Validator::make($request->all(), [
    //         'pengajuan' => 'required|numeric',          // Menggunakan 'numeric' untuk angka
    //         'pembelian' => 'nullable|numeric',          // Menggunakan 'numeric' untuk angka
    //         'file_nota' => 'nullable|mimes:pdf',        // 'mimes:pdf' untuk validasi file PDF
    //         'status_berkas' => 'nullable|string|in:pending,approved,rejected' // Menggunakan 'in' untuk validasi enum manual
    //     ]);

    //     if ($validatedData->fails()) return redirect()->back()->withInput()->withErrors($validatedData);

    //     // Atur nilai default secara manual jika 'status_berkas' tidak ada
    //     if (!$request->has('status_berkas')) {
    //         $validatedData['status_berkas'] = 'pending';
    //     }

    //     $requestor_id = $requestor->id;

    //     $data['requestor_id'] = $request->requestor_id;
    //     $data['pengajuan'] = $request->pengajuan;
    //     $data['pembelian'] = $request->pembelian;
    //     $data['file_nota'] = $request->file_nota;
    //     $data['status_berkas'] = $request->status_berkas;

    //     PurchaseRequest::create($data);

    //     return redirect('admin/purchaseRequest')->with(['success' => 'Data berhasil ditambahkan']);
    // }

    // public function addPurchaseRequest(Request $request, $id = null)
    // {

    //     $requestor = Auth::user();
    //     $lock = date("dmyhis");
    //     $purchase_request_id = PurchaseRequest::find($id);
    //     if (!$purchase_request_id) {
    //         $purchaseRequest = PurchaseRequest::create([
    //             'requestor_id' => $requestor->id,
    //             'pengajuan' => 0,
    //             'pembelian' => 0,
    //             'status_berkas' => 'draft',
    //             'file_nota' => null, // Kolom file_nota diset null secara default
    //             'lock' => $lock,
    //         ]);
    //     }
    // }

    // public function addDetailPurchaseRequestForm()
    // {
    //     $items = Item::all();
    //     $akun_anggaran = AkunAnggaran::all();
    //     return view('admin/detailPurchaseRequestForm', compact('items', 'akun_anggaran'));
    // }
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

    public function deletePurchaseRequest() {}

    public function submitAjukan($id)
    {
        // $idRequest =  PurchaseRequest::findOrFail($id);
        // if ($idRequest->status_berkas === 'draft') {
        //     $idRequest->status_berkas = 'process';
        //     $idRequest->save();
        //     return redirect()->back()->with('success', 'Purchase request berhasil diajukan.');
        // }
        // return redirect()->back()->with('error', 'Purchase request tidak bisa diajukan.');
        $idRequest =  PurchaseRequest::findOrFail($id);
        if ($idRequest->status_berkas !== 'draft') {
            return redirect()->back()->with('error', 'Purchase request tidak bisa diajukan karena sudah dalam proses pengajuan.');
        }

        $idRequest->status_berkas = 'process';
        $idRequest->save();


        return redirect()->back()->with('success', 'Purchase request berhasil diajukan.');
    }
}
