<head>
    <!-- Tambahkan favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('Dashbyte/HTML/dist/assets/img/U_P.png')}}">
    <!-- Jika layout.admin punya bagian head -->
</head>
@extends('layout.admin')
<div class="main main-app p-3 p-lg-4">
    <div class="card shadow-sm p-lg-4">
        <p class="fs-5 fw-bold">Tracking Persetujuan Barang</p>

        <!-- Progress Bar -->
        <div class="progress mb-4">
            @php
            // Hitung jumlah langkah yang sudah disetujui
            $approvedCount = $approvals->where('is_approved', true)->count();
            $totalSteps = $approvals->count();
            $progressPercentage = $totalSteps > 0 ? ($approvedCount / $totalSteps) * 100 : 0;
            @endphp
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                style="width: {{ $progressPercentage }}%;" aria-valuenow="{{ $progressPercentage }}" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>

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

        <!-- Status Keseluruhan -->
        <div class="mt-4">
            <p class="fw-bold">Status:
                <span class="
                        {{ $purchaseRequest->status_berkas === 'approved' ? 'text-success' : '' }}
                        {{ $purchaseRequest->status_berkas === 'rejected' ? 'text-danger' : '' }}
                        {{ $purchaseRequest->status_berkas === 'process' ? 'text-primary' : '' }}">
                    {{ ucfirst($purchaseRequest->status_berkas) }}
                </span>
            </p>
        </div>
        <a href="javascript:history.back()"
            class="btn btn-secondary d-flex align-items-middle justify-content-center gap-2">
            <i class="ri-arrow-left-line"></i> Kembali
        </a>
    </div>
</div>

<!-- CSS untuk Progress Bar -->
<style>
    .step-progress {
        display: flex;
        justify-content: space-between;
        position: relative;
        gap: 20px;
    }

    .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .step-icon {
        width: 50px;
        height: 50px;
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
        background: #dc3545;
        color: #fff;
    }

    .step.rejected .step-icon::after {
        content: '✗';
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
    }
</style>