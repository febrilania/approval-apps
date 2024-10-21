<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestDetail extends Model
{
    use HasFactory;
    protected $table = 'purchase_requests_detail';
    protected $fillable = [
        'purchase_request_id',
        'item_id',
        'quantity',
        'status_barang',
        'alasan_pembelian',
        'rencana_penempatan',
        'akun_anggaran_id',
        'harga_pengajuan',
        'harga_pengajuan_total',
        'harga_pembelian',
        'harga_total',
        'catatan'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function purchaseRequest()
    {
        return $this->belongsTo(PurchaseRequest::class, 'purchase_request_id');
    }

    public function akunAnggaran()
    {
        return $this->belongsTo(AkunAnggaran::class, 'akun_anggaran_id');
    }
}
