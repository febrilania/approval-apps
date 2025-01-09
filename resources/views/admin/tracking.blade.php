@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Tracking Persetujuan Barang</p>

        <!-- Progress Bar -->
        <div class="progress-bar-container">
            <div class="step-progress">
                @foreach ($approvals as $approval)
                @php
                $stepClass = '';
                if ($approval->is_current_stage) {
                $stepClass = 'active';
                } elseif ($approval->is_approved) {
                $stepClass = 'completed';
                } elseif ($approval->is_approved == false && $approval->approved_at != null) {
                $stepClass = 'rejected';
                } else {
                $stepClass = 'pending';
                }
                @endphp
                <div class="step {{ $stepClass }}">
                    <div class="step-icon">{{ $loop->iteration }}</div>
                    <p>{{ $approval->stage }}</p>
                    @if ($approval->is_approved)
                    <small>{{ $approval->user->name }}</small>
                    <small class="text-success">Disetujui</small>
                    @elseif ($approval->is_approved == false && $approval->approved_at != null)
                    <small>{{ $approval->user->name }}</small>
                    <small class="text-danger">Ditolak</small>
                    @else
                    <small>{{ $approval->user->name }}</small>
                    <small class="text-warning">Pending</small>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Status Keseluruhan -->
        <div class="mt-4">
            <p class="fw-bold">Status:
                <span class="
                        {{ $purchaseRequest->status_berkas === 'approved' ? 'text-success' : '' }}
                        {{ $purchaseRequest->status_berkas === 'rejected' ? 'text-danger' : '' }}
                        {{ $purchaseRequest->status_berkas === 'pending' ? 'text-primary' : '' }}">
                    {{ ucfirst($purchaseRequest->status_berkas) }}
                </span>
            </p>
        </div>
    </div>
</div>

<!-- CSS untuk Progress Bar -->
<style>
    .progress-bar-container {
        max-width: 100%;
        margin: 20px 0;
    }

    .step-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .step-progress::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 4px;
        background: #e9ecef;
        transform: translateY(-50%);
        z-index: 1;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 2;
        flex: 1;
    }

    .step-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .step.completed .step-icon {
        background: #198754;
        color: #fff;
    }

    .step.completed .step-icon::after {
        content: '✓';
    }

    .step.pending .step-icon {
        background: #ffc107;
        color: #000;
    }

    .step.active .step-icon {
        background: #0d6efd;
        color: #fff;
    }

    .step.rejected .step-icon {
        background: #dc3545 !important;
        /* Warna merah */
        color: #fff !important;
    }

    .step.rejected .step-icon::after {
        content: '✗' !important;
        /* Icon silang */
    }


    .step p {
        margin: 0;
        font-size: 14px;
        color: #6c757d;
        text-align: center;
    }

    .step small {
        display: block;
        font-size: 12px;
        color: #6c757d;
        text-align: center;
    }

    .step small.text-danger {
        color: #dc3545;
        /* Warna teks merah untuk status ditolak */
    }
</style>