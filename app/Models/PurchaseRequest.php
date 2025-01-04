<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requestor_id',
        'status_berkas',
        'file_nota',
        'pengajuan',
        'pembelian',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }
    public function purchaseRequestDetails()
    {
        return $this->hasMany(PurchaseRequestDetail::class, 'purchase_request_id');
    }
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'purchase_request_id');
    }
}
