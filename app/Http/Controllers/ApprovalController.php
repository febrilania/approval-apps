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
    // public function approve($purchase_request_id)
    // {
    //     $approver = Auth::user();
    //     $currentstage = Approval::where('purchase_request_id', $purchase_request_id)->where('is_current_stage', true)->first();

    //     if ($currentstage && $approver) {
    //         $currentstage->is_approved = true;
    //         $currentstage->approved_at = now();
    //         $currentstage->is_current_stage = false;
    //         $currentstage->save();

    //         ApprovalLog::create([
    //             'approval_id' => $currentstage->id,
    //             'status' => 'approved',
    //             'catatan' => null
    //         ]);

    //         $nextStage = Approval::where('purchase_request_id', $purchase_request_id)
    //             ->where('stage', $currentstage->stage + 1)
    //             ->first();

    //         if ($nextStage) {
    //             $nextStage->is_current_stage = true;
    //             $nextStage->save();
    //         } else {
    //             // Jika tidak ada tahap berikutnya, berarti proses selesai
    //             $currentstage->request->update(['status' => 'selesai']);
    //         }

    //         dd('ini current stage', $currentstage);
    //     }
    // }
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
                // Jika tidak ada tahap berikutnya, berarti proses selesai
                $currentstage->request->update(['status' => 'selesai']);
            }

            // Flash message untuk menunjukkan bahwa request telah disetujui
            return redirect()->back()->with('success', 'Request telah disetujui.');
        }

        // Jika tidak ditemukan stage atau approver, kembalikan error
        return redirect()->back()->with('error', 'Gagal menyetujui request.');
    }
}
