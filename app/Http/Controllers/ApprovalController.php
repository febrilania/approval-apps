<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\ApprovalLog;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{

    public function index($id)
    {
        $purchase_request = PurchaseRequest::findOrFail($id);
        return view('admin/approvals', compact('purchase_request'));
    }

    public function approve($purchase_request_id)
    {
        $approver = Auth::user();
        $currentstage = Approval::where('purchase_request_id', $purchase_request_id)
            ->where('is_current_stage', true)
            ->first();

        if ($currentstage && $approver) {
            // Tandai approval saat ini sebagai disetujui
            $currentstage->is_approved = true;
            $currentstage->approved_at = now();
            $currentstage->is_current_stage = false;
            $currentstage->save();

            // Buat log approval
            ApprovalLog::create([
                'approval_id' => $currentstage->id,
                'status' => 'approved',
                'catatan' => null
            ]);

            // Tentukan tahap berikutnya
            $nextStage = Approval::where('purchase_request_id', $purchase_request_id)
                ->where('stage', $currentstage->stage + 1)
                ->first();

            if ($nextStage) {
                // Tandai tahap berikutnya sebagai tahap saat ini
                $nextStage->is_current_stage = true;
                $nextStage->save();
            } else {
                // Jika tidak ada tahap berikutnya, cek apakah semua tahap sudah disetujui
                $allStagesApproved = Approval::where('purchase_request_id', $purchase_request_id)
                    ->where('is_approved', false)
                    ->doesntExist();

                if ($allStagesApproved) {
                    // Jika semua tahap sudah disetujui, update status berkas di tabel purchase request
                    $purchaseRequest = PurchaseRequest::find($purchase_request_id);
                    $purchaseRequest->status_berkas = 'approved';
                    $purchaseRequest->save();
                }
            }

            // Flash message untuk menunjukkan bahwa request telah disetujui
            return redirect()->back()->with('success', 'Request telah disetujui.');
        }

        // Jika tidak ditemukan stage atau approver, kembalikan error
        return redirect()->back()->with('error', 'Gagal menyetujui request.');
    }

    public function reject($purchase_request_id)
    {
        $rejecter = Auth::user();
        $currentstage = Approval::where('purchase_request_id', $purchase_request_id)->where('is_current_stage', true)->first();
        if ($rejecter && $currentstage) {
            $currentstage->is_approved = false;
            $currentstage->approved_at = now();
            $currentstage->is_current_stage = false;
            $currentstage->save();

            ApprovalLog::create([
                'approval_id' => $currentstage->id,
                'status' => 'rejected',
                'catatan' => null
            ]);
        }

        $purchaseRequest = PurchaseRequest::find($purchase_request_id);
        $purchaseRequest->status_berkas = 'rejected';
        $purchaseRequest->save();
        $approvals = Approval::where('purchase_request_id', $purchase_request_id)->get();
        return redirect()->back()->with('error', 'Request telah ditolak.');
    }

    public function tracking($purchase_request_id)
    {
        $purchaseRequest = PurchaseRequest::findOrFail($purchase_request_id);
        $approvals = Approval::with('user')
            ->where('purchase_request_id', $purchase_request_id)
            ->orderBy('created_at', 'asc')
            ->get();
        return view('admin/tracking', compact('approvals', 'purchaseRequest'));
    }
}
